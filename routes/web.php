<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\SubjectController as AdminSubjectController;
use App\Http\Controllers\Admin\StudentClassController as AdminStudentClassController;
use App\Http\Controllers\Admin\SchoolYearController as AdminSchoolYearController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\StudentController as UserStudentController;
use App\Http\Controllers\User\SubjectController as UserSubjectController;
use App\Http\Controllers\User\SchoolYearController as UserSchoolYearController;
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

        // Import & Export routes Admin
        Route::post('students/import', [AdminStudentController::class, 'import'])->name('admin.students.import');
        Route::get('students/export', [AdminStudentController::class, 'export'])->name('admin.students.export');
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

        // Import & Export routes User
        Route::post('students/import', [UserStudentController::class, 'import'])->name('user.students.import');
        Route::get('students/export', [UserStudentController::class, 'export'])->name('user.students.export');
    });
});
