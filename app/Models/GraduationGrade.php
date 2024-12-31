<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraduationGrade extends Model
{
    use HasFactory;

    // Tabel yang digunakan
    protected $table = 'graduation_grades';

    // Kolom yang boleh diisi (fillable)
    protected $fillable = [
        'student_id',
        'average_subjects',
        'final_average',
    ];

    // Kolom yang menggunakan tipe data JSON
    protected $casts = [
        'average_subjects' => 'array',  // Menyimpan nilai rata-rata setiap mata pelajaran
        'final_average' => 'decimal:2',  // Nilai rata-rata akhir siswa
    ];

    // Relasi dengan tabel siswa (students)
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi dengan tabel report_cards (relasi one-to-many)
    public function reportCards()
    {
        return $this->hasMany(ReportCard::class, 'student_id', 'student_id');
    }

    // Relasi dengan tabel report_card_subjects (relasi many-to-many)
    public function reportCardSubjects()
    {
        return $this->belongsToMany(ReportCardSubject::class, 'report_card_subjects', 'report_card_id', 'subject_id')
            ->withPivot('nilai');
    }
}
