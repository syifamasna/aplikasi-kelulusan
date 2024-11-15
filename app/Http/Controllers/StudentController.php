<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword', '');

        $students = Student::where('nama', 'like', "%$keyword%")
            ->orWhere('kelas', 'like', "%$keyword%")
            ->orderBy('kelas', 'asc')
            ->orderBy('nama', 'asc')
            ->get();

        return view('pages.students.index', compact('students', 'keyword'));
    }

    public function create()
    {
        $classes = StudentClass::all();
        return view('pages.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:students',
            'nisn' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jk' => 'required|in:Laki-laki,Perempuan', // Validasi jk
        ]);

        $student = new Student();
        $student->nis = $request->nis;
        $student->nisn = $request->nisn;
        $student->nama = $request->nama;
        $student->kelas = $request->kelas;
        $student->jk = $request->jk; // Simpan jk
        $student->save();

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('pages.students.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $classes = StudentClass::all();
        return view('pages.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required',
            'nisn' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jk' => 'required|in:Laki-laki,Perempuan', // Validasi jk
        ]);

        $student = Student::findOrFail($id);
        $student->nis = $request->nis;
        $student->nisn = $request->nisn;
        $student->nama = $request->nama;
        $student->kelas = $request->kelas;
        $student->jk = $request->jk; // Update jk
        $student->save();

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus');
    }
}
