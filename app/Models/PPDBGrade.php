<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPDBGrade extends Model
{
    use HasFactory;

    protected $table = 'ppdb_grades';

    protected $fillable = [
        'student_id',
        'report_card_ids',
        'total_score',
        'total_average',
    ];

    protected $casts = [
        'report_card_ids' => 'array',
        'total_average' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function reportCards()
    {
        return $this->hasMany(ReportCard::class, 'student_id', 'student_id')
            ->whereIn('id', $this->report_card_ids ?? []);
    }
}
