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
    ];

    public function reportCards()
    {
        return $this->belongsToMany(ReportCard::class, 'report_card_subjects')
            ->withPivot('nilai', 'details'); // Kolom pada pivot harus sesuai
    }
}
