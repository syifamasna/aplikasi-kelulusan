<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik umum
        $totalStudents = Student::count();
        $totalSubjects = Subject::count();
        $totalClasses = StudentClass::count();
        $totalUsers = User::count();

        // Semester wajib Graduation (sama seperti user)
        $requiredGraduationSemesters = ['Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1', 'Level 6 Semester 2'];

        $topGraduationScores = Student::with('reportCards') // eager load reportCards
            ->join('graduation_grades', 'students.id', '=', 'graduation_grades.student_id')
            ->select('students.id', 'students.nama', 'students.kelas', 'graduation_grades.final_average')
            ->get()
            ->filter(function ($student) use ($requiredGraduationSemesters) {
                $reportCards = $student->reportCards;

                // Cek kelengkapan semester wajib Graduation
                foreach ($requiredGraduationSemesters as $semester) {
                    if (!$reportCards->contains('semester', $semester)) {
                        \App\Models\GraduationGrade::where('student_id', $student->id)->delete();
                        return false;
                    }
                }

                return true;
            })
            ->sortByDesc('final_average')
            ->take(10)
            ->values();

        // Semester dan mapel wajib PPDB
        $ppdbRequiredSemesters = ['Level 4 Semester 1', 'Level 4 Semester 2', 'Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1'];
        $ppdbRequiredSubjectIds = [1, 3, 4, 5, 6];

        $topPPDBScores = Student::with(['reportCards.subjects']) // eager load reportCards & subjects
            ->join('ppdb_grades', 'students.id', '=', 'ppdb_grades.student_id')
            ->select('students.id', 'students.nama', 'students.kelas', 'ppdb_grades.total_average')
            ->get()
            ->filter(function ($student) use ($ppdbRequiredSemesters, $ppdbRequiredSubjectIds) {
                $reportCards = $student->reportCards;

                // Cek kelengkapan semester dan mapel di tiap semester
                foreach ($ppdbRequiredSemesters as $semester) {
                    $card = $reportCards->firstWhere('semester', $semester);
                    if (!$card) {
                        \App\Models\PPDBGrade::where('student_id', $student->id)->delete();
                        return false;
                    }

                    $subjectIdsInCard = $card->subjects->pluck('id')->toArray();
                    foreach ($ppdbRequiredSubjectIds as $requiredId) {
                        if (!in_array($requiredId, $subjectIdsInCard)) {
                            \App\Models\PPDBGrade::where('student_id', $student->id)->delete();
                            return false;
                        }
                    }
                }

                return true;
            })
            ->sortByDesc('total_average')
            ->take(10)
            ->values();

        return view('admin-pages.dashboard.index', [
            'totalStudents' => $totalStudents,
            'totalClasses' => $totalClasses,
            'totalSubjects' => $totalSubjects,
            'totalUsers' => $totalUsers,
            'topGraduationScores' => $topGraduationScores,
            'topPPDBScores' => $topPPDBScores,
        ]);
    }
}
