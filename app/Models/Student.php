<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students'; // Nama tabel di database

    protected $fillable = [
        'nama',
        'kelas',
        'jk',
        'nis',
        'nisn',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'kelas'); // Menggunakan 'kelas' sebagai kolom yang menghubungkan ke User
    }
}
