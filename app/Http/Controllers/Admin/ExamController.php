<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get academic year from URL parameter or session or default
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');

        // Filter exams by academic year
        $exams = Exam::where('academicYear', $academicYear)
            ->with('creator')
            ->latest()
            ->get();

        $latestExam = $exams->first();

        $students = Student::where('role', '!=', 'admin')
            ->where('academicYear', $academicYear)
            ->get();

        $allResults = ExamResult::whereIn('exam_id', $exams->pluck('id'))
            ->with(['exam', 'student'])
            ->latest()
            ->get();

        return view('admin.exams.manage', compact('exams', 'students', 'allResults', 'latestExam', 'academicYear'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');
        $defaultDate = now()->format('Y-m-d');
        return view('admin.exams.create', compact('defaultDate', 'academicYear'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exam_date' => 'required|date',
            'total_marks' => 'required|integer|min:1',
            'status' => 'required|in:draft,scheduled,in_progress,completed,cancelled',
        ]);

        // Get the academic year from POST data, query, session, or default
        $academicYear = $request->input('academicYear') ?? $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');

        $exam = new Exam($validated);
        $exam->academicYear = $academicYear;
        $exam->created_by = Auth::id();
        $exam->save();

        return redirect()->route('admin.exams.index', ['academicYear' => $academicYear])
            ->with('success', 'Exam created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Exam $exam)
    {
        $academicYear = $request->query('academicYear') ?? $exam->academicYear ?? session('selectedAcademicYear', 'primary1');
        
        // Store the academic year in the session
        if ($academicYear) {
            session(['selectedAcademicYear' => $academicYear]);
        }
        
        $exam->load('quizzes');
        $students = Student::where('role', '!=', 'admin')
            ->where('academicYear', $academicYear)
            ->get();
            
        $results = ExamResult::where('exam_id', $exam->id)
            ->with('student')
            ->get();

        return view('admin.exams.show', compact('exam', 'students', 'results', 'academicYear'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Exam $exam)
    {
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');
        return view('admin.exams.edit', compact('exam', 'academicYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exam_date' => 'required|date',
            'total_marks' => 'required|integer|min:1',
            'status' => 'required|in:draft,scheduled,in_progress,completed,cancelled',
        ]);

        $academicYear = $exam->academicYear;
        $exam->update($validated);

        return redirect()->route('admin.exams.index', ['academicYear' => $academicYear])
            ->with('success', 'Exam updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Exam $exam)
    {
        $academicYear = $exam->academicYear;
        $exam->delete();
        return redirect()->route('admin.exams.index', ['academicYear' => $academicYear])
            ->with('success', 'Exam deleted successfully.');
    }

    /**
     * Show exam results page
     */
    public function results(Exam $exam)
    {
        $students = Student::where('role', '!=', 'admin')->get();
        $results = ExamResult::where('exam_id', $exam->id)
            ->with('student')
            ->get();

        return view('admin.exams.results', compact('exam', 'students', 'results'));
    }

    /**
     * Store or update exam result
     */
    public function storeResult(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'student_code' => 'required|exists:students,code',
            'marks_obtained' => 'required|integer|min:0|max:' . $exam->total_marks,
        ]);
        $student = Student::where('code', $validated['student_code'])->firstOrFail();

        // Get the exam's academic year
        $academicYear = $exam->academicYear;

        ExamResult::updateOrCreate(
            [
                'exam_id' => $exam->id,
                'student_code' => $validated['student_code'],
            ],
            [
                'marks_obtained' => $validated['marks_obtained'],
                'academicYear' => $student->academicYear,
            ]
        );

        return redirect()->route('admin.exams.show', $exam->id)
            ->with('success', 'Exam result saved successfully.');
    }

    /**
     * Delete exam result
     */
    public function deleteResult(Exam $exam, ExamResult $result)
    {
        if ($result->exam_id !== $exam->id) {
            abort(403);
        }

        $result->delete();
        return redirect()->route('admin.exams.show', $exam->id)
            ->with('success', 'Exam result deleted successfully.');
    }
}
