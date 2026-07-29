<?php

namespace App\Http\Controllers\Student;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $student = Student::findOrFail(auth()->id());
        $academicYear = $student->academicYear;

        // Fetch all courses for the student's grade
        $courses = Course::withCount('lessons')
            ->forAcademicYear($academicYear)
            ->get()
            ->map(function($course) use ($student) {
                // Check if student has paid for THIS specific course's month/year
                $course->has_access = $student->hasPaidForMonth($course->month, $course->year);
                return $course;
            });

        return $this->localeView('student.courses.index', compact('courses', 'student'));
    }

    public function show(Course $course)
    {
        $student = Student::findOrFail(auth()->id());

        if ($course->academicYear !== $student->academicYear) {
            abort(404);
        }

        // Must have paid for THIS course's specific month
        if (!$student->hasPaidForMonth($course->month, $course->year)) {
            return redirect()->route('student.courses.index')->with('error', 'Please complete payment for ' . date('F Y', mktime(0,0,0,$course->month, 1, $course->year)) . ' to access this course.');
        }

        $hasAccess = true;
        // Only show lessons that are scheduled for today or in the past
        $lessons = $course->lessons()
            ->where('scheduled_date', '<=', now()->toDateString())
            ->orderBy('scheduled_date')
            ->orderBy('order')
            ->get();

        return $this->localeView('student.courses.show', compact('course', 'lessons', 'student', 'hasAccess'));
    }

    public function showLesson(Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $student = Student::findOrFail(auth()->id());

        if ($course->academicYear !== $student->academicYear) {
            abort(404);
        }

        if (!$student->hasValidSubscription()) {
            return redirect()->route('student.courses.index')->with('error', 'Please complete your payment to access lessons.');
        }

        $hasAccess = true;
        $lessonsCount = $course->lessons()->count();

        return $this->localeView('student.lessons.show', compact('course', 'lesson', 'student', 'hasAccess', 'lessonsCount'));
    }

    public function markAttendance(Request $request)
    {
        $student = Student::findOrFail(auth()->id());
        $today = now()->startOfDay();

        // Update lesson progress
        if ($request->has('lesson_id') && $request->has('percentage')) {
            \App\Models\LessonProgress::updateOrCreate(
                [
                    'student_code' => $student->code,
                    'lesson_id' => $request->lesson_id,
                ],
                [
                    'watch_percentage' => $request->percentage,
                    'last_watched_at' => now(),
                ]
            );
        }

        // Check if attendance already marked for today
        $exists = \App\Models\Attendance::where('student_code', $student->code)
            ->whereDate('date', $today)
            ->exists();

        if (!$exists) {
            \App\Models\Attendance::create([
                'student_code' => $student->code,
                'date' => $today,
                'status' => 'present',
                'academicYear' => $student->academicYear,
                'notes' => 'Auto-marked via lesson completion (80%+)',
            ]);
            return response()->json(['status' => 'success', 'message' => 'Attendance marked']);
        }

        return response()->json(['status' => 'info', 'message' => 'Already marked']);
    }
}
