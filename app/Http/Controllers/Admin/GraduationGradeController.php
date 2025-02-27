<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\GraduationGrade;
use App\Models\ReportCard;
use App\Models\Subject;
use App\Models\StudentClass;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class GraduationGradeController extends Controller
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

        return view('admin-pages.graduation_grades.index', compact('students', 'classes', 'kelasFilter', 'keyword'));
    }

    public function show($studentId)
    {
        // Ambil data siswa berdasarkan student_id
        $student = Student::findOrFail($studentId);

        $relevantSemesters = ['Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1', 'Level 6 Semester 2'];

        // Ambil semua ReportCard untuk student_id dan semester yang relevan
        $reportCards = ReportCard::where('student_id', $studentId)
            ->whereIn('semester', $relevantSemesters)
            ->get();

        // Cek apakah ada report card untuk semua semester yang relevan
        foreach ($relevantSemesters as $semester) {
            if (!$reportCards->contains('semester', $semester)) {
                return redirect()->back()->with(
                    'error',
                    "Data rapor {$semester} belum lengkap. Harap lengkapi data rapor terlebih dahulu. " .
                        "<a href='" . route('admin.report_cards.student_report', ['student' => $studentId]) . "'><br><b>Klik di sini</b></a> untuk menuju halaman rapor."
                );
            }
        }

        // Ambil report card pertama
        $reportCard = $reportCards->first();  // Menambahkan ini untuk mendefinisikan $reportCard

        // Ambil atau buat data GraduationGrade
        $graduationGrade = GraduationGrade::firstOrCreate(['student_id' => $studentId]);

        // Ambil ID reportCards yang relevan dan simpan dalam field report_card_ids sebagai JSON
        $reportCardIds = $reportCards->pluck('id')->toArray();
        $graduationGrade->update(['report_card_ids' => json_encode($reportCardIds)]);

        // Tentukan daftar subject yang relevan
        $subjectIds = [1, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        $subjects = Subject::whereIn('id', $subjectIds)->get();

        $averageSubjects = [];

        // Loop untuk menghitung rata-rata nilai per mata pelajaran
        foreach ($subjectIds as $subjectId) {
            $totalScore = 0;
            $semesterCount = 0;

            foreach ($reportCards as $reportCardItem) {
                // Temukan nilai untuk subject tertentu dalam setiap report card
                $subject = $reportCardItem->subjects->firstWhere('id', $subjectId);

                if ($subject) {
                    // Ambil nilai dari pivot table 'report_card_subjects'
                    $nilai = $subject->pivot->nilai ?? 0;
                    Log::info("Nilai untuk mata pelajaran {$subject->nama}: {$nilai}");
                    $totalScore += $nilai;
                    $semesterCount++;
                } else {
                    Log::info("Mata pelajaran tidak ditemukan untuk report card id {$reportCardItem->id}");
                }
            }

            $averageSubjects[$subjectId] = $semesterCount > 0 ? round($totalScore / $semesterCount, 2) : 0;
        }

        $finalAverage = count($averageSubjects) > 0
            ? round(array_sum($averageSubjects) / count($averageSubjects), 2)
            : 0;

        // Update graduation grade dengan nilai rata-rata
        $graduationGrade->update([
            'average_subjects' => json_encode($averageSubjects),
            'final_average' => $finalAverage,
        ]);

        $schoolProfile = SchoolProfile::first();

        // Tampilkan tampilan graduation_grade
        return view('admin-pages.graduation_grades.show', compact(
            'graduationGrade',
            'averageSubjects',
            'finalAverage',
            'student',
            'reportCards',  // Ini yang mendeklarasikan reportCards
            'reportCard',   // Pastikan reportCard ditambahkan ke compact
            'subjects',
            'schoolProfile'
        ));
    }

    public function exportPdf($studentId)
    {
        // Ambil data siswa berdasarkan student_id
        $student = Student::findOrFail($studentId);

        // Ambil semua ReportCard untuk student_id dan semester yang relevan
        $relevantSemesters = ['Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1', 'Level 6 Semester 2'];
        $reportCards = ReportCard::where('student_id', $studentId)
            ->whereIn('semester', $relevantSemesters)
            ->get();

        // Cek jika ada report card
        if ($reportCards->isEmpty()) {
            return redirect()->back()->with('error', 'Data rapor siswa tidak ditemukan.');
        }

        // Ambil report card pertama
        $reportCard = $reportCards->first();  // Pastikan reportCard didefinisikan di sini

        // Tentukan daftar subject yang relevan
        $subjectIds = [1, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        $subjects = Subject::whereIn('id', $subjectIds)->get();

        // Perhitungan rata-rata nilai per mata pelajaran
        $averageSubjects = [];

        foreach ($subjectIds as $subjectId) {
            $totalScore = 0;
            $semesterCount = 0;

            foreach ($reportCards as $reportCardItem) {
                // Temukan nilai untuk subject tertentu dalam setiap report card
                $subject = $reportCardItem->subjects->firstWhere('id', $subjectId);

                if ($subject) {
                    // Ambil nilai dari pivot table 'report_card_subjects'
                    $nilai = $subject->pivot->nilai ?? 0;
                    $totalScore += $nilai;
                    $semesterCount++;
                }
            }

            $averageSubjects[$subjectId] = $semesterCount > 0 ? round($totalScore / $semesterCount, 2) : 0;
        }

        // Menghitung rata-rata akhir
        $finalAverage = count($averageSubjects) > 0
            ? round(array_sum($averageSubjects) / count($averageSubjects), 2)
            : 0;

        // Ambil atau buat data GraduationGrade
        $graduationGrade = GraduationGrade::firstOrCreate(['student_id' => $studentId]);

        // Update graduation grade dengan nilai rata-rata
        $graduationGrade->update([
            'average_subjects' => json_encode($averageSubjects),
            'final_average' => $finalAverage,
        ]);

        $schoolProfile = SchoolProfile::first(); // Jika hanya ada satu data, gunakan first()

        // Render view ke PDF
        $pdf = PDF::loadView('admin-pages.graduation_grades.show-pdf', compact(
            'student',
            'graduationGrade',
            'averageSubjects',
            'finalAverage',  // Pastikan $finalAverage digunakan
            'reportCards',
            'reportCard',   // Pastikan reportCard juga ditambahkan ke compact
            'subjects',
            'schoolProfile'
        ));

        // Return PDF
        return $pdf->stream('Daftar Nilai Hasil Ujian Sekolah' . ' - ' . $student->nama . '.pdf');
    }
}
