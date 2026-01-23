<?php

namespace App\Http\Controllers\Student;

use App\Models\Course;
use App\Models\Lesson;
use App\Http\Controllers\Controller;

class LessonController extends Controller
{
    /**
     * Display all available courses for the student.
     */
    public function courses()
    {
        $courses = Course::with('lessons')->get();
        return $this->localeView('student.courses.index', compact('courses'));
    }

    /**
     * Display a specific course with its lessons.
     */
    public function show(Course $course)
    {
        $student = auth()->guard('web')->user();

        // Check if student has valid subscription
        if (!$student->hasValidSubscription()) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Your subscription has expired. Please renew your payment to access course materials.');
        }

        $lessons = $course->lessons;
        return $this->localeView('student.lessons.show-course', compact('course', 'lessons'));
    }

    /**
     * Display a specific lesson with video and PDF.
     */
    public function view(Course $course, Lesson $lesson)
    {
        // Verify lesson belongs to course
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $student = auth()->guard('web')->user();

        // Check if student has valid subscription
        if (!$student->hasValidSubscription()) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Your subscription has expired. Please renew your payment to access course materials.');
        }

        $expiryDate = $student->getSubscriptionExpiryDate();
        return $this->localeView('student.lessons.view', compact('course', 'lesson', 'expiryDate'));
    }
}
