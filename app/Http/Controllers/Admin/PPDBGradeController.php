<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\PPDBGrade;
use App\Models\ReportCard;
use App\Models\Subject;
use App\Models\StudentClass;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class PPDBGradecontroller extends Controller
{
    // Method untuk menampilkan daftar ijazah
    public function index(Request $request)
    {
        // Fungsi index tetap seperti aslinya
        $classes = StudentClass::all();
        $kelasFilter = $request->kelas;
        $keyword = $request->keyword;

        $students = Student::where(function ($query) use ($kelasFilter, $keyword) {
            if ($kelasFilter) {
                $query->where('kelas', $kelasFilter);
            }
            if ($keyword) {
                $query->where('nama', 'like', "%$keyword%")
                    ->orWhere('nis', 'like', "%$keyword%")
                    ->orWhere('nisn', 'like', "%$keyword%")
                    ->orWhere('kelas', 'like', "%$keyword%");
            }
        })->orderBy('kelas', 'asc')
            ->orderBy('nama', 'asc')
            ->get();

        return view('admin-pages.ppdb_grades.index', compact('students', 'classes', 'kelasFilter', 'keyword'));
    }

    public function show($studentId)
    {
        $student = Student::findOrFail($studentId);

        $relevantSemesters = ['Level 4 Semester 1', 'Level 4 Semester 2', 'Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1'];
        $semesterKeys = ['4.1', '4.2', '5.1', '5.2', '6.1'];

        $subjectIds = [1, 3, 4, 5, 6]; // subject yang dinilai
        $subjects = Subject::whereIn('id', $subjectIds)->get();

        $reportCards = ReportCard::where('student_id', $studentId)
            ->whereIn('semester', $relevantSemesters)
            ->with('subjects')
            ->get();

        // Cek kelengkapan rapor dan mapel
        foreach ($relevantSemesters as $semester) {
            $reportCard = $reportCards->firstWhere('semester', $semester);
            if (!$reportCard) {
                return redirect()->back()->with(
                    'error',
                    "Data rapor {$semester} belum lengkap. Harap lengkapi data rapor terlebih dahulu. " .
                        "<a href='" . route('admin.report_cards.student_report', ['student' => $studentId]) . "'><br><b>Klik di sini</b></a> untuk menuju halaman rapor."
                );
            }

            // Cek apakah semua mapel tersedia di report card ini
            $mapelAda = $reportCard->subjects->pluck('id')->toArray();
            foreach ($subjectIds as $mapelId) {
                if (!in_array($mapelId, $mapelAda)) {
                    return redirect()->back()->with(
                        'error',
                        "Data rapor untuk mata pelajaran tertentu belum lengkap pada semester {$semester}. Harap lengkapi terlebih dahulu. " .
                            "<a href='" . route('admin.report_cards.student_report', ['student' => $studentId]) . "'><br><b>Klik di sini</b></a> untuk menuju halaman rapor."
                    );
                }
            }
        }

        // Lolos validasi, lanjutkan proses
        $ppdbGrade = PPDBGrade::firstOrCreate(['student_id' => $studentId]);

        $reportCardIds = $reportCards->pluck('id')->toArray();
        $ppdbGrade->update(['report_card_ids' => $reportCardIds]);

        $totalJumlahNilai = 0;
        $averageSubjects = [];

        foreach ($subjectIds as $subjectId) {
            $nilaiSemesters = [];
            $jumlahNilai = 0;

            foreach ($relevantSemesters as $index => $semester) {
                $reportCard = $reportCards->firstWhere('semester', $semester);
                $subject = $reportCard->subjects->where('id', $subjectId)->first();
                $nilai = $subject ? $subject->pivot->nilai : 0;

                $nilaiSemesters[$semesterKeys[$index]] = $nilai;
                $jumlahNilai += $nilai;
            }

            $averageSubjects[$subjectId] = [
                'nilai' => $nilaiSemesters,
                'jumlah' => $jumlahNilai,
                'rata_rata' => count($relevantSemesters) > 0 ? $jumlahNilai / count($relevantSemesters) : 0,
            ];

            $totalJumlahNilai += $jumlahNilai;
        }

        $totalAverage = array_sum(array_column($averageSubjects, 'rata_rata'));

        $ppdbGrade->update([
            'total_score' => $totalJumlahNilai,
            'total_average' => $totalAverage,
        ]);

        $schoolProfile = SchoolProfile::first();

        return view('admin-pages.ppdb_grades.show', compact(
            'ppdbGrade',
            'averageSubjects',
            'totalJumlahNilai',
            'totalAverage',
            'student',
            'subjects',
            'reportCards',
            'schoolProfile'
        ));
    }

    public function exportPdf($studentId)
    {
        $student = Student::findOrFail($studentId);

        $relevantSemesters = ['Level 4 Semester 1', 'Level 4 Semester 2', 'Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1'];
        $semesterKeys = ['4.1', '4.2', '5.1', '5.2', '6.1'];

        $reportCards = ReportCard::where('student_id', $studentId)
            ->whereIn('semester', $relevantSemesters)
            ->with('subjects')
            ->get();

        foreach ($relevantSemesters as $semester) {
            if (!$reportCards->contains('semester', $semester)) {
                return redirect()->back()->with(
                    'error',
                    "Data rapor {$semester} belum lengkap. Harap lengkapi data rapor terlebih dahulu. " .
                        "<a href='" . route('admin.report_cards.student_report', ['student' => $studentId]) . "'><br><b>Klik di sini</b></a> untuk menuju halaman rapor."
                );
            }
        }

        $reportCard = $reportCards->first();

        $ppdbGrade = PPDBGrade::firstOrCreate(['student_id' => $studentId]);

        $reportCardIds = $reportCards->pluck('id')->toArray();
        $ppdbGrade->update(['report_card_ids' => json_encode($reportCardIds)]);

        $subjectIds = [1, 3, 4, 5, 6]; // Sesuaikan dengan kelompok A
        $subjects = Subject::whereIn('id', $subjectIds)->get();

        $totalRataRata = 0;
        $totalJumlahNilai = 0;

        foreach ($subjectIds as $subjectId) {
            $nilaiSemesters = [];
            $jumlahNilai = 0;

            foreach ($relevantSemesters as $index => $semester) {
                $reportCard = $reportCards->firstWhere('semester', $semester);

                if ($reportCard) {
                    $subject = $reportCard->subjects->where('id', $subjectId)->first();
                    $nilai = $subject ? $subject->pivot->nilai : 0;
                } else {
                    $nilai = 0;
                }

                $nilaiSemesters[$semesterKeys[$index]] = $nilai;
                $jumlahNilai += $nilai;
            }

            $rataRata = count($relevantSemesters) > 0 ? $jumlahNilai / count($relevantSemesters) : 0;

            $averageSubjects[$subjectId] = [
                'nilai' => $nilaiSemesters,
                'jumlah' => $jumlahNilai,
                'rata_rata' => $rataRata
            ];

            $totalRataRata += $rataRata;
            $totalJumlahNilai += $jumlahNilai;
        }

        $ppdbGrade->update([
            'total_score' => $totalJumlahNilai,
            'total_average' => $totalRataRata, // ✅ Tidak dibagi lagi
        ]);

        // ✅ Ambil data sekolah dari tabel school_profile
        $schoolProfile = SchoolProfile::first(); // Jika hanya ada satu data, gunakan first()

        // Buat file PDF menggunakan view 'admin-pages.ppdb_grades.pdf'
        $pdf = Pdf::loadView('admin-pages.ppdb_grades.show-pdf', compact(
            'ppdbGrade',
            'averageSubjects',
            'student',
            'reportCards',
            'reportCard',
            'subjects',
            'schoolProfile'
        ));

        // Unduh file PDF
        return $pdf->stream('Surat Keterangan Nilai Rapor' . ' - ' . $student->nama . '.pdf');
    }

    public function exportExcel($studentId)
    {
        $student = Student::findOrFail($studentId);
        $schoolProfile = SchoolProfile::first();

        $relevantSemesters = ['Level 4 Semester 1', 'Level 4 Semester 2', 'Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1'];
        $semesterKeys = ['4.1', '4.2', '5.1', '5.2', '6.1'];

        $reportCards = ReportCard::where('student_id', $studentId)
            ->whereIn('semester', $relevantSemesters)
            ->with('subjects')
            ->get();

        $subjectIds = [1, 3, 4, 5, 6]; // Kelompok A
        $subjects = Subject::whereIn('id', $subjectIds)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // === Header Sekolah dan Judul ===
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->mergeCells('A4:I4');
        $sheet->mergeCells('A5:I5');
        $sheet->mergeCells('A6:I6');

        $sheet->setCellValue('A1', 'SEKOLAH ISLAM TERPADU ALIYA');
        $sheet->setCellValue('A2', 'KBIT - TKIT - SDIT');
        $sheet->setCellValue('A4', 'SURAT KETERANGAN NILAI RAPOR');
        $sheet->setCellValue('A6', 'Yang bertanda tangan di bawah ini, Kepala SD Islam Terpadu Aliya, Kecamatan Bogor Barat, Kota Bogor, menerangkan bahwa :');

        $sheet->getStyle('A1:A2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A4')->getFont()->setBold(true)->setUnderline(true)->setSize(12);
        $sheet->getStyle('A1:A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // === Identitas Siswa ===
        $sheet->fromArray([
            ['Nama', ':', $student->nama],
            ['NISN', ':', $student->nisn],
            ['Tempat dan Tanggal Lahir', ':', $student->ttl],
            ['NPSN Sekolah', ':', $schoolProfile->npsn ?? '-'],
        ], null, 'A8');

        // === Header Tabel Nilai ===
        $startRow = 13;
        $sheet->fromArray([
            ['No', 'Muatan Pelajaran (Kurikulum Merdeka)', '4.1', '4.2', '5.1', '5.2', '6.1', 'Jumlah', 'Rata-rata']
        ], null, "A{$startRow}");

        $sheet->getStyle("A{$startRow}:I{$startRow}")->getFont()->setBold(true);
        $sheet->getStyle("A{$startRow}:I{$startRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A{$startRow}:I{$startRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // === Isi Tabel ===
        $row = $startRow + 1;
        $nomor = 1;
        $totalJumlah = 0;
        $totalAverage = 0;

        foreach ($subjectIds as $subjectId) {
            $subject = $subjects->firstWhere('id', $subjectId);
            if (!$subject) continue;

            $nilaiSemesters = [];
            $jumlahNilai = 0;

            foreach ($relevantSemesters as $index => $semester) {
                $reportCard = $reportCards->firstWhere('semester', $semester);
                $nilai = $reportCard?->subjects->where('id', $subjectId)->first()?->pivot->nilai ?? 0;

                $semesterKey = $semesterKeys[$index];
                $nilaiSemesters[$semesterKey] = $nilai;
                $jumlahNilai += $nilai;
            }

            $rataRata = $jumlahNilai / count($semesterKeys);
            $totalJumlah += $jumlahNilai;
            $totalAverage += $rataRata;

            $sheet->fromArray([
                $nomor++,
                $subject->nama,
                $nilaiSemesters['4.1'],
                $nilaiSemesters['4.2'],
                $nilaiSemesters['5.1'],
                $nilaiSemesters['5.2'],
                $nilaiSemesters['6.1'],
                $jumlahNilai,
                number_format($rataRata, 2)
            ], null, 'A' . $row);

            $sheet->getStyle("A{$row}:I{$row}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            // Center alignment kecuali kolom B
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$row}:I{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
        }

        // === Baris Total ===
        $sheet->mergeCells("A{$row}:G{$row}");
        $sheet->fromArray([
            'Total', '', '', '', '', '', '', $totalJumlah, number_format($totalAverage, 2)
        ], null, "A{$row}");

        $sheet->getStyle("A{$row}:I{$row}")->getFont()->setBold(true);
        $sheet->getStyle("A{$row}:I{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A{$row}:I{$row}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $row += 2;

        // === Catatan Tambahan ===
        $sheet->mergeCells("A{$row}:I{$row}");
        $sheet->setCellValue("A{$row}", 'Daftar nilai rapor sekolah dasar tahun ' . date('Y') . ' ini digunakan untuk pendaftaran ke SMP/MTS.');
        $row += 2;

        // === Tanda Tangan ===
        $sheet->mergeCells("G{$row}:I{$row}");
        $sheet->setCellValue("G{$row}", 'Bogor, ' . Carbon::now()->locale('id')->translatedFormat('d F Y'));
        $row++;

        $sheet->mergeCells("G{$row}:I{$row}");
        $sheet->setCellValue("G{$row}", 'Kepala,');
        $row += 4;

        $sheet->mergeCells("G{$row}:I{$row}");
        $sheet->setCellValue("G{$row}", $schoolProfile->kepsek ?? 'Nama Kepala Sekolah');
        $row++;

        $sheet->mergeCells("G{$row}:I{$row}");
        $sheet->setCellValue("G{$row}", 'NIP. ' . ($schoolProfile->nip_kepsek ?? '...........................................'));

        // === Auto Size Semua Kolom ===
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // === Simpan dan Unduh ===
        $fileName = 'Surat_Keterangan_Nilai_Rapor_' . $student->nama . '.xlsx';
        $tempPath = storage_path("app/public/{$fileName}");

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
