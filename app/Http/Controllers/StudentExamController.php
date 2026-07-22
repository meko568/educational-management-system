<?php

namespace App\Http\Controllers;

use App\Models\AdminExam;
use App\Models\AdminExamAttempt;
use App\Models\AdminExamAnswer;
use App\Models\Student;
use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentExamController extends Controller
{
    public function index()
    {
        $student = auth()->user();
        
        $availableExams = AdminExam::where('grade', $student->academicYear)
            ->where('start_datetime', '<=', now())
            ->where('end_datetime', '>=', now())
            ->whereDoesntHave('attempts', function ($query) use ($student) {
                $query->where('user_id', $student->code);
            })
            ->with('questions')
            ->orderBy('start_datetime')
            ->get();

        $completedExams = AdminExam::whereHas('attempts', function ($query) use ($student) {
            $query->where('user_id', $student->code);
        })->with(['attempts' => function ($query) use ($student) {
            $query->where('user_id', $student->code);
        }])->get();

        return view('student.exams.index', compact('availableExams', 'completedExams'));
    }

    public function start(AdminExam $exam)
    {
        $student = auth()->user();

        // Check if exam is for student's grade
        if ($exam->grade !== $student->academicYear) {
            return redirect()->route('student.exams.index')
                ->with('error', 'This exam is not for your grade.');
        }

        // Check if exam is available
        if (now()->lt($exam->start_datetime)) {
            return redirect()->route('student.exams.index')
                ->with('error', 'This exam has not started yet.');
        }

        if (now()->gt($exam->end_datetime)) {
            return redirect()->route('student.exams.index')
                ->with('error', 'This exam has expired.');
        }

        // Check if student already attempted
        $existingAttempt = AdminExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', $student->code)
            ->first();

        if ($existingAttempt) {
            return redirect()->route('student.exams.take', $existingAttempt->id)
                ->with('info', 'You already have an attempt in progress.');
        }

        // Create new attempt
        $totalPoints = $exam->questions->sum('points');
        $attempt = AdminExamAttempt::create([
            'exam_id' => $exam->id,
            'user_id' => $student->code,
            'started_at' => now(),
            'total_points' => $totalPoints,
            'status' => 'in_progress',
        ]);

        return redirect()->route('student.exams.take', $attempt->id);
    }

    public function take(AdminExamAttempt $attempt)
    {
        $student = auth()->user();

        // Verify ownership
        if ($attempt->user_id !== $student->code) {
            abort(403);
        }

        // Check if already submitted
        if ($attempt->status !== 'in_progress') {
            return redirect()->route('student.exams.result', $attempt->id);
        }

        // Check if time expired
        $exam = $attempt->exam;
        $elapsedTime = now()->diffInMinutes($attempt->started_at);
        $remainingTime = max(0, $exam->duration_minutes - $elapsedTime);

        if ($remainingTime <= 0) {
            $this->submitExam($attempt);
            return redirect()->route('student.exams.result', $attempt->id)
                ->with('error', 'Time expired. Exam submitted automatically.');
        }

        // Get questions with randomization
        $questions = $exam->questions->shuffle();

        // Load existing answers
        $attempt->load('answers');
        $existingAnswers = $attempt->answers->keyBy('question_id');

        return view('student.exams.take', compact('attempt', 'questions', 'remainingTime', 'existingAnswers'));
    }

    public function saveAnswer(Request $request, AdminExamAttempt $attempt)
    {
        $student = auth()->user();

        // Verify ownership
        if ($attempt->user_id !== $student->code) {
            abort(403);
        }

        if ($attempt->status !== 'in_progress') {
            return response()->json(['error' => 'Exam already submitted'], 400);
        }

        $validated = $request->validate([
            'question_id' => 'required|exists:admin_exam_questions,id',
            'choice_id' => 'nullable|exists:admin_exam_choices,id',
            'text_answer' => 'nullable|string',
        ]);

        // Check if question belongs to this exam
        $question = $attempt->exam->questions()->where('id', $validated['question_id'])->first();
        if (!$question) {
            return response()->json(['error' => 'Invalid question'], 400);
        }

        // Update or create answer
        AdminExamAnswer::updateOrCreate(
            [
                'attempt_id' => $attempt->id,
                'question_id' => $validated['question_id'],
            ],
            [
                'choice_id' => $validated['choice_id'] ?? null,
                'text_answer' => $validated['text_answer'] ?? null,
            ]
        );

        return response()->json(['success' => true]);
    }

    public function submit(AdminExamAttempt $attempt)
    {
        $student = auth()->user();

        // Verify ownership
        if ($attempt->user_id !== $student->code) {
            abort(403);
        }

        $result = $this->submitExam($attempt);

        return redirect()->route('student.exams.result', $attempt->id)
            ->with('success', 'Exam submitted successfully.');
    }

    private function submitExam(AdminExamAttempt $attempt)
    {
        DB::beginTransaction();
        try {
            $attempt->update([
                'submitted_at' => now(),
                'status' => 'submitted',
            ]);

            $earnedPoints = 0;
            $questions = $attempt->exam->questions;

            foreach ($questions as $question) {
                $answer = $attempt->answers()->where('question_id', $question->id)->first();

                if ($answer) {
                    if ($question->type === 'multiple_choice' && $answer->choice_id) {
                        $choice = $question->choices()->where('id', $answer->choice_id)->first();
                        $isCorrect = $choice && $choice->is_correct;
                        $answer->update(['is_correct' => $isCorrect]);
                        if ($isCorrect) {
                            $earnedPoints += $question->points;
                        }
                    } elseif ($question->type === 'true_false' && $answer->choice_id) {
                        $choice = $question->choices()->where('id', $answer->choice_id)->first();
                        $isCorrect = $choice && $choice->is_correct;
                        $answer->update(['is_correct' => $isCorrect]);
                        if ($isCorrect) {
                            $earnedPoints += $question->points;
                        }
                    } elseif ($question->type === 'fill_blank' && $answer->text_answer) {
                        // For fill in the blank, you might need manual grading or exact match
                        // For now, we'll implement exact match
                        $correctChoice = $question->choices()->where('is_correct', true)->first();
                        $isCorrect = $correctChoice && strtolower(trim($answer->text_answer)) === strtolower(trim($correctChoice->choice_text));
                        $answer->update(['is_correct' => $isCorrect]);
                        if ($isCorrect) {
                            $earnedPoints += $question->points;
                        }
                    }
                }
            }

            $score = $attempt->total_points > 0 ? ($earnedPoints / $attempt->total_points) * 100 : 0;

            $attempt->update([
                'earned_points' => $earnedPoints,
                'score' => $score,
            ]);

            // Create ExamResult entry for old system compatibility
            $oldExam = Exam::where('admin_exam_id', $attempt->exam->id)->first();
            
            if ($oldExam) {
                ExamResult::updateOrCreate(
                    [
                        'exam_id' => $oldExam->id,
                        'student_code' => $attempt->user_id,
                    ],
                    [
                        'marks_obtained' => $earnedPoints,
                        'academicYear' => $attempt->exam->grade,
                    ]
                );
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function result(AdminExamAttempt $attempt)
    {
        $student = auth()->user();

        // Verify ownership
        if ($attempt->user_id !== $student->code) {
            abort(403);
        }

        $attempt->load(['exam.questions.choices', 'answers.question', 'answers.choice']);

        return view('student.exams.result', compact('attempt'));
    }
}
