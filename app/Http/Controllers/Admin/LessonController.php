<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lesson;
use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($academicYear, Course $course)
    {
        return redirect()->route('admin.courses.show', [$academicYear, $course]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($academicYear, Course $course)
    {
        if ($course->academicYear !== $academicYear) {
            abort(404);
        }

        $suggestedDates = $this->getSuggestedDates($course);
        return $this->localeView('admin.lessons.create', compact('course', 'academicYear', 'suggestedDates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($academicYear, Course $course, Request $request)
    {
        if ($course->academicYear !== $academicYear) {
            abort(404);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'pdf_url' => 'nullable|url',
            'order' => 'required|integer|min:0',
            'scheduled_date' => 'required|date',
        ]);

        $validated['course_id'] = $course->id;
        // The model's booted method will automatically set the academicYear from the course
        $lesson = new Lesson($validated);
        $lesson->course()->associate($course);
        $lesson->save();

        return redirect()->route('admin.courses.show', ['academicYear' => $academicYear, 'course' => $course])
            ->with('success', 'Lesson created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($academicYear, Course $course, Lesson $lesson)
    {
        if ($course->academicYear !== $academicYear || $lesson->course_id !== $course->id) {
            abort(404);
        }

        $allStudents = \App\Models\Student::where('academicYear', $academicYear)
            ->where('role', 'student')
            ->get();

        $progressData = \App\Models\LessonProgress::where('lesson_id', $lesson->id)
            ->get()
            ->keyBy('student_code');

        $stats = $allStudents->map(function($student) use ($progressData) {
            $progress = $progressData->get($student->code);
            return [
                'name' => $student->name,
                'code' => $student->code,
                'watched' => $progress ? true : false,
                'percentage' => $progress ? $progress->watch_percentage : 0,
                'last_watched' => $progress ? $progress->last_watched_at : null,
            ];
        });

        $watchedCount = $stats->where('watched', true)->count();
        $notWatchedCount = $stats->where('watched', false)->count();

        return $this->localeView('admin.lessons.show', compact('course', 'lesson', 'academicYear', 'stats', 'watchedCount', 'notWatchedCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($academicYear, Course $course, Lesson $lesson)
    {
        if ($course->academicYear !== $academicYear) {
            abort(404);
        }
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $suggestedDates = $this->getSuggestedDates($course);
        return $this->localeView('admin.lessons.edit', compact('course', 'lesson', 'academicYear', 'suggestedDates'));
    }

    private function getSuggestedDates(Course $course)
    {
        $schedule = \App\Models\GradeSchedule::where('grade', $course->academicYear)->first();
        $days = $schedule ? $schedule->days : [];

        if (empty($days)) return [];

        $suggestedDates = [];
        $startDate = \Carbon\Carbon::create($course->year, $course->month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            if (in_array($date->format('l'), $days)) {
                $suggestedDates[] = [
                    'date' => $date->format('Y-m-d'),
                    'label' => $date->format('l, M d')
                ];
            }
        }

        return $suggestedDates;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($academicYear, Course $course, Lesson $lesson, Request $request)
    {
        if ($course->academicYear !== $academicYear) {
            abort(404);
        }
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'pdf_url' => 'nullable|url',
            'order' => 'required|integer|min:0',
            'scheduled_date' => 'required|date',
        ]);

        $lesson->update($validated);

        return redirect()->route('admin.courses.show', ['academicYear' => $academicYear, 'course' => $course])
            ->with('success', 'Lesson updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($academicYear, Course $course, Lesson $lesson)
    {
        if ($course->academicYear !== $academicYear) {
            abort(404);
        }
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $lesson->delete();

        return redirect()->route('admin.courses.show', ['academicYear' => $academicYear, 'course' => $course])
            ->with('success', 'Lesson deleted successfully');
    }
}
