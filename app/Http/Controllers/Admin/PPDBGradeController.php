<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\PPDBGrade;
use App\Models\ReportCard;
use App\Models\Subject;
use App\Models\StudentClass;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class PPDBGradecontroller extends Controller
{
    // Method untuk menampilkan daftar ijazah
    public function index(Request $request)
    {
        // Fungsi index tetap seperti aslinya
        $classes = StudentClass::all();
        $kelasFilter = $request->kelas;
        $keyword = $request->keyword;

        $students = Student::where(function ($query) use ($kelasFilter, $keyword) {
            if ($kelasFilter) {
                $query->where('kelas', $kelasFilter);
            }
            if ($keyword) {
                $query->where('nama', 'like', "%$keyword%")
                    ->orWhere('nis', 'like', "%$keyword%")
                    ->orWhere('nisn', 'like', "%$keyword%")
                    ->orWhere('kelas', 'like', "%$keyword%");
            }
        })->orderBy('kelas', 'asc')
            ->orderBy('nama', 'asc')
            ->get();

        return view('admin-pages.ppdb_grades.index', compact('students', 'classes', 'kelasFilter', 'keyword'));
    }

    public function show($studentId)
    {
        $student = Student::findOrFail($studentId);

        $relevantSemesters = ['Level 4 Semester 1', 'Level 4 Semester 2', 'Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1'];
        $semesterKeys = ['4.1', '4.2', '5.1', '5.2', '6.1'];

        $reportCards = ReportCard::where('student_id', $studentId)
            ->whereIn('semester', $relevantSemesters)
            ->with('subjects')
            ->get();

        // Cek kelengkapan data rapor per semester
        foreach ($relevantSemesters as $semester) {
            if (!$reportCards->contains('semester', $semester)) {
                return redirect()->back()->with(
                    'error',
                    "Data rapor {$semester} belum lengkap. Harap lengkapi data rapor terlebih dahulu. " .
                        "<a href='" . route('admin.report_cards.student_report', ['student' => $studentId]) . "'><br><b>Klik di sini</b></a> untuk menuju halaman rapor."
                );
            }
        }

        $ppdbGrade = PPDBGrade::firstOrCreate(['student_id' => $studentId]);

        $reportCardIds = $reportCards->pluck('id')->toArray();
        $ppdbGrade->update(['report_card_ids' => $reportCardIds]);

        // Sesuaikan subjectIds dengan kelompok yang diinginkan
        $subjectIds = [1, 3, 4, 5, 6];
        $subjects = Subject::whereIn('id', $subjectIds)->get();

        $totalJumlahNilai = 0;
        $averageSubjects = [];

        foreach ($subjectIds as $subjectId) {
            $nilaiSemesters = [];
            $jumlahNilai = 0;

            foreach ($relevantSemesters as $index => $semester) {
                $reportCard = $reportCards->firstWhere('semester', $semester);

                if ($reportCard) {
                    $subject = $reportCard->subjects->where('id', $subjectId)->first();
                    $nilai = $subject ? $subject->pivot->nilai : 0;
                } else {
                    $nilai = 0;
                }

                $nilaiSemesters[$semesterKeys[$index]] = $nilai;
                $jumlahNilai += $nilai;
            }

            $averageSubjects[$subjectId] = [
                'nilai' => $nilaiSemesters,
                'jumlah' => $jumlahNilai,
                'rata_rata' => count($relevantSemesters) > 0 ? $jumlahNilai / count($relevantSemesters) : 0,
            ];

            $totalJumlahNilai += $jumlahNilai;
        }

        // Hitung rata-rata total per mapel per semester
        $jumlahSemester = count($relevantSemesters);
        $totalAverage = 0;
        foreach ($averageSubjects as $subject) {
            $totalAverage += $subject['rata_rata'];
        }

        $ppdbGrade->update([
            'total_score' => $totalJumlahNilai,
            'total_average' => $totalAverage,
        ]);

        $schoolProfile = SchoolProfile::first();

        return view('admin-pages.ppdb_grades.show', compact(
            'ppdbGrade',
            'averageSubjects',
            'totalJumlahNilai',
            'totalAverage',
            'student',
            'subjects',
            'reportCards',
            'schoolProfile'
        ));
    }

    public function exportPdf($studentId)
    {
        $student = Student::findOrFail($studentId);

        $relevantSemesters = ['Level 4 Semester 1', 'Level 4 Semester 2', 'Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1'];
        $semesterKeys = ['4.1', '4.2', '5.1', '5.2', '6.1'];

        $reportCards = ReportCard::where('student_id', $studentId)
            ->whereIn('semester', $relevantSemesters)
            ->with('subjects')
            ->get();

        foreach ($relevantSemesters as $semester) {
            if (!$reportCards->contains('semester', $semester)) {
                return redirect()->back()->with(
                    'error',
                    "Data rapor {$semester} belum lengkap. Harap lengkapi data rapor terlebih dahulu. " .
                        "<a href='" . route('admin.report_cards.student_report', ['student' => $studentId]) . "'><br><b>Klik di sini</b></a> untuk menuju halaman rapor."
                );
            }
        }

        $reportCard = $reportCards->first();

        $ppdbGrade = PPDBGrade::firstOrCreate(['student_id' => $studentId]);

        $reportCardIds = $reportCards->pluck('id')->toArray();
        $ppdbGrade->update(['report_card_ids' => json_encode($reportCardIds)]);

        $subjectIds = [1, 3, 4, 5, 6]; // Sesuaikan dengan kelompok A
        $subjects = Subject::whereIn('id', $subjectIds)->get();

        $totalRataRata = 0;
        $totalJumlahNilai = 0;

        foreach ($subjectIds as $subjectId) {
            $nilaiSemesters = [];
            $jumlahNilai = 0;

            foreach ($relevantSemesters as $index => $semester) {
                $reportCard = $reportCards->firstWhere('semester', $semester);

                if ($reportCard) {
                    $subject = $reportCard->subjects->where('id', $subjectId)->first();
                    $nilai = $subject ? $subject->pivot->nilai : 0;
                } else {
                    $nilai = 0;
                }

                $nilaiSemesters[$semesterKeys[$index]] = $nilai;
                $jumlahNilai += $nilai;
            }

            $rataRata = count($relevantSemesters) > 0 ? $jumlahNilai / count($relevantSemesters) : 0;

            $averageSubjects[$subjectId] = [
                'nilai' => $nilaiSemesters,
                'jumlah' => $jumlahNilai,
                'rata_rata' => $rataRata
            ];

            $totalRataRata += $rataRata;
            $totalJumlahNilai += $jumlahNilai;
        }

        $ppdbGrade->update([
            'total_score' => $totalJumlahNilai,
            'total_average' => $totalRataRata, // ✅ Tidak dibagi lagi
        ]);

        // ✅ Ambil data sekolah dari tabel school_profile
        $schoolProfile = SchoolProfile::first(); // Jika hanya ada satu data, gunakan first()

        // Buat file PDF menggunakan view 'admin-pages.ppdb_grades.pdf'
        $pdf = Pdf::loadView('admin-pages.ppdb_grades.show-pdf', compact(
            'ppdbGrade',
            'averageSubjects',
            'student',
            'reportCards',
            'reportCard',
            'subjects',
            'schoolProfile'
        ));

        // Unduh file PDF
        return $pdf->stream('Surat Keterangan Nilai Rapor' . ' - ' . $student->nama . '.pdf');
    }
}
