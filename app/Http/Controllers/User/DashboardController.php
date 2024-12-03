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

        // Kirim data ke view dashboard
        return view('user-pages.dashboard.index', [
            'totalStudents' => $totalStudents,
            'totalSubjects' => $totalSubjects,
        ]);
    }
}
