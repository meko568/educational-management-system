<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lesson;
use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($academicYear, Course $course)
    {
        if ($course->academicYear !== $academicYear) {
            abort(404);
        }
        return $this->localeView('admin.lessons.create', compact('course', 'academicYear'));
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
        return $this->localeView('admin.lessons.edit', compact('course', 'lesson', 'academicYear'));
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
