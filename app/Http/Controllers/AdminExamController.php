<?php

namespace App\Http\Controllers;

use App\Models\AdminExam;
use App\Models\AdminExamQuestion;
use App\Models\AdminExamChoice;
use App\Models\Exam;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AdminExamController extends Controller
{
    public function index()
    {
        $exams = AdminExam::with('creator')->orderBy('created_at', 'desc')->get();
        return view('admin.exams.admin-index', compact('exams'));
    }

    public function create(Request $request)
    {
        $selectedGrade = $request->query('grade', 'primary1');
        return view('admin.exams.admin-create', compact('selectedGrade'));
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
            'description' => $validated['description'],
            'duration_minutes' => $validated['duration_minutes'],
            'start_datetime' => $validated['start_datetime'],
            'end_datetime' => $validated['end_datetime'],
            'grade' => trim($selectedGrade),
            'created_by' => auth()->id(),
        ]);

        // Also create entry in old Exam system for compatibility
        $oldExam = Exam::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'exam_date' => $validated['start_datetime'],
            'total_marks' => 0, // Will be updated when questions are added
            'status' => 'active',
            'created_by' => auth()->id(),
            'admin_exam_id' => $exam->id,
        ]);

        return redirect()->route('admin.exams.questions.create', $exam->id)
            ->with('success', 'Exam created successfully. Now add questions.');
    }

    public function show(AdminExam $exam)
    {
        $exam->load('questions.choices', 'attempts.student');
        return view('admin.exams.admin-show', compact('exam'));
    }

    public function edit(Request $request, AdminExam $exam)
    {
        return view('admin.exams.admin-edit', compact('exam'));
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

        $exam->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'duration_minutes' => $validated['duration_minutes'],
            'start_datetime' => $validated['start_datetime'],
            'end_datetime' => $validated['end_datetime'],
        ]);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam updated successfully.');
    }

    public function destroy(AdminExam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam deleted successfully.');
    }

    public function createQuestions(AdminExam $exam)
    {
        return view('admin.exams.questions.create', compact('exam'));
    }

    public function storeQuestions(Request $request, AdminExam $exam)
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

            $question = AdminExamQuestion::create([
                'exam_id' => $exam->id,
                'question_text' => $questionData['question_text'],
                'question_image' => $imagePath,
                'order' => $index + 1,
                'points' => $questionData['points'],
                'type' => $questionData['type'],
            ]);

            if ($questionData['type'] === 'multiple_choice' && isset($questionData['choices'])) {
                foreach ($questionData['choices'] as $choiceIndex => $choiceData) {
                    $isCorrect = ($choiceIndex == $questionData['correct_choice']);
                    AdminExamChoice::create([
                        'question_id' => $question->id,
                        'choice_text' => $choiceData['choice_text'],
                        'is_correct' => $isCorrect,
                        'order' => $choiceIndex + 1,
                    ]);
                }
            }
        }

        // Update total_marks in old Exam system
        $totalPoints = $exam->questions()->sum('points');
        $oldExam = Exam::where('admin_exam_id', $exam->id)->first();
        
        if ($oldExam) {
            $oldExam->update(['total_marks' => $totalPoints]);
        }

        return redirect()->route('admin.exams.show', $exam->id)
            ->with('success', 'Questions added successfully.');
    }
}
