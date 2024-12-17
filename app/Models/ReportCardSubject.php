<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCardSubject extends Model
{

    use HasFactory;

    protected $table = 'report_card_subjects';

    protected $fillable = [
        'report_card_id',
        'subject_id',
        'nilai'
    ];

    public function reportCard()
    {
        return $this->belongsTo(ReportCard::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
