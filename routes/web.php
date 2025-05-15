<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\SubjectController as AdminSubjectController;
use App\Http\Controllers\Admin\StudentClassController as AdminStudentClassController;
use App\Http\Controllers\Admin\SchoolYearController as AdminSchoolYearController;
use App\Http\Controllers\Admin\SchoolProfileController as AdminSchoolProfileController;
use App\Http\Controllers\Admin\ReportCardController as AdminReportCardController;
use App\Http\Controllers\Admin\GraduationGradeController as AdminGraduationGradeController;
use App\Http\Controllers\Admin\PPDBGradeController as AdminPPDBGradeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\StudentController as UserStudentController;
use App\Http\Controllers\User\SubjectController as UserSubjectController;
use App\Http\Controllers\User\SchoolYearController as UserSchoolYearController;
use App\Http\Controllers\User\SchoolProfileController as UserSchoolProfileController;
use App\Http\Controllers\User\ReportCardController as UserReportCardController;
use App\Http\Controllers\User\GraduationGradeController as UserGraduationGradeController;
use App\Http\Controllers\User\PPDBGradeController as UserPPDBGradeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ===========================================
// Rute Login (umum untuk semua pengguna)
// ===========================================
Route::middleware('web')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// ===========================================
// Rute Admin
// ===========================================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }], function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Resource Controllers Admin
        Route::resource('students', AdminStudentController::class)->names('admin.students');
        Route::resource('teachers', AdminTeacherController::class)->names('admin.teachers');
        Route::resource('subjects', AdminSubjectController::class)->names('admin.subjects');
        Route::resource('school_years', AdminSchoolYearController::class)->names('admin.school_years');
        Route::resource('student_classes', AdminStudentClassController::class)->names('admin.student_classes');
        Route::resource('users', AdminUserController::class)->names('admin.users');

        // Rute untuk update profil admin
        Route::put('profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::get('profile', [AdminProfileController::class, 'index'])->name('admin.profile.index');
        Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');

        // Rute untuk update data sekolah
        Route::get('school_profiles', [AdminSchoolProfileController::class, 'index'])->name('admin.school_profiles.index');
        Route::get('school_profiles/{id}/edit', [AdminSchoolProfileController::class, 'edit'])->name('admin.school_profiles.edit');
        Route::put('school_profiles/{id}', [AdminSchoolProfileController::class, 'update'])->name('admin.school_profiles.update');
        Route::post('school_profiles/{id}/upload-logo', [AdminSchoolProfileController::class, 'uploadLogo'])->name('admin.school_profiles.uploadLogo');
        Route::delete('school_profiles/{id}/delete-logo', [AdminSchoolProfileController::class, 'deleteLogo'])->name('admin.school_profiles.deleteLogo');

        // Rute untuk menampilkan daftar siswa berdasarkan kelas
        Route::get('report_cards', [AdminReportCardController::class, 'index'])->name('admin.report_cards.index');
        // Rute untuk menampilkan data rapor siswa tertentu
        Route::get('report-cards/{student}/student-report', [AdminReportCardController::class, 'showStudentReport'])->name('admin.report_cards.student_report');
        // Rute untuk melihat detail rapor berdasarkan ID rapor
        Route::get('report_cards/{student}/show/{reportCard}', [AdminReportCardController::class, 'show'])->name('admin.report_cards.show');
        // Rute untuk menampilkan halaman tambah nilai rapor siswa
        Route::get('report_cards/{student}/create', [AdminReportCardController::class, 'create'])->name('admin.report_cards.create');
        // Rute untuk menyimpan nilai rapor baru
        Route::post('report_cards/{student}', [AdminReportCardController::class, 'store'])->name('admin.report_cards.store');
        // Rute untuk menampilkan halaman edit rapor siswa
        Route::get('report_cards/{id}/edit', [AdminReportCardController::class, 'edit'])->name('admin.report_cards.edit');
        // Rute untuk memperbarui data rapor siswa
        Route::put('/report_cards/{student_id}/{report_card_id}', [AdminReportCardController::class, 'update'])->name('admin.report_cards.update');
        // Rute untuk menghapus nilai rapor siswa
        Route::delete('report_cards/{id}', [AdminReportCardController::class, 'destroy'])->name('admin.report_cards.destroy');
        // Rute untuk mengimpor nilai rapor
        Route::post('report_cards/import', [AdminReportCardController::class, 'import'])->name('admin.report_cards.import');
        // Rute untuk mencetak nilai rapor siswa sesuai dengan ID rapor
        Route::get('report_cards/{student}/show/{reportCard}/export-pdf', [AdminReportCardController::class, 'exportPdf'])->name('admin.report_cards.export-pdf');


        Route::get('graduation_grades', [AdminGraduationGradeController::class, 'index'])->name('admin.graduation_grades.index');
        // Route untuk menampilkan detail nilai raport per siswa
        Route::get('graduation_grades/{studentId}', [AdminGraduationGradeController::class, 'show'])->name('admin.graduation_grades.show');
        // Route untuk mencetak nilai ijazah sesuai dengan ID siswa
        Route::get('graduation_grades/{studentId}/export-pdf', [AdminGraduationGradeController::class, 'exportPdf'])->name('admin.graduation_grades.export-pdf');


        Route::get('ppdb_grades', [AdminPPDBGradeController::class, 'index'])->name('admin.ppdb_grades.index');
        // Route untuk menampilkan detail nilai raport per siswa
        Route::get('ppdb_grades/{studentId}', [AdminPPDBGradeController::class, 'show'])->name('admin.ppdb_grades.show');
        // Route untuk mencetak ijazah ppdb sesuai dengan ID siswa
        Route::get('ppdb_grades/{studentId}/export-pdf', [AdminPPDBGradeController::class, 'exportPdf'])->name('admin.ppdb_grades.export-pdf');


        // Import & Export routes Admin
        Route::post('students/import', [AdminStudentController::class, 'import'])->name('admin.students.import');
    });
});

