<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get academic year from URL parameter or session or default
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');

        // Filter exams by academic year and status
        $exams = Exam::where('status', '!=', 'cancelled')
            ->where('academicYear', $academicYear)
            ->get();

        // Filter quizzes by academic year
        $quizzes = Quiz::where('academicYear', $academicYear)
            ->with(['exam', 'creator'])
            ->latest()
            ->get();

        $latestQuiz = $quizzes->first();

        $students = Student::where('role', '!=', 'admin')
            ->where('academicYear', $academicYear)
            ->get();

        $allResults = QuizResult::whereIn('quiz_id', $quizzes->pluck('id'))
            ->with(['quiz', 'student'])
            ->latest()
            ->get();

        return view('admin.quizzes.manage', compact('exams', 'quizzes', 'students', 'allResults', 'latestQuiz', 'academicYear'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');
        $exams = Exam::where('status', '!=', 'cancelled')
            ->where('academicYear', $academicYear)
            ->get();
        $latestExam = Exam::where('status', '!=', 'cancelled')
            ->where('academicYear', $academicYear)
            ->latest()
            ->first();

        return view('admin.quizzes.create', [
            'exams' => $exams,
            'defaultExamId' => $latestExam ? $latestExam->id : null,
            'academicYear' => $academicYear
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exam_id' => 'nullable|exists:exams,id',
            'total_marks' => 'required|integer|min:1',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Get the academic year from POST data, query, session, or default
        $academicYear = $request->input('academicYear') ?? $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');

        $quiz = new Quiz($validated);
        $quiz->academicYear = $academicYear;
        $quiz->created_by = Auth::id();
        $quiz->save();

        return redirect()->route('admin.quizzes.index', ['academicYear' => $academicYear])
            ->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Quiz $quiz)
    {
        $academicYear = $request->query('academicYear') ?? $quiz->academicYear ?? session('selectedAcademicYear', 'primary1');
        
        // Store the academic year in the session
        if ($academicYear) {
            session(['selectedAcademicYear' => $academicYear]);
        }
        
        $quiz->load(['exam', 'creator']);
        $students = Student::where('role', '!=', 'admin')
            ->where('academicYear', $academicYear)
            ->get();
        $results = QuizResult::where('quiz_id', $quiz->id)
            ->with('student')
            ->get();

        return view('admin.quizzes.show', compact('quiz', 'students', 'results'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Quiz $quiz)
    {
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');
        $exams = Exam::where('status', '!=', 'cancelled')
            ->where('academicYear', $academicYear)
            ->get();
        return view('admin.quizzes.edit', compact('quiz', 'exams', 'academicYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exam_id' => 'nullable|exists:exams,id',
            'total_marks' => 'required|integer|min:1',
            'status' => 'required|in:draft,published,archived',
        ]);

        $academicYear = $quiz->academicYear;
        $quiz->update($validated);

        return redirect()->route('admin.quizzes.index', ['academicYear' => $academicYear])
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Quiz $quiz)
    {
        $academicYear = $quiz->academicYear;
        $quiz->delete();
        return redirect()->route('admin.quizzes.index', ['academicYear' => $academicYear])
            ->with('success', 'Quiz deleted successfully.');
    }

    /**
     * Show quiz results page
     */
    public function results(Quiz $quiz)
    {
        $students = Student::where('role', '!=', 'admin')->get();
        $results = QuizResult::where('quiz_id', $quiz->id)
            ->with('student')
            ->get();

        return view('admin.quizzes.results', compact('quiz', 'students', 'results'));
    }

    /**
     * Store or update quiz result
     */
    public function storeResult(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'student_code' => 'required|exists:students,code',
            'marks_obtained' => 'required|integer|min:0|max:' . $quiz->total_marks,
        ]);
        $student = Student::where('code', $validated['student_code'])->firstOrFail();
        // Get the quiz's academic year
        $academicYear = $quiz->academicYear;

        QuizResult::updateOrCreate(
            [
                'quiz_id' => $quiz->id,
                'student_code' => $validated['student_code'],
            ],
            [
                'marks_obtained' => $validated['marks_obtained'],
                'academicYear' => $student->academicYear,
            ]
        );

        return redirect()->route('admin.quizzes.show', $quiz->id)
            ->with('success', 'Quiz result saved successfully.');
    }

    /**
     * Delete quiz result
     */
    public function deleteResult(Quiz $quiz, QuizResult $result)
    {
        if ($result->quiz_id !== $quiz->id) {
            abort(403);
        }

        $result->delete();
        return redirect()->route('admin.quizzes.show', $quiz->id)
            ->with('success', 'Quiz result deleted successfully.');
    }
}
