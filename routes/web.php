<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentClassController;
use App\Http\Controllers\SchoolYearController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
});

// Routing untuk resource Student
Route::resource('students', StudentController::class);

// Routing untuk resource Teacher
Route::resource('teachers', TeacherController::class);

// Routing untuk resource Subject
Route::resource('subjects', SubjectController::class);

// Routing untuk resource SchoolYear
Route::resource('school_years', SchoolYearController::class);

// Routing untuk resource StudentClass
Route::resource('student_classes', StudentClassController::class);
