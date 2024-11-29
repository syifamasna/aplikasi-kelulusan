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
        $user = User::find(Auth::id());  // Mendapatkan pengguna yang sedang login

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|string|min:8|confirmed', // Pastikan ada validasi 'confirmed'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Cek jika password diisi, maka lakukan hashing dan update
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Cek apakah ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image && Storage::exists('public/images/' . $user->image)) {
                Storage::delete('public/images/' . $user->image);
            }

            // Simpan gambar baru
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->storeAs('images', $request->file('image')->getClientOriginalName(), 'public');
                $user->image = 'images/' . $request->file('image')->getClientOriginalName(); // Menyimpan nama asli file
            }
        }

        // Simpan perubahan user
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
