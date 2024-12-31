<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\GraduationGrade;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class GraduationGradeController extends Controller
{
    // Method untuk menampilkan daftar ijazah
    public function index(Request $request)
    {
        // Ambil kelas-kelas yang tersedia untuk filter
        $classes = StudentClass::all();

        // Ambil filter kelas dan kata kunci pencarian
        $kelasFilter = $request->kelas;
        $keyword = $request->keyword;

        // Ambil data siswa sesuai filter kelas dan pencarian
        $students = Student::where(function($query) use ($kelasFilter, $keyword) {
            if ($kelasFilter) {
                $query->where('kelas', $kelasFilter);
            }
            if ($keyword) {
                $query->where('nama', 'like', "%$keyword%")
                      ->orWhere('nis', 'like', "%$keyword%")
                      ->orWhere('nisn', 'like', "%$keyword%");
            }
        })->get();

        // Kirim data ke view
        return view('admin-pages.graduation_grades.index', compact('students', 'classes', 'kelasFilter', 'keyword'));
    }
}
