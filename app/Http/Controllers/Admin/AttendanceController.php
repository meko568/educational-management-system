<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get academic year from URL parameter or session or default
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');

        // Filter attendance by academic year
        $attendances = Attendance::where('academicYear', $academicYear)
            ->with('student')
            ->latest()
            ->paginate(10);

        return view('admin.attendances.index', compact('attendances', 'academicYear'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');
        $students = Student::where('role', '!=', 'admin')
            ->where('academicYear', $academicYear)
            ->get();
        return view('admin.attendances.create', compact('students', 'academicYear'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_code' => 'required|exists:students,code',
            'date' => 'required|date',
            'status' => 'required|in:present,absent',
            'notes' => 'nullable|string',
        ]);

        // Get the academic year from POST data, query, session, or default
        $academicYear = $request->input('academicYear') ?? $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');

        // Check if attendance already exists for this student and date
        $existingAttendance = Attendance::where('student_code', $validated['student_code'])
            ->where('date', $validated['date'])
            ->first();

        if ($existingAttendance) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Attendance already marked for this student on this date.');
        }

        $validated['academicYear'] = $academicYear;
        Attendance::create($validated);

        return redirect()->route('admin.attendances.index', ['academicYear' => $academicYear])
            ->with('success', 'Attendance marked successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Attendance $attendance)
    {
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');
        return view('admin.attendances.edit', compact('attendance', 'academicYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'status' => 'required|in:present,absent',
            'notes' => 'nullable|string',
        ]);

        $academicYear = $attendance->academicYear;
        $attendance->update($validated);

        return redirect()->route('admin.attendances.index', ['academicYear' => $academicYear])
            ->with('success', 'Attendance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Attendance $attendance)
    {
        $academicYear = $attendance->academicYear;
        $attendance->delete();
        return redirect()->route('admin.attendances.index', ['academicYear' => $academicYear])
            ->with('success', 'Attendance record deleted successfully.');
    }
}
