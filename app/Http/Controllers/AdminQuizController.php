<?php

namespace App\Http\Controllers;

use App\Models\AdminQuiz;
use App\Models\AdminQuizQuestion;
use App\Models\AdminQuizChoice;
use App\Models\Quiz;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;

class AdminQuizController extends Controller
{
    public function index(Request $request)
    {
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');
        session(['selectedAcademicYear' => $academicYear]);

        $quizzes = AdminQuiz::with('creator')
            ->where('grade', $academicYear)
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->localeView('admin.quizzes.admin-index', compact('quizzes', 'academicYear'));
    }

    public function create(Request $request)
    {
        $selectedGrade = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');
        $suggestedDates = $this->getSuggestedDates($selectedGrade);
        return $this->localeView('admin.quizzes.admin-create', compact('selectedGrade', 'suggestedDates'));
    }

    private function getSuggestedDates($grade)
    {
        $schedule = \App\Models\GradeSchedule::where('grade', $grade)->first();
        $days = $schedule ? $schedule->days : [];

        if (empty($days)) return [];

        $suggestedDates = [];
        $date = now();
        $count = 0;

        // Loop through the next 60 days but stop once we find 8 matches
        for ($d = $date->copy(); $count < 8 && $d->diffInDays($date) < 60; $d->addDay()) {
            if (in_array($d->format('l'), $days)) {
                $suggestedDates[] = [
                    'date' => $d->format('Y-m-d'),
                    'label' => $d->format('l, M d')
                ];
                $count++;
            }
        }

        return $suggestedDates;
    }

    public function store(Request $request)
    {
        $selectedGrade = $request->input('academicYear') ?? session('selectedAcademicYear', 'primary1');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
        ]);

        $quiz = AdminQuiz::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'duration_minutes' => $validated['duration_minutes'],
            'start_datetime' => $validated['start_datetime'],
            'end_datetime' => $validated['end_datetime'],
            'grade' => trim($selectedGrade),
            'created_by' => auth()->user()->code,
        ]);

        return redirect()->route('admin.quizzes.questions.create', $quiz->id)
            ->with('success', 'Quiz created. Now add questions.');
    }

    public function show(AdminQuiz $quiz)
    {
        $quiz->load('questions.choices', 'attempts.student');
        return $this->localeView('admin.quizzes.admin-show', compact('quiz'));
    }

    public function edit(Request $request, AdminQuiz $quiz)
    {
        return $this->localeView('admin.quizzes.admin-edit', compact('quiz'));
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

        $quiz->update($validated);

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz updated.');
    }

    public function destroy(AdminQuiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz deleted.');
    }

    public function createQuestions(AdminQuiz $quiz)
    {
        $quiz->load('questions.choices');
        return $this->localeView('admin.quizzes.questions.create', compact('quiz'));
    }

    public function storeQuestions(Request $request, AdminQuiz $quiz)
    {
        $validated = $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.type' => 'required|in:multiple_choice,true_false,fill_blank',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.choices' => 'array',
            'questions.*.choices.*.choice_text' => 'string',
            'questions.*.correct_choice' => 'nullable|integer',
            'questions.*.correct_answer_tf' => 'nullable|in:true,false',
            'questions.*.correct_answer_text' => 'nullable|string',
            'questions.*.existing_image' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $quiz, $validated) {
            $quiz->questions()->delete();

            foreach ($validated['questions'] as $index => $qData) {
                $imagePath = $qData['existing_image'] ?? null;
                if ($request->hasFile("questions.{$index}.question_image")) {
                    $res = Cloudinary::upload($request->file("questions.{$index}.question_image")->getRealPath());
                    $imagePath = $res->getSecurePath();
                }

                $question = AdminQuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $qData['question_text'],
                    'question_image' => $imagePath,
                    'order' => $index + 1,
                    'points' => $qData['points'],
                    'type' => $qData['type'],
                ]);

                if ($qData['type'] === 'multiple_choice' && !empty($qData['choices'])) {
                    foreach ($qData['choices'] as $cIdx => $cData) {
                        AdminQuizChoice::create([
                            'question_id' => $question->id,
                            'choice_text' => $cData['choice_text'],
                            'is_correct' => ($cIdx == ($qData['correct_choice'] ?? -1)),
                            'order' => $cIdx + 1,
                        ]);
                    }
                } elseif ($qData['type'] === 'true_false') {
                    AdminQuizChoice::create(['question_id' => $question->id, 'choice_text' => 'True', 'is_correct' => ($qData['correct_answer_tf'] === 'true'), 'order' => 1]);
                    AdminQuizChoice::create(['question_id' => $question->id, 'choice_text' => 'False', 'is_correct' => ($qData['correct_answer_tf'] === 'false'), 'order' => 2]);
                } elseif ($qData['type'] === 'fill_blank') {
                    AdminQuizChoice::create(['question_id' => $question->id, 'choice_text' => $qData['correct_answer_text'] ?? '', 'is_correct' => true, 'order' => 1]);
                }
            }
        });

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Questions saved successfully.');
    }
}
