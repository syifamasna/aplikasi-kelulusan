<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user(); // User login
        $userClass = $user->class_id;

        // Jumlah siswa dan mata pelajaran
        $totalStudents = Student::where('kelas', $userClass)->count();
        $totalSubjects = Subject::count();

        // Top 10 Graduation khusus siswa di kelas wali user
        // Daftar semester wajib
        $requiredSemesters = ['Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1', 'Level 6 Semester 2'];

        $topGraduationScores = Student::with('reportCards') // load relasi agar hemat query
            ->join('graduation_grades', 'students.id', '=', 'graduation_grades.student_id')
            ->where('students.kelas', $userClass)
            ->select('students.id', 'students.nama', 'students.kelas', 'graduation_grades.final_average')
            ->get()
            ->filter(function ($student) use ($requiredSemesters) {
                $reportCards = $student->reportCards;

                // Cek apakah semua semester wajib tersedia
                foreach ($requiredSemesters as $semester) {
                    if (!$reportCards->contains('semester', $semester)) {
                        // Hapus graduation_grade karena data tidak valid lagi
                        \App\Models\GraduationGrade::where('student_id', $student->id)->delete();
                        return false;
                    }
                }

                return true;
            })
            ->sortByDesc('final_average')
            ->take(10)
            ->values(); // reset index agar rapih

        // Top 10 PPDB khusus siswa di kelas wali user
        // Daftar semester dan subject yang harus ada untuk PPDB
        $ppdbRequiredSemesters = ['Level 4 Semester 1', 'Level 4 Semester 2', 'Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1'];
        $ppdbRequiredSubjectIds = [1, 3, 4, 5, 6];

        $topPPDBScores = Student::with(['reportCards.subjects']) // eager loading subjects dalam reportCards
            ->join('ppdb_grades', 'students.id', '=', 'ppdb_grades.student_id')
            ->where('students.kelas', $userClass)
            ->select('students.id', 'students.nama', 'students.kelas', 'ppdb_grades.total_average')
            ->get()
            ->filter(function ($student) use ($ppdbRequiredSemesters, $ppdbRequiredSubjectIds) {
                $reportCards = $student->reportCards;

                // Cek kelengkapan semester
                foreach ($ppdbRequiredSemesters as $semester) {
                    $card = $reportCards->firstWhere('semester', $semester);
                    if (!$card) {
                        \App\Models\PPDBGrade::where('student_id', $student->id)->delete();
                        return false;
                    }

                    // Cek kelengkapan mapel di setiap semester
                    $subjectIdsInCard = $card->subjects->pluck('id')->toArray();
                    foreach ($ppdbRequiredSubjectIds as $requiredId) {
                        if (!in_array($requiredId, $subjectIdsInCard)) {
                            \App\Models\PPDBGrade::where('student_id', $student->id)->delete();
                            return false;
                        }
                    }
                }

                return true;
            })
            ->sortByDesc('total_average')
            ->take(10)
            ->values(); // reset index array

        return view('user-pages.dashboard.index', [
            'totalStudents' => $totalStudents,
            'totalSubjects' => $totalSubjects,
            'topGraduationScores' => $topGraduationScores,
            'topPPDBScores' => $topPPDBScores,
        ]);
    }
}