<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // Menampilkan daftar guru
    public function index(Request $request)
    {
        // Ambil keyword dari input pencarian (jika ada)
        $keyword = $request->input('keyword', '');

        // Mengambil data siswa berdasarkan pencarian dan dengan pagination
        $teachers = Teacher::where('nama', 'like', "%$keyword%")
            ->orderBy('nama', 'asc') // Urutkan berdasarkan nama secara alfabet
            ->get(); // Pagination 5 data per halaman

        return view('pages.teachers.index', compact('teachers', 'keyword'));
    }

    // Menampilkan form untuk menambah guru baru
    public function create()
    {
        return view('pages.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:teachers,nip',
            'jk_guru' => 'required|in:Laki-laki,Perempuan',
            'guru_status' => 'required|in:Guru Aktif,Wali Kelas',
        ]);

        // Menyimpan data ke dalam tabel teachers
        Teacher::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jk_guru' => $request->jk_guru,
            'guru_status' => $request->guru_status,
        ]);

        // Redirect ke halaman teachers.index setelah berhasil menyimpan data
        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil ditambahkan');
    }

    // Menampilkan data guru untuk diedit
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('pages.teachers.edit', compact('teacher'));
    }

    // Mengupdate data guru
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:teachers,nip,' . $id,
            'jk_guru' => 'required|in:Laki-laki,Perempuan',
            'guru_status' => 'required|in:Guru Aktif,Wali Kelas',
        ]);

        $teacher = Teacher::findOrFail($id);
        $teacher->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jk_guru' => $request->jk_guru,
            'guru_status' => $request->guru_status,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil diubah.');
    }

    // Menghapus data guru
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
