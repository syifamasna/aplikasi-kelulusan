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
        // Ambil data dari database
        $totalStudents = Student::count();
        $totalClasses = StudentClass::count();
        $totalSubjects = Subject::count();
        $totalUsers = User::count();

        // Ambil 10 siswa dengan nilai rata-rata tertinggi pada tabel graduation_grades
        $topGraduationScores = Student::with(['graduationGrade' => function ($query) {
            $query->select('student_id', 'final_average');
        }])
            ->join('graduation_grades', 'students.id', '=', 'graduation_grades.student_id')
            ->orderBy('graduation_grades.final_average', 'desc')
            ->select('students.id', 'students.nama', 'students.kelas', 'graduation_grades.final_average')
            ->limit(10)
            ->get();

        // Ambil 10 siswa dengan nilai rata-rata tertinggi pada tabel ppdb_grades
        $topPPDBScores = Student::with(['ppdbGrade' => function ($query) {
            $query->select('student_id', 'final_average');
        }])
            ->join('ppdb_grades', 'students.id', '=', 'ppdb_grades.student_id')
            ->orderBy('ppdb_grades.final_average', 'desc')
            ->select('students.id', 'students.nama', 'students.kelas', 'ppdb_grades.final_average')
            ->limit(10)
            ->get();

        // Kirim data ke view dashboard
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
