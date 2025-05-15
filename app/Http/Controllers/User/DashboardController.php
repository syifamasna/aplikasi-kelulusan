<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user(); // User login
        $userClass = $user->class_id;

        // Jumlah siswa dan mata pelajaran
        $totalStudents = Student::where('kelas', $userClass)->count();
        $totalSubjects = Subject::count();

        // Top 10 nilai kelulusan
        $topGraduationScores = Student::with(['graduationGrade' => function ($query) {
            $query->select('student_id', 'final_average');
        }])
            ->join('graduation_grades', 'students.id', '=', 'graduation_grades.student_id')
            ->where('students.kelas', $userClass)
            ->orderBy('graduation_grades.final_average', 'desc')
            ->select('students.id', 'students.nama', 'students.kelas', 'graduation_grades.final_average')
            ->limit(10)
            ->get();

        // Top 10 nilai PPDB
        $topPPDBScores = Student::with(['ppdbGrade' => function ($query) {
            $query->select('student_id', 'total_average');
        }])
            ->join('ppdb_grades', 'students.id', '=', 'ppdb_grades.student_id')
            ->where('students.kelas', $userClass)
            ->orderBy('ppdb_grades.total_average', 'desc')
            ->select('students.id', 'students.nama', 'students.kelas', 'ppdb_grades.total_average')
            ->limit(10)
            ->get();

        return view('user-pages.dashboard.index', [
            'totalStudents' => $totalStudents,
            'totalSubjects' => $totalSubjects,
            'topGraduationScores' => $topGraduationScores,
            'topPPDBScores' => $topPPDBScores,
        ]);
    }
}