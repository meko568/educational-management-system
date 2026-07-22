<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminQuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'question_id',
        'choice_id',
        'text_answer',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function attempt()
    {
        return $this->belongsTo(AdminQuizAttempt::class, 'attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(AdminQuizQuestion::class, 'question_id');
    }

    public function choice()
    {
        return $this->belongsTo(AdminQuizChoice::class, 'choice_id');
    }
}
