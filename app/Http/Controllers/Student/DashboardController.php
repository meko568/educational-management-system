<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ExamResult;
use App\Models\QuizResult;
use App\Models\AdminExamAttempt;
use App\Models\AdminQuizAttempt;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\AdminQuiz;
use App\Models\AdminExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Student::with(['examResults.exam', 'quizResults.quiz', 'attendances'])
            ->findOrFail(Auth::id());

        return $this->getDashboardData($student, $student->academicYear);
    }

    private function getDashboardData($student, $academicYear)
    {
        // 1. Fetch Manual Exam Results
        $manualExamResults = $student->examResults()
            ->with('exam')
            ->get()
            ->filter(fn($r) => $r->exam && $r->exam->academicYear === $academicYear && is_null($r->exam->admin_exam_id))
            ->map(fn($r) => [
                'title' => $r->exam->title,
                'type' => 'Manual',
                'marks' => $r->marks_obtained,
                'total' => $r->exam->total_marks,
                'percentage' => $r->exam->total_marks > 0 ? ($r->marks_obtained / $r->exam->total_marks) * 100 : 0,
                'date' => $r->exam->exam_date ? $r->exam->exam_date->format('Y-m-d') : $r->created_at->format('Y-m-d')
            ]);

        // 2. Fetch Auto-Revision Exam Results
        $autoExamAttempts = AdminExamAttempt::where('user_id', $student->code)
            ->where('status', 'submitted')
            ->with('exam')
            ->get()
            ->filter(fn($a) => $a->exam && $a->exam->grade === $academicYear)
            ->map(fn($a) => [
                'title' => $a->exam->title,
                'type' => 'Auto-Revision',
                'marks' => $a->score,
                'total' => 100, // Score is usually percentage in auto-revision or check total_points
                'percentage' => (float) $a->score,
                'date' => $a->submitted_at ? $a->submitted_at->format('Y-m-d') : $a->created_at->format('Y-m-d')
            ]);

        $allExams = $manualExamResults->concat($autoExamAttempts)->sortByDesc('date');

        // 3. Fetch Manual Quiz Results
        $manualQuizResults = $student->quizResults()
            ->with('quiz')
            ->get()
            ->filter(fn($r) => $r->quiz && $r->quiz->academicYear === $academicYear && is_null($r->quiz->admin_quiz_id))
            ->map(fn($r) => [
                'title' => $r->quiz->title,
                'type' => 'Manual',
                'marks' => $r->marks_obtained,
                'total' => $r->quiz->total_marks,
                'percentage' => $r->quiz->total_marks > 0 ? ($r->marks_obtained / $r->quiz->total_marks) * 100 : 0,
                'date' => $r->created_at->format('Y-m-d')
            ]);

        // 4. Fetch Auto-Revision Quiz Results
        $autoQuizAttempts = AdminQuizAttempt::where('user_id', $student->code)
            ->where('status', 'submitted')
            ->with('quiz')
            ->get()
            ->filter(fn($a) => $a->quiz && $a->quiz->grade === $academicYear)
            ->map(fn($a) => [
                'title' => $a->quiz->title,
                'type' => 'Auto-Revision',
                'marks' => $a->score,
                'total' => 100,
                'percentage' => (float) $a->score,
                'date' => $a->submitted_at ? $a->submitted_at->format('Y-m-d') : $a->created_at->format('Y-m-d')
            ]);

        $allQuizzes = $manualQuizResults->concat($autoQuizAttempts)->sortByDesc('date');

        // 5. Fetch Available Quizzes and Exams for the student
        $availableQuizzes = AdminQuiz::where('grade', $academicYear)
            ->where('start_datetime', '<=', now())
            ->where('end_datetime', '>=', now())
            ->whereDoesntHave('attempts', function ($query) use ($student) {
                $query->where('user_id', $student->code);
            })
            ->withCount('questions')
            ->orderBy('start_datetime')
            ->get();

        $availableExams = AdminExam::where('grade', $academicYear)
            ->where('start_datetime', '<=', now())
            ->where('end_datetime', '>=', now())
            ->whereDoesntHave('attempts', function ($query) use ($student) {
                $query->where('user_id', $student->code);
            })
            ->withCount('questions')
            ->orderBy('start_datetime')
            ->get();

        // 6. Fetch Courses
        $courses = Course::withCount('lessons')
            ->where('academicYear', $academicYear)
            ->get();

        $attendances = $student->attendances()
            ->where('academicYear', $academicYear)
            ->get();

        $attendanceData = [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'percentage' => $attendances->count() > 0
                ? round(($attendances->where('status', 'present')->count() / $attendances->count()) * 100, 2)
                : 0,
            'recent' => $attendances->sortByDesc('date')->take(5)->map(fn($att) => [
                'date' => $att->date->format('Y-m-d'),
                'status' => $att->status,
                'subject' => $att->subject ?? 'General'
            ])
        ];

        $chartData = [
            'manualExam' => [
                'labels' => $manualExamResults->values()->pluck('title')->toArray(),
                'data' => $manualExamResults->values()->pluck('percentage')->map(fn($p) => round($p))->toArray(),
            ],
            'autoExam' => [
                'labels' => $autoExamAttempts->values()->pluck('title')->toArray(),
                'data' => $autoExamAttempts->values()->pluck('percentage')->map(fn($p) => round($p))->toArray(),
            ],
            'manualQuiz' => [
                'labels' => $manualQuizResults->values()->pluck('title')->toArray(),
                'data' => $manualQuizResults->values()->pluck('percentage')->map(fn($p) => round($p))->toArray(),
            ],
            'autoQuiz' => [
                'labels' => $autoQuizAttempts->values()->pluck('title')->toArray(),
                'data' => $autoQuizAttempts->values()->pluck('percentage')->map(fn($p) => round($p))->toArray(),
            ],
            'attendance' => [
                'labels' => ['Present', 'Absent'],
                'data' => [(int)$attendanceData['present'], (int)$attendanceData['absent']],
                'backgroundColors' => ['#10b981', '#ef4444']
            ]
        ];

        return $this->localeView('student.dashboard', [
            'student' => $student,
            'exams' => $allExams,
            'quizzes' => $allQuizzes,
            'availableQuizzes' => $availableQuizzes,
            'availableExams' => $availableExams,
            'courses' => $courses,
            'attendance' => $attendanceData,
            'chartData' => $chartData,
            'academicYear' => $academicYear
        ]);
    }
}
