<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\SchoolYear;
use App\Models\ReportCard;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportCardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil keyword dari request
        $keyword = $request->input('keyword');

        // Ambil class_id dari user yang sedang login (wali kelas)
        $classId = Auth::user()->class_id;  // Mengambil class_id dari user yang login

        // Filter siswa berdasarkan kelas dan keyword
        $students = Student::where('kelas', $classId)  // Pastikan 'kelas' adalah field di tabel students
            ->when($keyword, function ($query, $keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('nis', 'like', "%{$keyword}%")
                    ->orWhere('nisn', 'like', "%{$keyword}%");
            })
            ->orderBy('nama', 'asc')
            ->get();

        // Mengirim data siswa dan keyword ke view
        return view('user-pages.report_cards.class_report', compact('students', 'keyword'));
    }

    public function showStudentReport($studentId)
    {
        $student = Student::findOrFail($studentId);
        $reportCards = ReportCard::where('student_id', $studentId)
            ->orderBy('semester', 'asc') // Urutkan berdasarkan semester
            ->orderBy('tahun_ajar', 'asc') // Urutkan berdasarkan tahun ajar
            ->get();

        return view('user-pages.report_cards.student_report', compact('student', 'reportCards'));
    }


    public function create($studentId)
    {
        $student = Student::findOrFail($studentId);
        $subjects = Subject::all();
        $school_years = SchoolYear::all();

        return view('user-pages.report_cards.create', compact('student', 'subjects', 'school_years'));
    }

    public function store(Request $request, $studentId)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'semester' => 'required|in:Level 1 Semester 1,Level 1 Semester 2,Level 2 Semester 1,Level 2 Semester 2,Level 3 Semester 1,Level 3 Semester 2,Level 4 Semester 1,Level 4 Semester 2,Level 5 Semester 1,Level 5 Semester 2,Level 6 Semester 1,Level 6 Semester 2',
            'tahun_ajar' => 'required|string|max:20',
            'mata_pelajaran' => 'required|array',
            'mata_pelajaran.*' => 'nullable|numeric|min:0|max:100',
            'sakit' => 'nullable|numeric|min:0',
            'izin' => 'nullable|numeric|min:0',
            'alfa' => 'nullable|numeric|min:0',
            'prestasi' => 'nullable|array',
            'ket_prestasi' => 'nullable|array',
            'catatan' => 'nullable|string',
            'target' => 'nullable|array',
            'target.*' => 'nullable|string|max:255',
            'capaian' => 'nullable|array',
            'capaian.*' => 'nullable|string|max:255',
            'aplikasi' => 'nullable|array',
            'aplikasi.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Ambil data siswa berdasarkan ID
            $student = Student::findOrFail($studentId);

            // Simpan data rapor
            $reportCard = ReportCard::create([
                'student_id' => $studentId,
                'semester' => $validatedData['semester'],
                'tahun_ajar' => $validatedData['tahun_ajar'],
                'sakit' => $validatedData['sakit'],
                'izin' => $validatedData['izin'],
                'alfa' => $validatedData['alfa'],
                'prestasi' => !empty($validatedData['prestasi']) ? json_encode(array_filter($validatedData['prestasi'])) : null,
                'ket_prestasi' => !empty($validatedData['ket_prestasi']) ? json_encode(array_filter($validatedData['ket_prestasi'])) : null,
                'catatan' => $validatedData['catatan']
            ]);

            // Simpan nilai mata pelajaran ke tabel pivot
            if (!empty($validatedData['mata_pelajaran'])) {
                foreach ($validatedData['mata_pelajaran'] as $subjectId => $nilai) {
                    if (!is_null($nilai)) {
                        // Siapkan data 'details' dalam bentuk array untuk setiap mata pelajaran
                        $details = [
                            'target' => $validatedData['target'][$subjectId] ?? null,
                            'capaian' => $validatedData['capaian'][$subjectId] ?? null,
                            'aplikasi' => $validatedData['aplikasi'][$subjectId] ?? null,
                        ];

                        // Simpan ke pivot tabel dengan nilai dan details (JSON)
                        $reportCard->subjects()->attach($subjectId, [
                            'nilai' => $nilai,
                            'details' => json_encode($details), // Simpan sebagai JSON
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('user.report_cards.student_report', ['student' => $student->id])
                ->with('success', 'Nilai rapor berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($studentId, $reportCardId)
    {
        // Ambil data siswa berdasarkan ID
        $student = Student::findOrFail($studentId);

        // Ambil data raport siswa berdasarkan ID
        $reportCard = ReportCard::where('student_id', $studentId)
            ->findOrFail($reportCardId);

        // Ambil semua mata pelajaran yang terkait dengan raport ini
        $subjects = $reportCard->subjects; // Tidak perlu `get()` lagi karena sudah otomatis terambil

        // Kirim data ke view
        return view('user-pages.report_cards.show', compact('student', 'reportCard', 'subjects'));
    }

    public function edit($id)
    {
        // Mengambil data report card dengan relasi subjects
        $reportCard = ReportCard::with(['subjects' => function ($query) {
            $query->select('subjects.id', 'subjects.nama'); // Pilih kolom yang diperlukan dari subjects
        }])->findOrFail($id);

        // Menyiapkan data pivot untuk mempermudah akses
        $pivotData = [];
        $nilai = []; // Inisialisasi array untuk menyimpan nilai

        foreach ($reportCard->subjects as $subject) {
            // Mengambil data details (json) dari pivot
            $details = json_decode($subject->pivot->details, true); // Mengambil sebagai array

            // Memasukkan nilai untuk mata pelajaran
            $nilai[$subject->id] = $subject->pivot->nilai; // Ambil nilai dari pivot

            $pivotData[$subject->id] = [
                'target' => $details['target'] ?? '',
                'capaian' => $details['capaian'] ?? '',
                'aplikasi' => $details['aplikasi'] ?? '',
            ];
        }

        // Data lainnya
        $student = $reportCard->student;
        $subjects = Subject::all();
        $school_years = SchoolYear::all();
        $semester = $reportCard->semester; // Pastikan semester juga ada

        // Mengirimkan data ke view
        return view('user-pages.report_cards.edit', compact('reportCard', 'student', 'subjects', 'school_years', 'pivotData', 'nilai', 'semester'));
    }

    public function update(Request $request, $studentId, $reportCardId)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'semester' => 'required|in:Level 1 Semester 1,Level 1 Semester 2,Level 2 Semester 1,Level 2 Semester 2,Level 3 Semester 1,Level 3 Semester 2,Level 4 Semester 1,Level 4 Semester 2,Level 5 Semester 1,Level 5 Semester 2,Level 6 Semester 1,Level 6 Semester 2',
            'tahun_ajar' => 'required|string|max:20',
            'mata_pelajaran' => 'required|array',
            'mata_pelajaran.*' => 'nullable|numeric|min:0|max:100',
            'sakit' => 'nullable|numeric|min:0',
            'izin' => 'nullable|numeric|min:0',
            'alfa' => 'nullable|numeric|min:0',
            'prestasi' => 'nullable|array',
            'ket_prestasi' => 'nullable|array',
            'catatan' => 'nullable|string',
            'target' => 'nullable|array',
            'target.*' => 'nullable|string|max:255',
            'capaian' => 'nullable|array',
            'capaian.*' => 'nullable|string|max:255',
            'aplikasi' => 'nullable|array',
            'aplikasi.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Ambil data rapor berdasarkan ID
            $reportCard = ReportCard::findOrFail($reportCardId);

            // Update data rapor utama
            $reportCard->update([
                'semester' => $validatedData['semester'],
                'tahun_ajar' => $validatedData['tahun_ajar'],
                'sakit' => $validatedData['sakit'],
                'izin' => $validatedData['izin'],
                'alfa' => $validatedData['alfa'],
                'prestasi' => !empty($validatedData['prestasi']) ? json_encode(array_filter($validatedData['prestasi'])) : null,
                'ket_prestasi' => !empty($validatedData['ket_prestasi']) ? json_encode(array_filter($validatedData['ket_prestasi'])) : null,
                'catatan' => $validatedData['catatan'],
            ]);

            if (!empty($validatedData['mata_pelajaran'])) {
                $syncData = [];
                foreach ($validatedData['mata_pelajaran'] as $subjectId => $nilai) {
                    if (!is_null($nilai)) {
                        $syncData[$subjectId] = [
                            'nilai' => $nilai,
                            'details' => json_encode(array_filter([
                                'target' => $validatedData['target'][$subjectId] ?? null,
                                'capaian' => $validatedData['capaian'][$subjectId] ?? null,
                                'aplikasi' => $validatedData['aplikasi'][$subjectId] ?? null,
                            ])),
                        ];
                    }
                }
                $reportCard->subjects()->sync($syncData);
            }

            DB::commit();

            return redirect()->route('user.report_cards.student_report', ['student' => $studentId])
                ->with('success', 'Data rapor berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Cari data berdasarkan ID
            $reportCard = ReportCard::findOrFail($id);
            // Ambil ID siswa yang terkait dengan report card
            $studentId = $reportCard->student_id; // pastikan relasi ini sudah ada atau sesuaikan dengan struktur tabel Anda

            // Hapus data
            $reportCard->delete();

            // Redirect kembali ke halaman student_report siswa
            return redirect()->route('user.report_cards.student_report', ['student' => $studentId])
                ->with('success', 'Nilai Rapor berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function exportPdf($student_id, $reportCard_id)
    {
        // Ambil data siswa berdasarkan student_id
        $student = Student::find($student_id);

        // Pastikan data siswa ditemukan
        if (!$student) {
            abort(404, 'Siswa tidak ditemukan.');
        }

        // Ambil data rapor berdasarkan student_id dan reportCard_id
        $reportCard = ReportCard::where('student_id', $student_id)
            ->where('id', $reportCard_id)
            ->first();

        // Pastikan data rapor ditemukan
        if (!$reportCard) {
            abort(404, 'Rapor tidak ditemukan.');
        }

        // Logic untuk generate PDF
        $pdf = Pdf::loadView('user-pages.report_cards.show-pdf', compact('student', 'reportCard'));

        // Render PDF untuk preview di browser
        return $pdf->stream('Detail Rapor ' . $student->nama . ' - ' . $reportCard->semester . '.pdf');
    }
}
