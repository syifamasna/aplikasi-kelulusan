<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StudentController extends Controller
{

    public function index(Request $request)
    {
        // Ambil filter kelas dan keyword
        $keyword = $request->input('keyword');

        // Ambil class_id dari user yang sedang login (wali kelas)
        $classId = Auth::user()->class_id;  // Menggunakan Auth::user()

        // Filter siswa berdasarkan kelas yang ada di tabel students dan keyword
        $students = Student::where('kelas', $classId)  // Filter berdasarkan 'kelas' di tabel students
            ->when($keyword, function ($query, $keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('nis', 'like', "%{$keyword}%")
                    ->orWhere('nisn', 'like', "%{$keyword}%");
            })
            ->orderBy('nama', 'asc')
            ->get();

        return view('user-pages.students.index', compact('students', 'keyword'));
    }

    public function create()
    {
        // Ambil class_id dari user yang sedang login (wali kelas)
        $classId = Auth::user()->class_id;

        // Ambil data kelas yang sesuai dengan wali kelas yang login
        $class = StudentClass::where('kelas', $classId)->first();

        return view('user-pages.students.create', compact('class')); // Kirim kelas ke view
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:students',
            'nisn' => 'required',
            'nama' => 'required',
            'jk' => 'required|in:Laki-laki,Perempuan', // Validasi jk
            'ttl' => 'nullable'
        ]);

        // Simpan data siswa dengan class_id yang sesuai dengan wali kelas yang login
        $student = new Student();
        $student->nis = $request->nis;
        $student->nisn = $request->nisn;
        $student->nama = $request->nama;
        $student->kelas = Auth::user()->class_id; // Gunakan class_id wali kelas yang login
        $student->jk = $request->jk; // Simpan jk
        $student->ttl = $request->ttl;
        $student->save();

        return redirect()->route('user.students.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('user-pages.students.show', compact('student'));
    }


    public function edit($id)
    {
        $student = Student::findOrFail($id);

        // Ambil class_id dari user yang sedang login (wali kelas)
        $classId = Auth::user()->class_id;

        // Ambil data kelas yang sesuai dengan wali kelas yang login
        $class = StudentClass::where('kelas', $classId)->first();

        return view('user-pages.students.edit', compact('student', 'class')); // Kirim kelas dan siswa ke view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required',
            'nisn' => 'required',
            'nama' => 'required',
            // Tidak perlu validasi lagi untuk jk, karena akan diambil dari data yang sudah ada
            'ttl' => 'nullable'
        ]);

        $student = Student::findOrFail($id);
        $student->nis = $request->nis;
        $student->nisn = $request->nisn;
        $student->nama = $request->nama;
        $student->jk = $request->jk ?? $student->jk; // Jika tidak ada input, tetap pakai data lama
        $student->ttl = $request->ttl;
        $student->save();

        return redirect()->route('user.students.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file')->getPathname();
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $errors = [];
        foreach ($rows as $key => $row) {
            // Lewati header
            if ($key == 1) continue;

            try {
                $jk = $row['C'] === 'P' ? 'Perempuan' : ($row['C'] === 'L' ? 'Laki-laki' : null);

                if (!$jk) {
                    $errors[] = "Baris {$key}: Jenis kelamin tidak valid.";
                    continue;
                }

                // Gunakan class_id dari user yang login
                $classId = Auth::user()->class_id;

                Student::create([
                    'nama' => $row['A'],
                    'kelas' => $row['B'],
                    'jk' => $jk,
                    'nis' => $row['D'],
                    'nisn' => $row['E'],
                    'ttl' => $row['F'],  // Kolom F untuk TTL
                    'class_id' => $classId, // Pastikan siswa terhubung dengan kelas wali kelas yang login
                ]);
            } catch (\Exception $e) {
                $errors[] = "Baris {$key}: " . $e->getMessage();
            }
        }

        if ($errors) {
            return redirect()->back()->with('error', implode('<br>', $errors));
        }

        return redirect()->back()->with('success', 'Data siswa berhasil diimpor!');
    }

    // Menghapus siswa
    public function destroy($id)
    {
        $students = Student::findOrFail($id);
        $students->delete();

        return redirect()->route('user.students.index')->with('success', 'Data siswa berhasil dihapus');
    }
}
