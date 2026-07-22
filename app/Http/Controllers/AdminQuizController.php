<?php

namespace App\Http\Controllers;

use App\Models\AdminQuiz;
use App\Models\AdminQuizQuestion;
use App\Models\AdminQuizChoice;
use App\Models\Quiz;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AdminQuizController extends Controller
{
    public function index()
    {
        $quizzes = AdminQuiz::with('creator')->orderBy('created_at', 'desc')->get();
        return view('admin.quizzes.admin-index', compact('quizzes'));
    }

    public function create(Request $request)
    {
        $selectedGrade = $request->query('grade', 'primary1');
        return view('admin.quizzes.admin-create', compact('selectedGrade'));
    }

    public function store(Request $request)
    {
        $selectedGrade = $request->query('grade', 'primary1');
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
        ]);

        $quiz = AdminQuiz::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'duration_minutes' => $validated['duration_minutes'],
            'start_datetime' => $validated['start_datetime'],
            'end_datetime' => $validated['end_datetime'],
            'grade' => trim($selectedGrade),
            'created_by' => auth()->id(),
        ]);

        // Also create entry in old Quiz system for compatibility
        $oldQuiz = Quiz::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'quiz_date' => $validated['start_datetime'],
            'total_marks' => 0, // Will be updated when questions are added
            'status' => 'active',
            'created_by' => auth()->id(),
            'admin_quiz_id' => $quiz->id,
        ]);

        return redirect()->route('admin.quizzes.questions.create', $quiz->id)
            ->with('success', 'Quiz created successfully. Now add questions.');
    }

    public function show(AdminQuiz $quiz)
    {
        $quiz->load('questions.choices', 'attempts.student');
        return view('admin.quizzes.admin-show', compact('quiz'));
    }

    public function edit(Request $request, AdminQuiz $quiz)
    {
        return view('admin.quizzes.admin-edit', compact('quiz'));
    }

    public function update(Request $request, AdminQuiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
        ]);

        $quiz->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'duration_minutes' => $validated['duration_minutes'],
            'start_datetime' => $validated['start_datetime'],
            'end_datetime' => $validated['end_datetime'],
        ]);

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz updated successfully.');
    }

    public function destroy(AdminQuiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz deleted successfully.');
    }

    public function createQuestions(AdminQuiz $quiz)
    {
        return view('admin.quizzes.questions.create', compact('quiz'));
    }

    public function storeQuestions(Request $request, AdminQuiz $quiz)
    {
        $validated = $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_image' => 'nullable|image|max:5120',
            'questions.*.type' => 'required|in:multiple_choice,true_false,fill_blank',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.choices' => 'required_if:questions.*.type,multiple_choice|array',
            'questions.*.choices.*.choice_text' => 'required_if:questions.*.type,multiple_choice|string',
            'questions.*.correct_choice' => 'required_if:questions.*.type,multiple_choice|integer',
        ]);

        foreach ($validated['questions'] as $index => $questionData) {
            $imagePath = null;
            if (isset($request->file('questions')[$index]['question_image'])) {
                $uploadedFile = Cloudinary::upload($request->file('questions')[$index]['question_image']->getRealPath());
                $imagePath = $uploadedFile->getSecurePath();
            }

            $question = AdminQuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question_text' => $questionData['question_text'],
                'question_image' => $imagePath,
                'order' => $index + 1,
                'points' => $questionData['points'],
                'type' => $questionData['type'],
            ]);

            if ($questionData['type'] === 'multiple_choice' && isset($questionData['choices'])) {
                foreach ($questionData['choices'] as $choiceIndex => $choiceData) {
                    $isCorrect = ($choiceIndex == $questionData['correct_choice']);
                    AdminQuizChoice::create([
                        'question_id' => $question->id,
                        'choice_text' => $choiceData['choice_text'],
                        'is_correct' => $isCorrect,
                        'order' => $choiceIndex + 1,
                    ]);
                }
            }
        }

        // Update total_marks in old Quiz system
        $totalPoints = $quiz->questions()->sum('points');
        $oldQuiz = Quiz::where('admin_quiz_id', $quiz->id)->first();
        
        if ($oldQuiz) {
            $oldQuiz->update(['total_marks' => $totalPoints]);
        }

        return redirect()->route('admin.quizzes.show', $quiz->id)
            ->with('success', 'Questions added successfully.');
    }
}
