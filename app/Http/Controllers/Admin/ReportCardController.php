<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\SchoolYear;
use App\Models\ReportCard;
use App\Models\SchoolProfile;
use App\Models\Subject;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ReportCardController extends Controller
{
    public function index(Request $request)
    {
        $kelasFilter = $request->input('kelas');
        $keyword = $request->input('keyword');

        $query = Student::query();

        if ($kelasFilter) {
            $query->whereHas('studentClass', function ($query) use ($kelasFilter) {
                $query->where('kelas', $kelasFilter);
            });
        }

        if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhereHas('studentClass', function ($query) use ($keyword) {
                        $query->where('kelas', 'like', '%' . $keyword . '%');
                    });
            });
        }

        $students = $query->orderBy('kelas', 'asc')->orderBy('nama', 'asc')->get();
        $classes = StudentClass::all();

        return view('admin-pages.report_cards.class_report', compact('students', 'classes', 'kelasFilter', 'keyword'));
    }

    public function showStudentReport($studentId)
    {
        $student = Student::findOrFail($studentId);
        $reportCards = ReportCard::where('student_id', $studentId)
            ->orderBy('semester', 'asc') // Urutkan berdasarkan semester
            ->orderBy('tahun_ajar', 'asc') // Urutkan berdasarkan tahun ajar
            ->get();

        return view('admin-pages.report_cards.student_report', compact('student', 'reportCards'));
    }

    public function create($studentId)
    {
        $student = Student::findOrFail($studentId);
        $subjects = Subject::all();
        $school_years = SchoolYear::all();

        return view('admin-pages.report_cards.create', compact('student', 'subjects', 'school_years'));
    }

    public function store(Request $request, $studentId)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'semester' => 'required|in:Level 4 Semester 1,Level 4 Semester 2,Level 5 Semester 1,Level 5 Semester 2,Level 6 Semester 1,Level 6 Semester 2',
            'tahun_ajar' => 'required|string|max:20',
            'mata_pelajaran' => 'required|array', // memastikan mata pelajaran harus ada
            'mata_pelajaran.*' => 'required|numeric|min:0|max:100' // memastikan nilai tidak null dan di antara 0-100
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
            ]);

            // Simpan nilai mata pelajaran ke tabel pivot
            if (!empty($validatedData['mata_pelajaran'])) {
                foreach ($validatedData['mata_pelajaran'] as $subjectId => $nilai) {
                    // Simpan hanya nilai tanpa 'details'
                    $reportCard->subjects()->attach($subjectId, [
                        'nilai' => $nilai
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.report_cards.student_report', ['student' => $student->id])
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

        $schoolProfile = SchoolProfile::first();

        // Kirim data ke view
        return view('admin-pages.report_cards.show', compact('student', 'reportCard', 'subjects', 'schoolProfile'));
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
            // Memasukkan nilai untuk mata pelajaran
            $nilai[$subject->id] = $subject->pivot->nilai; // Ambil nilai dari pivot

            // Tidak ada lagi penggunaan details
            $pivotData[$subject->id] = [
                'nilai' => $subject->pivot->nilai, // Cukup ambil nilai
            ];
        }

        // Data lainnya
        $student = $reportCard->student;
        $subjects = Subject::all();
        $school_years = SchoolYear::all();
        $semester = $reportCard->semester; // Pastikan semester juga ada

        // Mengirimkan data ke view
        return view('admin-pages.report_cards.edit', compact('reportCard', 'student', 'subjects', 'school_years', 'pivotData', 'nilai', 'semester'));
    }

    public function update(Request $request, $studentId, $reportCardId)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'semester' => 'required|in:Level 4 Semester 1,Level 4 Semester 2,Level 5 Semester 1,Level 5 Semester 2,Level 6 Semester 1,Level 6 Semester 2',
            'tahun_ajar' => 'required|string|max:20',
            'mata_pelajaran' => 'required|array',
            'mata_pelajaran.*' => 'nullable|numeric|min:0|max:100'
        ]);

        DB::beginTransaction();

        try {
            // Ambil data rapor berdasarkan ID
            $reportCard = ReportCard::findOrFail($reportCardId);

            // Update data rapor utama
            $reportCard->update([
                'semester' => $validatedData['semester'],
                'tahun_ajar' => $validatedData['tahun_ajar'],
            ]);

            // Jika ada data mata pelajaran
            if (!empty($validatedData['mata_pelajaran'])) {
                $syncData = [];
                foreach ($validatedData['mata_pelajaran'] as $subjectId => $nilai) {
                    if (!is_null($nilai)) {
                        // Simpan nilai ke pivot tanpa 'details'
                        $syncData[$subjectId] = [
                            'nilai' => $nilai,  // Hanya nilai yang disimpan
                        ];
                    }
                }
                // Sinkronkan nilai pada pivot
                $reportCard->subjects()->sync($syncData);
            }

            DB::commit();

            return redirect()->route('admin.report_cards.student_report', ['student' => $studentId])
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
            return redirect()->route('admin.report_cards.student_report', ['student' => $studentId])
                ->with('success', 'Nilai Rapor berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        Log::info('Mulai proses impor rapor...');

        if (!$request->hasFile('file')) {
            Log::error('File tidak ditemukan.');
            return back()->with('error', 'File tidak ditemukan.');
        }

        $file = $request->file('file');
        Log::info('File ditemukan: ' . $file->getClientOriginalName());

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'semester' => 'required',
            'tahun_ajar' => 'required',
        ]);

        try {
            $path = $file->storeAs('temp', $file->getClientOriginalName());
            Log::info('File stored at: ' . $path);

            $spreadsheet = IOFactory::load(storage_path('app/' . $path));
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);
            Log::info('Total rows read: ' . count($rows));

            DB::beginTransaction();

            foreach ($rows as $key => $row) {
                if ($key == 1) continue; // Lewati header

                Log::info('Processing row: ' . json_encode($row));

                // CARI SISWA
                $student = Student::whereRaw("LOWER(TRIM(nama)) = ?", [strtolower(trim($row['B']))])
                    ->whereHas('studentClass', function ($query) use ($row) {
                        $query->whereRaw("LOWER(TRIM(kelas)) = ?", [strtolower(trim($row['C']))]);
                    })
                    ->first();

                if (!$student) {
                    Log::warning('Siswa tidak ditemukan: ' . trim($row['B']) . ' - Kelas: ' . trim($row['C']));
                    continue;
                }

                // BUAT REPORT CARD
                $reportCard = ReportCard::firstOrCreate([
                    'student_id' => $student->id,
                    'semester' => $request->semester,
                    'tahun_ajar' => $request->tahun_ajar,
                ]);

                Log::info('Report card ditemukan/dibuat untuk: ' . $student->nama);

                // DAFTAR MATA PELAJARAN DAN KOLOM DI EXCEL
                $subjects = [
                    'Pendidikan Agama Islam dan Budi Pekerti' => 'F',
                    'Pendidikan Pancasila' => 'G',
                    'Bahasa Indonesia' => 'H',
                    'Matematika' => 'I',
                    'Ilmu Pengetahuan Alam dan Sosial' => 'J',
                    'Pendidikan Jasmani, Olahraga dan Kesehatan' => 'K',
                    'Seni Budaya dan Prakarya' => 'L',
                    'Bahasa Inggris' => 'M',
                    'Bahasa dan Sastra Sunda' => 'N',
                    'Bahasa Arab' => 'O'
                ];

                $syncData = [];

                dd($syncData);

                foreach ($subjects as $subjectName => $column) {
                    $subject = Subject::whereRaw("LOWER(TRIM(nama)) = ?", [strtolower($subjectName)])->first();

                    if (!$subject) {
                        Log::warning("Mata pelajaran tidak ditemukan: {$subjectName}");
                        continue;
                    }

                    $nilai = isset($row[$column]) && is_numeric($row[$column]) ? intval($row[$column]) : null;

                    if ($nilai !== null && $nilai !== 0) {
                        $syncData[$subject->id] = ['nilai' => $nilai];
                        Log::info("Menambahkan nilai untuk {$subjectName}: {$nilai} (Siswa: {$student->nama})");
                    } else {
                        Log::warning("Nilai kosong atau nol untuk {$subjectName} (Siswa: {$student->nama})");
                    }
                }

                if (!empty($syncData)) {
                    Log::info("Syncing subjects for student {$student->nama}: " . json_encode($syncData));
                    $reportCard->subjects()->syncWithoutDetaching($syncData);
                } else {
                    Log::warning("Tidak ada data nilai yang valid untuk siswa: " . $student->nama);
                }
            }

            DB::commit();
            Log::info('Import berhasil');
            session()->flash('success', 'Data rapor berhasil diimpor.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Import gagal: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function exportPdf($student_id, $reportCard_id)
    {
        $student = Student::find($student_id);

        if (!$student) {
            abort(404, 'Siswa tidak ditemukan.');
        }

        $schoolProfile = SchoolProfile::first();
        $studentClass = StudentClass::where('kelas', $student->kelas)->first();

        $reportCard = ReportCard::where('student_id', $student_id)
            ->where('id', $reportCard_id)
            ->first();

        if (!$reportCard) {
            abort(404, 'Rapor tidak ditemukan.');
        }

        $pdf = Pdf::loadView('admin-pages.report_cards.show-pdf', compact(
            'student', 'reportCard', 'schoolProfile', 'studentClass'
        ));

        return $pdf->stream('Detail Rapor ' . $student->nama . ' - ' . $reportCard->semester . '.pdf');
    }
}
