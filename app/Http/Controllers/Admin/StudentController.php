<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data kelas dan urutkan berdasarkan abjad
        $classes = StudentClass::orderBy('kelas', 'asc')->get();

        // Ambil filter kelas dan keyword pencarian
        $kelasFilter = $request->input('kelas');
        $keyword = $request->input('keyword');

        // Filter siswa berdasarkan kelas dan keyword, kemudian urutkan berdasarkan kelas dan nama
        $students = Student::where('kelas', 'like', '%' . $kelasFilter . '%')
            ->where(function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhere('kelas', 'like', '%' . $keyword . '%');
            })
            ->orderBy('kelas', 'asc')  // Urutkan berdasarkan kelas
            ->orderBy('nama', 'asc')   // Urutkan berdasarkan nama setelah kelas
            ->get();

        return view('admin-pages.students.index', compact('students', 'classes', 'kelasFilter', 'keyword'));
    }

    public function create()
    {
        $classes = StudentClass::all();
        return view('admin-pages.students.create', compact('classes'));
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

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('admin-pages.students.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $classes = StudentClass::all();
        return view('admin-pages.students.edit', compact('student', 'classes'));
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

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil dihapus');
    }


    public function import(Request $request)
    {
        // Validasi input file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file')->getPathname();
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        foreach ($rows as $key => $row) {
            // Skip header row (key = 1)
            if ($key == 1) continue;

            // Proses untuk mengganti 'P' dan 'L' dengan 'Perempuan' dan 'Laki-laki'
            $jk = $row['C'];  // Kolom C adalah jenis kelamin
            if ($jk == 'P') {
                $jk = 'Perempuan';
            } elseif ($jk == 'L') {
                $jk = 'Laki-laki';
            }

            // Simpan data ke tabel students
            Student::create([
                'nama' => $row['A'],  // Kolom A untuk nama
                'kelas' => $row['B'], // Kolom B untuk kelas
                'jk' => $jk,          // Simpan jenis kelamin yang sudah diproses
                'nis' => $row['D'],   // Kolom D untuk NIS
                'nisn' => $row['E'],  // Kolom E untuk NISN
            ]);
        }

        return redirect()->back()->with('success', 'Data siswa berhasil diimpor!');
    }

    public function export()
    {
        $students = Student::all();

        // Menambahkan BOM untuk mendukung karakter UTF-8
        $csvData = "\xEF\xBB\xBF";
        $csvData .= "No.,Nama,Kelas,Jenis Kelamin,NIS,NISN\n"; // Header CSV

        $no = 1;
        foreach ($students as $student) {
            $csvData .= "{$no},{$student->nama},{$student->kelas},{$student->jk},{$student->nis},{$student->nisn}\n";
            $no++;
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="students.csv"');
    }
}
