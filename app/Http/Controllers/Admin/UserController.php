<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Ambil data kelas dari tabel student_classes
        $classes = StudentClass::all(); // Ambil data kelas
        $user = Auth::user(); // Ambil data pengguna yang sedang login atau edit data pengguna tertentu

        return view('admin-pages.users.create', compact('classes', 'user')); // Pastikan 'classes' dan 'user' dikirim ke view
    }

    public function store(Request $request)
    {
        // Validasi data dari form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'class_id' => 'required|exists:student_classes,kelas', // Validasi untuk class_id
        ]);

        // Enkripsi password
        $validated['password'] = Hash::make($request->password);

        // Simpan data pengguna
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'class_id' => $validated['class_id'], // Menyimpan class_id
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit pengguna
    public function edit($id)
    {
        // Ambil data pengguna yang ingin diedit
        $user = User::findOrFail($id);

        // Ambil semua data kelas
        $classes = StudentClass::all();

        // Kirimkan ke view
        return view('admin-pages.users.edit', compact('user', 'classes'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data dari form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Pastikan email unik kecuali untuk pengguna ini
            'class_id' => 'nullable|exists:student_classes,kelas', // Validasi untuk class_id
        ]);

        // Ambil pengguna berdasarkan id
        $user = User::findOrFail($id);

        // Update data pengguna (name, email, dan class_id)
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'class_id' => $validated['class_id'],
        ]);

        // Jika ada password baru, update password
        if ($request->has('password') && $request->password) {
            $user->password = Hash::make($request->password); // Update password
        }

        // Simpan perubahan
        $user->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.users.index')->with('success', 'Data Pengguna berhasil diperbarui');
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus');
    }
}
