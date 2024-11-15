<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',        // Nama mata pelajaran
        'guru_mapel',  // Nama guru pengampu
        'tujuan_pembelajaran'
    ];
}
