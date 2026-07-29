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

    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class, 'student_code', 'code');
    }

    public function adminExamAttempts()
    {
        return $this->hasMany(AdminExamAttempt::class, 'user_id', 'code');
    }

    public function adminQuizAttempts()
    {
        return $this->hasMany(AdminQuizAttempt::class, 'user_id', 'code');
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
        'password' => 'hashed'
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'student_code', 'code');
    }

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
     * Check if the student has paid for a specific month and year.
     */
    public function hasPaidForMonth($month, $year): bool
    {
        return $this->payments()->where('month', $month)->where('year', $year)->exists();
    }

    /**
     * Check if the student has valid subscription for CURRENT month.
     */
    public function hasValidSubscription(): bool
    {
        return $this->hasPaidForMonth(now()->month, now()->year);
    }

    /**
     * Get the subscription expiry date based on latest payment.
     */
    public function getSubscriptionExpiryDate()
    {
        $latestPayment = $this->payments()->latest('paid_at')->first();

        if (!$latestPayment) {
            return null;
        }

        // Return the last day of the month they paid for
        return \Carbon\Carbon::create($latestPayment->year, $latestPayment->month, 1)->endOfMonth();
    }
}
