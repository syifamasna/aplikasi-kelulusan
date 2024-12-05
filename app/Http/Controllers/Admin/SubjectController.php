<?php

namespace App\Http\Controllers\Admin;

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

        return view('admin-pages.subjects.index', compact('subjects', 'keyword'));
    }

    public function create()
    {
        return view('admin-pages.subjects.create'); // Menampilkan form untuk menambah mata pelajaran
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',  // Validasi input nama mata pelajaran
            'guru_mapel' => 'required|string|max:255', // Validasi input guru mata pelajaran
        ]);

        Subject::create($validated); // Menyimpan data mata pelajaran ke dalam database

        return redirect()->route('admin.subjects.index')->with('success', 'Mata Pelajaran berhasil ditambahkan'); // Mengarahkan ke halaman daftar mata pelajaran
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id); // Mengambil data mata pelajaran berdasarkan id
        return view('admin-pages.subjects.edit', compact('subject')); // Menampilkan form edit
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255', // Validasi nama mata pelajaran
            'guru_mapel' => 'required|string|max:255', // Validasi guru mata pelajaran
        ]);

        $subject = Subject::findOrFail($id); // Mencari mata pelajaran berdasarkan id
        $subject->update($validated); // Memperbarui data mata pelajaran

        return redirect()->route('admin.subjects.index')->with('success', 'Mata Pelajaran berhasil diperbarui'); // Kembali ke halaman daftar mata pelajaran
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id); // Mencari mata pelajaran berdasarkan id
        $subject->delete(); // Menghapus mata pelajaran

        return redirect()->route('admin.subjects.index')->with('success', 'Mata Pelajaran berhasil dihapus'); // Mengarahkan kembali ke halaman daftar mata pelajaran
    }
}
