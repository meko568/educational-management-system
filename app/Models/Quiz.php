<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\AdminQuiz;

class Quiz extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'exam_id',
        'total_marks',
        'status',
        'created_by',
        'admin_quiz_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_marks' => 'integer',
    ];

    /**
     * Get the exam that this quiz belongs to.
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get the student who created this quiz.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'created_by', 'code');
    }

    /**
     * Get the admin quiz associated with this quiz.
     */
    public function adminQuiz(): BelongsTo
    {
        return $this->belongsTo(AdminQuiz::class, 'admin_quiz_id');
    }
}
