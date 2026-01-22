<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'exam_date',
        'total_marks',
        'status',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'exam_date' => 'date',
        'total_marks' => 'integer',
    ];

    /**
     * Get the student who created this exam.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'created_by', 'code');
    }

    /**
     * Get the quizzes associated with this exam.
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get all exam results for this exam.
     */
    public function examResults(): HasMany
    {
        return $this->hasMany(ExamResult::class);
    }
}
