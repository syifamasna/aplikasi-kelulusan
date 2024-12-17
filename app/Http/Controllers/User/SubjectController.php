<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        // Ambil keyword dari input pencarian (jika ada)
        $keyword = $request->input('keyword', '');

        // Ambil semua data mata pelajaran yang sesuai dengan keyword
        $subjects = Subject::where('nama', 'like', "%$keyword%")
            ->get(); // Ambil semua data tanpa pagination

        return view('user-pages.subjects.index', compact('subjects', 'keyword'));
    }
}
