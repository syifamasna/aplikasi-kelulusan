<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GraduationGrade;
use App\Models\PPDBGrade;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalClasses = StudentClass::count();
        $totalSubjects = Subject::count();
        $totalUsers = User::count();

        // Top 10 siswa dari graduation_grades
        $topGraduationScores = Student::with(['graduationGrade' => function ($query) {
            $query->select('student_id', 'final_average');
        }])
            ->join('graduation_grades', 'students.id', '=', 'graduation_grades.student_id')
            ->orderBy('graduation_grades.final_average', 'desc')
            ->select('students.id', 'students.nama', 'students.kelas', 'graduation_grades.final_average')
            ->limit(10)
            ->get();

        $topPPDBScores = Student::with(['ppdbGrade' => function ($query) {
            $query->select('student_id', 'total_average');
        }])
            ->join('ppdb_grades', 'students.id', '=', 'ppdb_grades.student_id')
            ->orderBy('ppdb_grades.total_average', 'desc')
            ->select('students.id', 'students.nama', 'students.kelas', 'ppdb_grades.total_average')
            ->limit(10)
            ->get();

        return view('admin-pages.dashboard.index', [
            'totalStudents' => $totalStudents,
            'totalClasses' => $totalClasses,
            'totalSubjects' => $totalSubjects,
            'totalUsers' => $totalUsers,
            'topGraduationScores' => $topGraduationScores,
            'topPPDBScores' => $topPPDBScores, // dikirim ke view
        ]);
    }
}
