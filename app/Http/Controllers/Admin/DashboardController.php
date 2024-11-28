<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\StudentClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data dari database
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses = StudentClass::count();
        $totalSubjects = Subject::count();

        // Kirim data ke view dashboard
        return view('admin-pages.dashboard.index', [
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'totalClasses' => $totalClasses,
            'totalSubjects' => $totalSubjects,
        ]);
    }
}
