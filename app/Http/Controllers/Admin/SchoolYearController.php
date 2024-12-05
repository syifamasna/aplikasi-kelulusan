<?php

namespace App\Http\Controllers\Admin;

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

        return view('admin-pages.school_years.index', compact('schoolYears', 'keyword'));
    }

    // Menampilkan form untuk menambah tahun ajar baru
    public function create()
    {
        return view('admin-pages.school_years.create');
    }

    // Menyimpan tahun ajar baru
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajar' => 'required|string|max:255|unique:school_years,tahun_ajar',
        ]);

        SchoolYear::create($request->all());

        return redirect()->route('admin.school_years.index')->with('success', 'Tahun ajar berhasil ditambahkan');
    }

    // Menampilkan form edit tahun ajar
    public function edit($id)
    {
        $schoolYear = SchoolYear::findOrFail($id);
        return view('admin-pages.school_years.edit', compact('schoolYear'));
    }

    // Memperbarui data tahun ajar
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_ajar' => 'required|string|max:255|unique:school_years,tahun_ajar,' . $id,
        ]);

        $schoolYear = SchoolYear::findOrFail($id);
        $schoolYear->update($request->all());

        return redirect()->route('admin.school_years.index')->with('success', 'Tahun ajar berhasil diperbarui');
    }

    // Menghapus tahun ajar
    public function destroy($id)
    {
        $schoolYear = SchoolYear::findOrFail($id);
        $schoolYear->delete();

        return redirect()->route('admin.school_years.index')->with('success', 'Tahun ajar berhasil dihapus');
    }
}
