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
    ];

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'kelas', 'kelas');
    }

    public function reportCards()
    {
        return $this->hasMany(ReportCard::class, 'student_id', 'id');
    }

    public function graduationGrade()
    {
        return $this->hasOne(GraduationGrade::class, 'student_id', 'id');
    }
}
