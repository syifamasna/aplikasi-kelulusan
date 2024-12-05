<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentClass;
use Illuminate\Http\Request; // Tambahkan ini untuk mengimpor Request

class StudentClassController extends Controller
{
    // Menampilkan daftar guru
    public function index(Request $request)
    {
        // Ambil keyword dari input pencarian (jika ada)
        $keyword = $request->input('keyword', '');

        // Mengambil data siswa berdasarkan pencarian dan dengan pagination
        $student_classes = StudentClass::where('kelas', 'like', "%$keyword%")
            ->orderBy('kelas', 'asc') // Urutkan berdasarkan nama secara alfabet
            ->get(); // Pagination 5 data per halaman

        return view('admin-pages.student_classes.index', compact('student_classes', 'keyword'));
    }

    public function show($id)
    {
        $student_classes = StudentClass::findOrFail($id);
        return view('admin-pages.student_classes.show', compact('student_classes'));
    }

    public function create()
    {
        return view('admin-pages.student_classes.create'); // Menampilkan form untuk menambah kelas
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas' => 'required|string|max:255',  // Validasi input nama kelas
            'nama_guru' => 'required|string|max:255', // Validasi input guru kelas
        ]);

        StudentClass::create($validated); // Menyimpan data kelas ke dalam database

        return redirect()->route('admin.student_classes.index')->with('success', 'Kelas berhasil ditambahkan'); // Mengarahkan ke halaman daftar kelas
    }

    // Menampilkan halaman Edit
    public function edit($id)
    {
        $student_classes = StudentClass::findOrFail($id);
        return view('admin-pages.student_classes.edit', compact('student_classes'));
    }



    // Menyimpan data yang sudah diedit
    public function update(Request $request, $id)
    {
        // Validasi request jika perlu
        $request->validate([
            'kelas' => 'required',
            'nama_guru' => 'required',
        ]);

        // Temukan data kelas berdasarkan ID
        $student_classes = StudentClass::findOrFail($id);

        // Update data kelas
        $student_classes->kelas = $request->kelas;
        $student_classes->nama_guru = $request->nama_guru;
        $student_classes->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.student_classes.index')->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $student_classes = StudentClass::findOrFail($id);
        $student_classes->delete();

        return redirect()->route('admin.student_classes.index')->with('success', 'Kelas berhasil dihapus');
    }
}
