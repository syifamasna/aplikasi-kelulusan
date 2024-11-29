<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import Hash facade

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index(Request $request)
    {
        $keyword = $request->input('keyword', '');

        $users = User::where('name', 'like', "%$keyword%")
            ->orWhere('role', 'like', "%$keyword%")
            ->orderBy('role', 'asc')
            ->orderBy('name', 'asc')
            ->get();
        return view('admin-pages.users.index', compact('users', 'keyword'));
    }

    // Menampilkan form untuk menambah pengguna
    public function create()
    {
        return view('admin-pages.users.create');
    }


    public function store(Request $request)
    {
        // Validasi data dari form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8', // Validasi untuk password
            'role' => 'required|in:admin,user', // Validasi untuk role
        ]);

        // Enkripsi password
        $validated['password'] = Hash::make($request->password);

        // Simpan data pengguna
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan');
    }


    // Menampilkan form untuk mengedit pengguna
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin-pages.users.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,user',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        if ($request->has('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']); // Jangan perbarui password jika tidak ada perubahan
        }

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui');
    }


    // Menghapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus');
    }
}
