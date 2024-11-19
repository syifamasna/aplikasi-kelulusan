<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Student;

class ImportController extends Controller
{
    public function import(Request $request)
{
    // Validasi input file
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
        'model' => 'required|string', // Pilih model
    ]);

    $file = $request->file('file')->getPathname();
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray(null, true, true, true);

    $modelName = $request->input('model');

    // Tentukan model berdasarkan input
    switch ($modelName) {
        case 'Student':
            foreach ($rows as $row) {
                // Proses untuk mengganti 'P' dan 'L' dengan 'Perempuan' dan 'Laki-laki'
                $jk = $row['C'];  // Kolom C adalah jenis kelamin
                if ($jk == 'P') {
                    $jk = 'Perempuan';
                } elseif ($jk == 'L') {
                    $jk = 'Laki-laki';
                }

                // Simpan data ke database
                Student::create([
                    'nama' => $row['A'],
                    'kelas' => $row['B'],
                    'jk' => $jk,  // Gunakan nilai yang sudah diproses
                    'nis' => $row['D'],
                    'nisn' => $row['E']
                ]);
            }
            break;

        default:
            return redirect()->back()->with('error', 'Model tidak valid.');
    }

    return redirect()->back()->with('success', "Data untuk $modelName berhasil diimpor!");
}

}
