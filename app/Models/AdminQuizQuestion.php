<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminQuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'question_image',
        'order',
        'points',
        'type',
    ];

    public function quiz()
    {
        return $this->belongsTo(AdminQuiz::class, 'quiz_id');
    }

    public function choices()
    {
        return $this->hasMany(AdminQuizChoice::class, 'question_id')->orderBy('order');
    }

    public function answers()
    {
        return $this->hasMany(AdminQuizAnswer::class, 'question_id');
    }
}
