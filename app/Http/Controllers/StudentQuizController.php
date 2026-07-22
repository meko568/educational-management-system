<?php

namespace App\Http\Controllers;

use App\Models\AdminQuiz;
use App\Models\AdminQuizAttempt;
use App\Models\AdminQuizAnswer;
use App\Models\Student;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentQuizController extends Controller
{
    public function index()
    {
        $student = auth()->user();
        
        $availableQuizzes = AdminQuiz::where('grade', $student->academicYear)
            ->where('start_datetime', '<=', now())
            ->where('end_datetime', '>=', now())
            ->whereDoesntHave('attempts', function ($query) use ($student) {
                $query->where('user_id', $student->code);
            })
            ->with('questions')
            ->orderBy('start_datetime')
            ->get();

        $completedQuizzes = AdminQuiz::whereHas('attempts', function ($query) use ($student) {
            $query->where('user_id', $student->code);
        })->with(['attempts' => function ($query) use ($student) {
            $query->where('user_id', $student->code);
        }])->get();

        return view('student.quizzes.index', compact('availableQuizzes', 'completedQuizzes'));
    }

    public function start(AdminQuiz $quiz)
    {
        $student = auth()->user();

        // Check if quiz is for student's grade
        if ($quiz->grade !== $student->academicYear) {
            return redirect()->route('student.quizzes.index')
                ->with('error', 'This quiz is not for your grade.');
        }

        // Check if quiz is available
        if (now()->lt($quiz->start_datetime)) {
            return redirect()->route('student.quizzes.index')
                ->with('error', 'This quiz has not started yet.');
        }

        if (now()->gt($quiz->end_datetime)) {
            return redirect()->route('student.quizzes.index')
                ->with('error', 'This quiz has expired.');
        }

        // Check if student already attempted
        $existingAttempt = AdminQuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', $student->code)
            ->first();

        if ($existingAttempt) {
            return redirect()->route('student.quizzes.take', $existingAttempt->id)
                ->with('info', 'You already have an attempt in progress.');
        }

        // Create new attempt
        $totalPoints = $quiz->questions->sum('points');
        $attempt = AdminQuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $student->code,
            'started_at' => now(),
            'total_points' => $totalPoints,
            'status' => 'in_progress',
        ]);

        return redirect()->route('student.quizzes.take', $attempt->id);
    }

    public function take(AdminQuizAttempt $attempt)
    {
        $student = auth()->user();

        // Verify ownership
        if ($attempt->user_id !== $student->code) {
            abort(403);
        }

        // Check if already submitted
        if ($attempt->status !== 'in_progress') {
            return redirect()->route('student.quizzes.result', $attempt->id);
        }

        // Check if time expired
        $quiz = $attempt->quiz;
        $elapsedTime = now()->diffInMinutes($attempt->started_at);
        $remainingTime = max(0, $quiz->duration_minutes - $elapsedTime);

        if ($remainingTime <= 0) {
            $this->submitQuiz($attempt);
            return redirect()->route('student.quizzes.result', $attempt->id)
                ->with('error', 'Time expired. Quiz submitted automatically.');
        }

        // Get questions with randomization
        $questions = $quiz->questions->shuffle();

        // Load existing answers
        $attempt->load('answers');
        $existingAnswers = $attempt->answers->keyBy('question_id');

        return view('student.quizzes.take', compact('attempt', 'questions', 'remainingTime', 'existingAnswers'));
    }

    public function saveAnswer(Request $request, AdminQuizAttempt $attempt)
    {
        $student = auth()->user();

        // Verify ownership
        if ($attempt->user_id !== $student->code) {
            abort(403);
        }

        if ($attempt->status !== 'in_progress') {
            return response()->json(['error' => 'Quiz already submitted'], 400);
        }

        $validated = $request->validate([
            'question_id' => 'required|exists:admin_quiz_questions,id',
            'choice_id' => 'nullable|exists:admin_quiz_choices,id',
            'text_answer' => 'nullable|string',
        ]);

        // Check if question belongs to this quiz
        $question = $attempt->quiz->questions()->where('id', $validated['question_id'])->first();
        if (!$question) {
            return response()->json(['error' => 'Invalid question'], 400);
        }

        // Update or create answer
        AdminQuizAnswer::updateOrCreate(
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

    public function submit(AdminQuizAttempt $attempt)
    {
        $student = auth()->user();

        // Verify ownership
        if ($attempt->user_id !== $student->code) {
            abort(403);
        }

        $result = $this->submitQuiz($attempt);

        return redirect()->route('student.quizzes.result', $attempt->id)
            ->with('success', 'Quiz submitted successfully.');
    }

    private function submitQuiz(AdminQuizAttempt $attempt)
    {
        DB::beginTransaction();
        try {
            $attempt->update([
                'submitted_at' => now(),
                'status' => 'submitted',
            ]);

            $earnedPoints = 0;
            $questions = $attempt->quiz->questions;

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

            // Create QuizResult entry for old system compatibility
            $oldQuiz = Quiz::where('admin_quiz_id', $attempt->quiz->id)->first();
            
            if ($oldQuiz) {
                QuizResult::updateOrCreate(
                    [
                        'quiz_id' => $oldQuiz->id,
                        'student_code' => $attempt->user_id,
                    ],
                    [
                        'marks_obtained' => $earnedPoints,
                        'academicYear' => $attempt->quiz->grade,
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

    public function result(AdminQuizAttempt $attempt)
    {
        $student = auth()->user();

        // Verify ownership
        if ($attempt->user_id !== $student->code) {
            abort(403);
        }

        $attempt->load(['quiz.questions.choices', 'answers.question', 'answers.choice']);

        return view('student.quizzes.result', compact('attempt'));
    }
}
