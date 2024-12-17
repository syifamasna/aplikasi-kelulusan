<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\SchoolYear;
use App\Models\ReportCard;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportCardController extends Controller
{
    public function index(Request $request)
    {
        $kelasFilter = $request->input('kelas');
        $keyword = $request->input('keyword');

        $query = Student::query();

        if ($kelasFilter) {
            $query->whereHas('studentClass', function ($query) use ($kelasFilter) {
                $query->where('kelas', $kelasFilter);
            });
        }

        if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhereHas('studentClass', function ($query) use ($keyword) {
                        $query->where('kelas', 'like', '%' . $keyword . '%');
                    });
            });
        }

        $students = $query->orderBy('kelas', 'asc')->orderBy('nama', 'asc')->get();
        $classes = StudentClass::all();

        return view('admin-pages.report_cards.class_report', compact('students', 'classes', 'kelasFilter', 'keyword'));
    }

    public function showStudentReport($studentId)
    {
        $student = Student::findOrFail($studentId);
        $reportCards = ReportCard::where('student_id', $studentId)
            ->orderBy('semester', 'asc') // Urutkan berdasarkan semester
            ->orderBy('tahun_ajar', 'asc') // Urutkan berdasarkan tahun ajar
            ->get();

        return view('admin-pages.report_cards.student_report', compact('student', 'reportCards'));
    }


    public function create($studentId)
    {
        $student = Student::findOrFail($studentId);
        $subjects = Subject::all();
        $school_years = SchoolYear::all();

        return view('admin-pages.report_cards.create', compact('student', 'subjects', 'school_years'));
    }

    public function store(Request $request, $studentId)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'semester' => 'required|numeric|min:0',
            'tahun_ajar' => 'required|string|max:20',
            'mata_pelajaran' => 'required|array',
            'mata_pelajaran.*' => 'nullable|numeric|min:0|max:100',
            'sakit' => 'nullable|numeric|min:0',
            'izin' => 'nullable|numeric|min:0',
            'alfa' => 'nullable|numeric|min:0',
            'ekskul' => 'nullable|array',
            'nilai_ekskul' => 'nullable|array',
            'ket_ekskul' => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {
            // Ambil data siswa berdasarkan ID
            $student = Student::findOrFail($studentId); // Pastikan model Student sudah sesuai

            // Simpan data rapor
            $reportCard = ReportCard::create([
                'student_id' => $studentId,
                'semester' => $validatedData['semester'],
                'tahun_ajar' => $validatedData['tahun_ajar'],
                'sakit' => $validatedData['sakit'],
                'izin' => $validatedData['izin'],
                'alfa' => $validatedData['alfa'],
                'ekskul' => json_encode($validatedData['ekskul']),
                'nilai_ekskul' => json_encode($validatedData['nilai_ekskul']),
                'ket_ekskul' => json_encode($validatedData['ket_ekskul']),
            ]);

            // Simpan nilai mata pelajaran ke tabel pivot
            foreach ($validatedData['mata_pelajaran'] as $subjectId => $nilai) {
                if (!is_null($nilai)) {
                    $reportCard->subjects()->attach($subjectId, ['nilai' => $nilai]);
                }
            }

            DB::commit();

            return redirect()->route('admin.report_cards.student_report', ['student' => $student->id])
                ->with('success', 'Nilai rapor berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($studentId, $reportCardId)
    {
        $student = Student::findOrFail($studentId);
        $reportCard = ReportCard::where('student_id', $studentId)->findOrFail($reportCardId);
        $subjects = Subject::all();

        return view('admin-pages.report_cards.show', compact('student', 'reportCard', 'subjects'));
    }

    public function edit($id)
    {
        $reportCard = ReportCard::findOrFail($id);
        $student = $reportCard->student;
        $subjects = Subject::all();
        $school_years = SchoolYear::all();

        return view('admin-pages.report_cards.edit', compact('reportCard', 'student', 'subjects', 'school_years'));
    }

    public function update(Request $request, $student_id, $report_card_id)
    {
        $reportCard = ReportCard::findOrFail($report_card_id);

        $validatedData = $request->validate([
            'semester' => 'required|integer',
            'tahun_ajar' => 'required|string',
            'mata_pelajaran' => 'array|required',
            'sakit' => 'nullable|integer',
            'izin' => 'nullable|integer',
            'alfa' => 'nullable|integer',
            'ekskul' => 'nullable|array',
            'nilai_ekskul' => 'nullable|array',
            'ket_ekskul' => 'nullable|array'
        ]);

        // Update nilai mata pelajaran
        foreach ($validatedData['mata_pelajaran'] as $subject_id => $nilai) {
            $reportCard->subjects()->updateExistingPivot($subject_id, ['nilai' => $nilai]);
        }

        // Update semua data lainnya (termasuk ekstrakurikuler) dalam satu query
        $reportCard->update([
            'semester' => $validatedData['semester'],
            'tahun_ajar' => $validatedData['tahun_ajar'],
            'sakit' => $validatedData['sakit'],
            'izin' => $validatedData['izin'],
            'alfa' => $validatedData['alfa'],
            'ekskul' => $validatedData['ekskul'] ? json_encode($validatedData['ekskul']) : null,
            'nilai_ekskul' => $validatedData['nilai_ekskul'] ? json_encode($validatedData['nilai_ekskul']) : null,
            'ket_ekskul' => $validatedData['ket_ekskul'] ? json_encode($validatedData['ket_ekskul']) : null
        ]);

        return redirect()->route('admin.report_cards.student_report', [$student_id])
            ->with('success', 'Data rapor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            // Cari data berdasarkan ID
            $reportCard = ReportCard::findOrFail($id);
            // Ambil ID siswa yang terkait dengan report card
            $studentId = $reportCard->student_id; // pastikan relasi ini sudah ada atau sesuaikan dengan struktur tabel Anda

            // Hapus data
            $reportCard->delete();

            // Redirect kembali ke halaman student_report siswa
            return redirect()->route('admin.report_cards.student_report', ['student' => $studentId])
                ->with('success', 'Nilai Rapor berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
