<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers'; // Nama tabel di database

    protected $fillable = [
        'nama',
        'nip',
        'jk_guru',
        'guru_status',
    ];
}
