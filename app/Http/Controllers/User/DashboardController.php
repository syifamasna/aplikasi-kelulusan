<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data dari database
        $totalStudents = Student::count();
        $totalSubjects = Subject::count();

        // Kirim data ke view dashboard
        return view('user-pages.dashboard.index', [
            'totalStudents' => $totalStudents,
            'totalSubjects' => $totalSubjects,
        ]);
    }
}