// ===========================================
// Rute User
// ===========================================
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }], function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

        // Resource Controllers User
        Route::resource('students', UserStudentController::class)->names('user.students');
        Route::resource('subjects', UserSubjectController::class)->names('user.subjects');
        Route::resource('school_years', UserSchoolYearController::class)->names('user.school_years');

        // Rute untuk update profil user
        Route::put('profile', [UserProfileController::class, 'update'])->name('user.profile.update');
        Route::get('profile', [UserProfileController::class, 'index'])->name('user.profile.index');
        Route::get('profile/edit', [UserProfileController::class, 'edit'])->name('user.profile.edit');

        Route::get('school_profiles', [UserSchoolProfileController::class, 'index'])->name('user.school_profiles.index');

        // Rute untuk menampilkan daftar siswa berdasarkan kelas
        Route::get('report_cards', [UserReportCardController::class, 'index'])->name('user.report_cards.index');
        // Rute untuk menampilkan data rapor siswa tertentu
        Route::get('report-cards/{student}/student-report', [UserReportCardController::class, 'showStudentReport'])->name('user.report_cards.student_report');
        // Rute untuk melihat detail rapor berdasarkan ID rapor
        Route::get('report_cards/{student}/show/{reportCard}', [UserReportCardController::class, 'show'])->name('user.report_cards.show');
        // Rute untuk menampilkan halaman tambah nilai rapor siswa
        Route::get('report_cards/{student}/create', [UserReportCardController::class, 'create'])->name('user.report_cards.create');
        // Rute untuk menyimpan nilai rapor baru
        Route::post('report_cards/{student}', [UserReportCardController::class, 'store'])->name('user.report_cards.store');
        // Rute untuk menampilkan halaman edit rapor siswa
        Route::get('report_cards/{id}/edit', [UserReportCardController::class, 'edit'])->name('user.report_cards.edit');
        // Rute untuk memperbarui data rapor siswa
        Route::put('/report_cards/{student_id}/{report_card_id}', [UserReportCardController::class, 'update'])->name('user.report_cards.update');
        // Rute untuk menghapus nilai rapor siswa
        Route::delete('report_cards/{id}', [UserReportCardController::class, 'destroy'])->name('user.report_cards.destroy');
        // Rute untuk mengimpor nilai rapor
        Route::post('report_cards/import', [UserReportCardController::class, 'import'])->name('user.report_cards.import');
        // Rute untuk mencetak nilai rapor siswa sesuai dengan ID rapor
        Route::get('report_cards/{student}/show/{reportCard}/export-pdf', [UserReportCardController::class, 'exportPdf'])->name('user.report_cards.export-pdf');

        Route::get('graduation_grades', [UserGraduationGradeController::class, 'index'])->name('user.graduation_grades.index');
        // Route untuk menampilkan detail nilai raport per siswa
        Route::get('graduation_grades/{studentId}', [UserGraduationGradeController::class, 'show'])->name('user.graduation_grades.show');
        // Route untuk mencetak nilai ijazah sesuai dengan ID siswa
        Route::get('graduation_grades/{studentId}/export-pdf', [UserGraduationGradeController::class, 'exportPdf'])->name('user.graduation_grades.export-pdf');

        Route::get('ppdb_grades', [UserPPDBGradeController::class, 'index'])->name('user.ppdb_grades.index');
        // Route untuk menampilkan detail nilai raport per siswa
        Route::get('ppdb_grades/{studentId}', [UserPPDBGradeController::class, 'show'])->name('user.ppdb_grades.show');
        // Route untuk mencetak ijazah ppdb sesuai dengan ID siswa
        Route::get('ppdb_grades/{studentId}/export-pdf', [UserPPDBGradeController::class, 'exportPdf'])->name('user.ppdb_grades.export-pdf');

        // Import & Export routes User
        Route::post('students/import', [UserStudentController::class, 'import'])->name('user.students.import');
    });
});

// ===========================================
// Rute untuk mengakses file yang ada di storage/public/
// ===========================================
Route::get('storage/{filename}', function ($filename) {
    $path = storage_path('app/public/' . $filename);
    if (file_exists($path)) {
        return response()->file($path);
    } else {
        abort(404);
    }
});
