<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'nama',
        'kelas',
        'jk',
        'nis',
        'nisn',
        'ttl'
    ];

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'kelas', 'kelas');
    }

    public function reportCard()
    {
        return $this->hasOne(ReportCard::class, 'student_id', 'id');
    }

    public function reportCards()
    {
        return $this->hasMany(ReportCard::class, 'student_id', 'id');
    }

    public function graduationGrade()
    {
        return $this->hasOne(GraduationGrade::class, 'student_id', 'id');
    }

    public function ppdbGrade()
    {
        return $this->hasOne(PPDBGrade::class, 'student_id', 'id');
    }
}
