<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
    use HasFactory;

    // Tentukan table yang digunakan
    protected $table = 'report_cards';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'student_id',
        'tahun_ajar',
        'semester',
        'sakit',
        'izin',
        'alfa',
        'ekskul',
        'nilai_ekskul',
        'ket_ekskul'
    ];

    // Tentukan kolom JSON yang akan dikelola oleh Eloquent
    protected $casts = [
        'ekskul' => 'array',
        'nilai_ekskul' => 'array',
        'ket_ekskul' => 'array',
    ];

    protected $with = ['student'];

    // Relasi dengan tabel Students
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'tahun_ajar', 'tahun_ajar');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'report_card_subjects')
            ->withPivot('nilai');
    }

    public function addSubject($subjectId, $nilai)
    {
        $this->subjects()->attach($subjectId, ['nilai' => $nilai]);
    }

    public function reportCardSubjects()
    {
        return $this->hasMany(ReportCardSubject::class);
    }
}
