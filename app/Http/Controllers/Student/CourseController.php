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

        $courses = Course::withCount('lessons')
            ->forAcademicYear($academicYear)
            ->get();

        return view('student.courses.index', compact('courses', 'student'));
    }

    public function show(Course $course)
    {
        $student = Student::findOrFail(auth()->id());

        if ($course->academicYear !== $student->academicYear) {
            abort(404);
        }

        $hasAccess = $student->hasValidSubscription();
        $lessons = $course->lessons()->orderBy('order')->get();

        return view('student.courses.show', compact('course', 'lessons', 'student', 'hasAccess'));
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

        $hasAccess = $student->hasValidSubscription();
        $lessonsCount = $course->lessons()->count();

        return view('student.lessons.show', compact('course', 'lesson', 'student', 'hasAccess', 'lessonsCount'));
    }
}