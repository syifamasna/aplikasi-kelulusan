<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\SchoolYear;
use App\Models\ReportCard;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'semester' => 'required|numeric|min:0',
            'tahun_ajar' => 'required|string|max:20',
            'mata_pelajaran' => 'required|array',
            'mata_pelajaran.*' => 'nullable|numeric|min:0|max:100',
            'sakit' => 'nullable|numeric|min:0',
            'izin' => 'nullable|numeric|min:0',
            'alfa' => 'nullable|numeric|min:0',
            'prestasi' => 'nullable|array',
            'ket_prestasi' => 'nullable|array',
            'ekskul' => 'nullable|array',
            'nilai_ekskul' => 'nullable|array',
            'ket_ekskul' => 'nullable|array',
            'target' => 'required|array',
            'target.*' => 'required|string|max:255',
            'capaian' => 'required|array',
            'capaian.*' => 'required|string|max:255',
            'aplikasi' => 'required|array',
            'aplikasi.*' => 'required|string|max:255',
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
                'prestasi' => json_encode($validatedData['prestasi']),
                'ket_prestasi' => json_encode($validatedData['ket_prestasi']),
                'ekskul' => json_encode($validatedData['ekskul']),
                'nilai_ekskul' => json_encode($validatedData['nilai_ekskul']),
                'ket_ekskul' => json_encode($validatedData['ket_ekskul']),
            ]);

            // Simpan nilai mata pelajaran ke tabel pivot
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
                        'details' => json_encode($details),  // Simpan sebagai JSON
                    ]);
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

        // Mengirimkan data ke view
        return view('user-pages.report_cards.edit', compact('reportCard', 'student', 'subjects', 'school_years', 'pivotData', 'nilai'));
    }

    public function update(Request $request, $student_id, $report_card_id)
    {
        // Mencari ReportCard berdasarkan ID
        $reportCard = ReportCard::findOrFail($report_card_id);

        // Validasi data yang diterima
        $validatedData = $request->validate([
            'semester' => 'required|integer',
            'tahun_ajar' => 'required|string',
            'mata_pelajaran' => 'array|required',
            'sakit' => 'nullable|integer',
            'izin' => 'nullable|integer',
            'alfa' => 'nullable|integer',
            'prestasi' => 'nullable|array',
            'ket_prestasi' => 'nullable|array',
            'ekskul' => 'nullable|array',
            'nilai_ekskul' => 'nullable|array',
            'ket_ekskul' => 'nullable|array'
        ]);

        // Menyimpan atau memperbarui nilai untuk setiap mata pelajaran
        foreach ($validatedData['mata_pelajaran'] as $subject_id => $nilai) {
            // Mengupdate nilai di pivot table dan menambahkan data pivot untuk target, capaian, aplikasi (jika ada)
            $target = $request->input('target.' . $subject_id, '');
            $capaian = $request->input('capaian.' . $subject_id, '');
            $aplikasi = $request->input('aplikasi.' . $subject_id, '');

            $details = json_encode([
                'target' => $target,
                'capaian' => $capaian,
                'aplikasi' => $aplikasi
            ]);

            // Update pivot table untuk mata pelajaran tertentu
            $reportCard->subjects()->updateExistingPivot($subject_id, [
                'nilai' => $nilai,
                'details' => $details
            ]);
        }

        // Ambil data 'sakit', 'izin', 'alfa' dengan nilai default null jika tidak ada
        $sakit = $validatedData['sakit'] ?? null;
        $izin = $validatedData['izin'] ?? null;
        $alfa = $validatedData['alfa'] ?? null;

        // Update data lainnya seperti semester, tahun ajar, sakit, izin, alfa, dan ekstrakurikuler
        $reportCard->update([
            'semester' => $validatedData['semester'],
            'tahun_ajar' => $validatedData['tahun_ajar'],
            'sakit' => $validatedData['sakit'],
            'izin' => $validatedData['izin'],
            'alfa' => $validatedData['alfa'],
            'prestasi' => json_encode($validatedData['prestasi']),
            'ket_prestasi' => json_encode($validatedData['ket_prestasi']),
            'ekskul' => $validatedData['ekskul'] ? json_encode($validatedData['ekskul']) : null,
            'nilai_ekskul' => $validatedData['nilai_ekskul'] ? json_encode($validatedData['nilai_ekskul']) : null,
            'ket_ekskul' => $validatedData['ket_ekskul'] ? json_encode($validatedData['ket_ekskul']) : null
        ]);

        // Redirect kembali ke halaman rapor dengan pesan sukses
        return redirect()->route('user.report_cards.student_report', [$student_id])
            ->with('success', 'Data rapor berhasil diperbarui.');
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
}
