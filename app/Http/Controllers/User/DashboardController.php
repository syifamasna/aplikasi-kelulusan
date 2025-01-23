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
        // Ambil data user yang sedang login
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login

        // Ambil kelas dari user yang login (dengan 'class_id' dari tabel 'users')
        $userClass = $user->class_id;

        // Ambil jumlah siswa berdasarkan kelas pengguna yang login
        $totalStudents = Student::where('kelas', $userClass)->count();
        $totalSubjects = Subject::count();

        // Ambil 10 siswa dengan nilai rata-rata tertinggi pada tabel graduation_grades berdasarkan kelas user
        $topGraduationScores = Student::with(['graduationGrade' => function ($query) {
            $query->select('student_id', 'final_average');
        }])
            ->join('graduation_grades', 'students.id', '=', 'graduation_grades.student_id')
            ->where('students.kelas', $userClass) // Filter berdasarkan kelas user
            ->orderBy('graduation_grades.final_average', 'desc')
            ->select('students.id', 'students.nama', 'students.kelas', 'graduation_grades.final_average')
            ->limit(10)
            ->get();

        // Ambil 10 siswa dengan nilai rata-rata tertinggi pada tabel ppdb_grades berdasarkan kelas user
        $topPPDBScores = Student::with(['ppdbGrade' => function ($query) {
            $query->select('student_id', 'final_average');
        }])
            ->join('ppdb_grades', 'students.id', '=', 'ppdb_grades.student_id')
            ->where('students.kelas', $userClass) // Filter berdasarkan kelas user
            ->orderBy('ppdb_grades.final_average', 'desc')
            ->select('students.id', 'students.nama', 'students.kelas', 'ppdb_grades.final_average')
            ->limit(10)
            ->get();

        // Kirim data ke view dashboard
        return view('user-pages.dashboard.index', [
            'totalStudents' => $totalStudents,
            'totalSubjects' => $totalSubjects,
            'topGraduationScores' => $topGraduationScores,
            'topPPDBScores' => $topPPDBScores,
        ]);
    }
}
