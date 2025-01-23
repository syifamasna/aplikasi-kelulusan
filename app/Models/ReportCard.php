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
        'prestasi',
        'ket_prestasi',
        'catatan',
        'ekskul',
        'nilai_ekskul',
        'ket_ekskul',
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
            ->withPivot('nilai', 'details'); // Ambil nilai dan details dari pivot
    }

    public function addSubject($subjectId, $nilai, $details = null)
    {
        $this->subjects()->attach($subjectId, [
            'nilai' => $nilai,
            'details' => $details,  // Laravel akan menangani json encoding dan decoding secara otomatis
        ]);
    }

    public function graduationGradeSubjects()
    {
        return $this->belongsToMany(Subject::class, 'report_card_subjects', 'report_card_id', 'subject_id')
            ->withPivot('nilai');  // Ambil nilai dari pivot
    }

    public function ppdbGradeSubjects()
    {
        return $this->belongsToMany(Subject::class, 'report_card_subjects', 'report_card_id', 'subject_id')
            ->withPivot('nilai');  // Ambil nilai dari pivot
    }
}
