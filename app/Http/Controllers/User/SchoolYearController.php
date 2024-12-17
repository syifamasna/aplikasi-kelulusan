<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    // Menampilkan daftar tahun ajar
    public function index(Request $request)
    {
        $keyword = $request->input('keyword', '');

        $schoolYears = SchoolYear::where('tahun_ajar', 'like', "%$keyword%")
            ->orderBy('tahun_ajar', 'asc') // Urutkan berdasarkan angka
            ->get(); // Pagination 3 data per halaman

        return view('user-pages.school_years.index', compact('schoolYears', 'keyword'));
    }
}
