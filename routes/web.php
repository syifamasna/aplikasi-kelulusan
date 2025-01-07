<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\SubjectController as AdminSubjectController;
use App\Http\Controllers\Admin\StudentClassController as AdminStudentClassController;
use App\Http\Controllers\Admin\SchoolYearController as AdminSchoolYearController;
use App\Http\Controllers\Admin\ReportCardController as AdminReportCardController;
use App\Http\Controllers\Admin\GraduationGradeController as AdminGraduationGradeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\StudentController as UserStudentController;
use App\Http\Controllers\User\SubjectController as UserSubjectController;
use App\Http\Controllers\User\SchoolYearController as UserSchoolYearController;
use App\Http\Controllers\User\ReportCardController as UserReportCardController;
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

        Route::get('graduation_grades', [AdminGraduationGradeController::class, 'index'])->name('admin.graduation_grades.index');
        // Route untuk menampilkan detail nilai raport per siswa
        Route::get('graduation_grades/{studentId}', [AdminGraduationGradeController::class, 'show'])->name('admin.graduation_grades.show');

        // Import & Export routes Admin
        Route::post('students/import', [AdminStudentController::class, 'import'])->name('admin.students.import');
        Route::get('students/export-pdf', [AdminStudentController::class, 'exportPdf'])->name('admin.students.exportPdf');
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

        // Import & Export routes User
        Route::post('students/import', [UserStudentController::class, 'import'])->name('user.students.import');
        Route::get('students/export', [UserStudentController::class, 'export'])->name('user.students.export');
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
