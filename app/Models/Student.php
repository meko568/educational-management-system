<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ExamResult;
use App\Models\QuizResult;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * These are the fields you can fill using Student::create([...])
     */
    protected $appends = ['plain_password'];

    /**
     * Get the exam results for this student.
     */
    public function examResults()
    {
        return $this->hasMany(ExamResult::class, 'student_code', 'code');
    }

    /**
     * Get the quiz results for this student.
     */
    public function quizResults()
    {
        return $this->hasMany(QuizResult::class, 'student_code', 'code');
    }
    public function getPlainPasswordAttribute()
    {
        return $this->attributes['plain_password'] ?? null;
    }
    protected $primaryKey = 'code';
    protected $fillable = [
        'name',
        'code',
        'password',
        'plain_password',
        'academicYear',
        'phone',
        'parent_phone',
        'paid_at',
    ];

    /**
     * The attributes that should be hidden for arrays (like API responses).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'code' => 'integer',
        'paid_at' => 'datetime',
        'password' => 'hashed'
    ];

    /**
     * Get the exams created by this student.
     */
    public function createdExams(): HasMany
    {
        return $this->hasMany(Exam::class, 'created_by', 'code');
    }

    /**
     * Get the quizzes created by this student.
     */
    public function createdQuizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'created_by', 'code');
    }

    /**
     * Get the attendance records for this student.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_code', 'code');
    }

    /**
     * Get the student's code for password reset.
     */
    public function getEmailForPasswordReset()
    {
        return $this->code;
    }

    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail($notification = null)
    {
        // Return the student's code for password reset notification
        return $this->code;
    }

    /**
     * Send the password reset notification.
     */

    /**
     * Check if the student's payment is still valid (not expired).
     * Assumes paid_at + 1 month = subscription valid until.
     */
    public function hasValidSubscription(): bool
    {
        if (!$this->paid_at) {
            return false;
        }

        $expiryDate = $this->paid_at->copy()->addMonth();
        return now()->lessThanOrEqualTo($expiryDate);
    }

    /**
     * Get the subscription expiry date.
     */
    public function getSubscriptionExpiryDate()
    {
        if (!$this->paid_at) {
            return null;
        }

        return $this->paid_at->copy()->addMonth();
    }
}
