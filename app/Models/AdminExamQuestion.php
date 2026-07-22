<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'question_text',
        'question_image',
        'order',
        'points',
        'type',
    ];

    public function exam()
    {
        return $this->belongsTo(AdminExam::class, 'exam_id');
    }

    public function choices()
    {
        return $this->hasMany(AdminExamChoice::class, 'question_id')->orderBy('order');
    }

    public function answers()
    {
        return $this->hasMany(AdminExamAnswer::class, 'question_id');
    }
}
