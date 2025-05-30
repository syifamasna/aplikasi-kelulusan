<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\GraduationGrade;
use App\Models\ReportCard;
use App\Models\Subject;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class GraduationGradeController extends Controller
{
    // Method untuk menampilkan daftar ijazah
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

        return view('user-pages.graduation_grades.index', compact('students', 'keyword'));
    }

    public function show($studentId)
    {
        // Ambil data siswa
        $student = Student::findOrFail($studentId);
        $relevantSemesters = ['Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1', 'Level 6 Semester 2'];

        // Ambil semua ReportCard untuk semester yang relevan
        $reportCards = ReportCard::where('student_id', $studentId)
            ->whereIn('semester', $relevantSemesters)
            ->get();

        // Cek apakah semua semester ada
        foreach ($relevantSemesters as $semester) {
            if (!$reportCards->contains('semester', $semester)) {
                // Hapus GraduationGrade jika ada
                GraduationGrade::where('student_id', $studentId)->delete();

                return redirect()->back()->with(
                    'error',
                    "Data rapor {$semester} belum lengkap. Harap lengkapi data rapor terlebih dahulu. " .
                        "<a href='" . route('user.report_cards.student_report', ['student' => $studentId]) . "'><br><b>Klik di sini</b></a> untuk menuju halaman rapor."
                );
            }
        }

        // Ambil atau buat GraduationGrade
        $graduationGrade = GraduationGrade::firstOrCreate(['student_id' => $studentId]);
        $reportCardIds = $reportCards->pluck('id')->toArray();
        $graduationGrade->update(['report_card_ids' => json_encode($reportCardIds)]);

        // Ambil mata pelajaran relevan
        $subjectIds = [1, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        $subjects = Subject::whereIn('id', $subjectIds)->get();
        $averageSubjects = [];

        // Hitung rata-rata nilai
        foreach ($subjectIds as $subjectId) {
            $totalScore = 0;
            $semesterCount = 0;

            foreach ($reportCards as $reportCardItem) {
                $subject = $reportCardItem->subjects->firstWhere('id', $subjectId);

                if ($subject) {
                    $nilai = $subject->pivot->nilai ?? 0;
                    $totalScore += $nilai;
                    $semesterCount++;
                }
            }

            // Jika tidak ada nilai untuk satu mata pelajaran pun → batal
            if ($semesterCount === 0) {
                // Hapus GraduationGrade jika tidak valid
                $graduationGrade->delete();

                return redirect()->back()->with(
                    'error',
                    "Data nilai untuk mata pelajaran ID {$subjectId} tidak lengkap. Harap lengkapi data rapor terlebih dahulu. " .
                        "<a href='" . route('user.report_cards.student_report', ['student' => $studentId]) . "'><br><b>Klik di sini</b></a> untuk menuju halaman rapor."
                );
            }

            $averageSubjects[$subjectId] = round($totalScore / $semesterCount, 2);
        }

        $finalAverage = round(array_sum($averageSubjects) / count($averageSubjects), 2);

        $graduationGrade->update([
            'average_subjects' => json_encode($averageSubjects),
            'final_average' => $finalAverage,
        ]);

        $schoolProfile = SchoolProfile::first();
        $reportCard = $reportCards->first();

        return view('user-pages.graduation_grades.show', compact(
            'graduationGrade',
            'averageSubjects',
            'finalAverage',
            'student',
            'reportCards',
            'reportCard',
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
        $pdf = PDF::loadView('user-pages.graduation_grades.show-pdf', compact(
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
