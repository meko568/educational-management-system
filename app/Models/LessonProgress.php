<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    use HasFactory;

    protected $table = 'lesson_progress';

    protected $fillable = [
        'student_code',
        'lesson_id',
        'watch_percentage',
        'last_watched_at',
    ];

    protected $casts = [
        'last_watched_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_code', 'code');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
