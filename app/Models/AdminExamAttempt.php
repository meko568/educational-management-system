<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'user_id',
        'started_at',
        'submitted_at',
        'score',
        'total_points',
        'earned_points',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'score' => 'decimal:2',
    ];

    public function exam()
    {
        return $this->belongsTo(AdminExam::class, 'exam_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id', 'code');
    }

    public function answers()
    {
        return $this->hasMany(AdminExamAnswer::class, 'attempt_id');
    }
}
