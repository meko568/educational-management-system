<?php

namespace App\Http\Controllers;

use App\Models\AdminExam;
use App\Models\AdminExamQuestion;
use App\Models\AdminExamChoice;
use App\Models\Exam;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;

class AdminExamController extends Controller
{
    public function index()
    {
        $exams = AdminExam::with('creator')->orderBy('created_at', 'desc')->get();
        return $this->localeView('admin.exams.admin-index', compact('exams'));
    }

    public function create(Request $request)
    {
        $selectedGrade = $request->query('grade', 'primary1');
        $suggestedDates = $this->getSuggestedDates($selectedGrade);
        return $this->localeView('admin.exams.admin-create', compact('selectedGrade', 'suggestedDates'));
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
        $selectedGrade = $request->query('grade', 'primary1');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
        ]);

        $exam = AdminExam::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'duration_minutes' => $validated['duration_minutes'],
            'start_datetime' => $validated['start_datetime'],
            'end_datetime' => $validated['end_datetime'],
            'grade' => trim($selectedGrade),
            'created_by' => auth()->user()->code,
        ]);

        return redirect()->route('admin.exams.questions.create', $exam->id)
            ->with('success', 'Exam created. Now add questions.');
    }

    public function show(AdminExam $exam)
    {
        $exam->load('questions.choices', 'attempts.student');
        return $this->localeView('admin.exams.admin-show', compact('exam'));
    }

    public function edit(Request $request, AdminExam $exam)
    {
        return $this->localeView('admin.exams.admin-edit', compact('exam'));
    }

    public function update(Request $request, AdminExam $exam)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
        ]);

        $exam->update($validated);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam updated.');
    }

    public function destroy(AdminExam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam deleted.');
    }

    public function createQuestions(AdminExam $exam)
    {
        return $this->localeView('admin.exams.questions.create', compact('exam'));
    }

    public function storeQuestions(Request $request, AdminExam $exam)
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
        ]);

        DB::transaction(function () use ($request, $exam, $validated) {
            $exam->questions()->delete();

            foreach ($validated['questions'] as $index => $qData) {
                $imagePath = null;
                if ($request->hasFile("questions.{$index}.question_image")) {
                    $res = Cloudinary::upload($request->file("questions.{$index}.question_image")->getRealPath());
                    $imagePath = $res->getSecurePath();
                }

                $question = AdminExamQuestion::create([
                    'exam_id' => $exam->id,
                    'question_text' => $qData['question_text'],
                    'question_image' => $imagePath,
                    'order' => $index + 1,
                    'points' => $qData['points'],
                    'type' => $qData['type'],
                ]);

                if ($qData['type'] === 'multiple_choice' && !empty($qData['choices'])) {
                    foreach ($qData['choices'] as $cIdx => $cData) {
                        AdminExamChoice::create([
                            'question_id' => $question->id,
                            'choice_text' => $cData['choice_text'],
                            'is_correct' => ($cIdx == ($qData['correct_choice'] ?? -1)),
                            'order' => $cIdx + 1,
                        ]);
                    }
                } elseif ($qData['type'] === 'true_false') {
                    AdminExamChoice::create(['question_id' => $question->id, 'choice_text' => 'True', 'is_correct' => ($qData['correct_answer_tf'] === 'true'), 'order' => 1]);
                    AdminExamChoice::create(['question_id' => $question->id, 'choice_text' => 'False', 'is_correct' => ($qData['correct_answer_tf'] === 'false'), 'order' => 2]);
                } elseif ($qData['type'] === 'fill_blank') {
                    AdminExamChoice::create(['question_id' => $question->id, 'choice_text' => $qData['correct_answer_text'] ?? '', 'is_correct' => true, 'order' => 1]);
                }
            }
        });

        return redirect()->route('admin.exams.index')
            ->with('success', 'Questions saved successfully.');
    }
}
