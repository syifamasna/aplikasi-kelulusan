<?php

namespace App\Http\Controllers\User;

use App\Models\SchoolProfile;
use App\Http\Controllers\Controller;

class SchoolProfileController extends Controller
{
    public function index()
    {
        $school_profiles = SchoolProfile::first(); // Ambil data pertama jika hanya ada satu profil sekolah
        return view('user-pages.school_profiles.index', compact('school_profiles'));
    }
}
