<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamResult extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exam_id',
        'student_code',
        'marks_obtained',
        'academicYear',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'marks_obtained' => 'integer',
    ];

    /**
     * Get the exam that this result belongs to.
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get the student that this result belongs to.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_code', 'code');
    }
}
