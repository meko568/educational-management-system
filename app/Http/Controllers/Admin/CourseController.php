<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $academicYear)
    {
        $courses = Course::withCount('lessons')
            ->forAcademicYear($academicYear)
            ->get();
            
        return view('admin.courses.index', compact('courses', 'academicYear'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($academicYear)
    {
        return view('admin.courses.create', compact('academicYear'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $academicYear)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:courses,code,NULL,id,academicYear,' . $academicYear,
            'description' => 'nullable|string',
        ]);
        
        $validated['academicYear'] = $academicYear;

        Course::create($validated);

        return redirect()->route('admin.courses.index', ['academicYear' => $academicYear])
            ->with('success', 'Course created successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show($academicYear, Course $course)
    {
        if ($course->academicYear !== $academicYear) {
            abort(404);
        }
        $lessons = $course->lessons;
        return view('admin.courses.show', compact('course', 'lessons', 'academicYear'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($academicYear, Course $course)
    {
        if ($course->academicYear !== $academicYear) {
            abort(404);
        }
        return view('admin.courses.edit', compact('course', 'academicYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $academicYear, Course $course)
    {
        if ($course->academicYear !== $academicYear) {
            abort(404);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:courses,code,' . $course->id . ',id,academicYear,' . $academicYear,
            'description' => 'nullable|string',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index', ['academicYear' => $academicYear])
            ->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($academicYear, Course $course)
    {
        if ($course->academicYear !== $academicYear) {
            abort(404);
        }
        $course->delete();

        return redirect()->route('admin.courses.index', ['academicYear' => $academicYear])
            ->with('success', 'Course deleted successfully');
    }
}
