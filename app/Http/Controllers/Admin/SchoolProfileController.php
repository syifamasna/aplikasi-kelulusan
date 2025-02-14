<?php

namespace App\Http\Controllers\Admin;

use App\Models\SchoolProfile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolProfileController extends Controller
{
    public function index()
    {
        $school_profiles = SchoolProfile::first(); // Ambil data pertama jika hanya ada satu profil sekolah
        return view('admin-pages.school_profiles.index', compact('school_profiles'));
    }

    public function edit($id)
    {
        $school_profiles = SchoolProfile::find($id);

        if (!$school_profiles) {
            return redirect()->route('admin.school_profiles.index')->with('error', 'Data sekolah tidak ditemukan');
        }

        return view('admin-pages.school_profiles.edit', compact('school_profiles'));
    }

    public function update(Request $request, $id)
    {
        $school_profile = SchoolProfile::findOrFail($id);

        // Validasi input tanpa logo
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'npsn' => 'required|string|max:20',
            'kode_pos' => 'required|string|max:10',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'website' => 'required|string|max:255',
            'kepsek' => 'required|string|max:255'
        ]);

        // Update data kecuali logo
        $school_profile->update($validatedData);

        return redirect()->route('admin.school_profiles.index')->with('success', 'Data sekolah berhasil diperbarui');
    }

    public function uploadLogo(Request $request, $id)
    {
        $school_profile = SchoolProfile::findOrFail($id);

        // Validasi file logo
        $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Hapus logo lama jika ada
        if ($school_profile->logo) {
            Storage::disk('public')->delete($school_profile->logo);
        }

        // Simpan logo baru
        $imagePath = $request->file('logo')->store('school_logos', 'public');
        $school_profile->update(['logo' => $imagePath]);

        return redirect()->back()->with('success', 'Logo sekolah berhasil diperbarui');
    }

    public function deleteLogo($id)
    {
        $school_profile = SchoolProfile::findOrFail($id);

        // Hapus logo jika ada
        if ($school_profile->logo) {
            Storage::disk('public')->delete($school_profile->logo);
            $school_profile->update(['logo' => null]);
        }

        return redirect()->back()->with('success', 'Logo sekolah berhasil dihapus');
    }
}
