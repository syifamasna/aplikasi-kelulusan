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
}
