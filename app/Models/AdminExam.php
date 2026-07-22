<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration_minutes',
        'start_datetime',
        'end_datetime',
        'grade',
        'created_by',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(Student::class, 'created_by', 'code');
    }

    public function questions()
    {
        return $this->hasMany(AdminExamQuestion::class, 'exam_id')->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(AdminExamAttempt::class, 'exam_id');
    }
}
