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
}
