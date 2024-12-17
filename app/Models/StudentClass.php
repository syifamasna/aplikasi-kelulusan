<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    use HasFactory;

    protected $table = 'student_classes'; // Nama tabel di database

    protected $fillable = [
        'kelas',
        'nama_guru',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'kelas', 'kelas');
    }

    // Relasi ke mata pelajaran
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'kelas', 'kelas'); // Asumsi ada kolom `kelas` di tabel `subjects`
    }
}
