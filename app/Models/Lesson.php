<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'video_url',
        'pdf_url',
        'order',
        'academicYear',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($lesson) {
            if (empty($lesson->academicYear) && $lesson->course) {
                $lesson->academicYear = $lesson->course->academicYear;
            }
        });
    }

    /**
     * Get the course that owns this lesson.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
