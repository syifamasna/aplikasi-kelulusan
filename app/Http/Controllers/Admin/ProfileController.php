<?php

namespace App\Http\Controllers\Admin;

use App\Models\User; // Import model User
use Illuminate\Support\Facades\Auth; // Import untuk autentikasi
use Illuminate\Support\Facades\Storage; // Import untuk menangani penyimpanan file
use Illuminate\Http\Request; // Import untuk form request
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login
        return view('admin-pages.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login
        return view('admin-pages.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id()); // Mendapatkan pengguna yang sedang login

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|string|min:8|confirmed', // Validasi 'confirmed' untuk password baru
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Cek jika password diisi, maka lakukan hashing dan update
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Logika penghapusan foto
        if ($request->has('delete_photo') && $request->delete_photo == '1') {
            if ($user->image && Storage::exists('public/' . $user->image)) {
                Storage::delete('public/' . $user->image); // Hapus file dari penyimpanan
            }
            $user->image = null; // Reset nilai kolom image ke null
        } else if ($request->hasFile('image')) { // Jika ada file baru yang diunggah
            // Hapus foto lama jika ada
            if ($user->image && Storage::exists('public/' . $user->image)) {
                Storage::delete('public/' . $user->image);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->storeAs(
                'images',
                $request->file('image')->getClientOriginalName(),
                'public'
            );
            $user->image = 'images/' . $request->file('image')->getClientOriginalName(); // Simpan path ke kolom image
        }

        // Simpan perubahan user
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.profile.index')->with('success', 'Profil berhasil diperbarui');
    }

    public function destroyImage()
    {
        $user = User::find(Auth::id()); // Mendapatkan pengguna yang sedang login

        // Cek apakah pengguna memiliki foto profil
        if ($user->image && Storage::exists('public/' . $user->image)) {
            Storage::delete('public/' . $user->image); // Hapus foto dari penyimpanan
            $user->image = null; // Set kolom image menjadi null
            $user->save(); // Simpan perubahan
        }

        // Redirect dengan pesan sukses
        return redirect()->route('admin.profile.edit')->with('success', 'Foto profil berhasil dihapus');
    }
}
