<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentClass;
use Illuminate\Http\Request; // Tambahkan ini untuk mengimpor Request

class StudentClassController extends Controller
{
    public function index()
    {
        $student_classes = StudentClass::all(); // Mendapatkan semua data kelas
        return view('admin-pages.student_classes.index', compact('student_classes')); // Mengirim data kelas ke view
    }

    public function show($id)
    {
        $student_classes = StudentClass::findOrFail($id);
        return view('admin-pages.student_classes.show', compact('student_classes'));
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
        return redirect()->route('admin.student_classes.index')->with('success', 'Data siswa berhasil diperbarui');
    }
}
