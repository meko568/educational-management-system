<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminExamAnswer extends Model
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
        return $this->belongsTo(AdminExamAttempt::class, 'attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(AdminExamQuestion::class, 'question_id');
    }

    public function choice()
    {
        return $this->belongsTo(AdminExamChoice::class, 'choice_id');
    }
}
