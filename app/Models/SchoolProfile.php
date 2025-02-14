<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $table = 'school_profiles'; // Nama tabel di database

    protected $fillable = [
        'nama',
        'npsn',
        'kode_pos',
        'telepon',
        'alamat',
        'email',
        'website',
        'kepsek',
        'logo'
    ];
}
