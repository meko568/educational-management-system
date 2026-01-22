<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ExamResult;
use App\Models\QuizResult;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $parent = Auth::guard('parent')->user();
        $sonsCodes = is_array($parent->sons) ? $parent->sons : [];

        $sons = Student::whereIn('code', $sonsCodes)
            ->orderBy('code')
            ->get();

        // Load appropriate view based on locale
        $viewName = 'parent.dashboard';
        if (app()->getLocale() === 'ar') {
            $viewName = 'ar.parent.dashboard';
        }
        
        return view($viewName, compact('parent', 'sons'));
    }

    public function showSon(Request $request, Student $student): View
    {
        $parent = Auth::guard('parent')->user();
        $sonsCodes = is_array($parent->sons) ? $parent->sons : [];

        if (!in_array($student->code, $sonsCodes, true)) {
            abort(403, 'Unauthorized');
        }

        $academicYear = $student->academicYear;

        $examResults = $student->examResults()
            ->whereHas('exam', function ($query) use ($academicYear) {
                $query->where('academicYear', $academicYear);
            })
            ->with('exam')
            ->get()
            ->map(function ($result) {
                return [
                    'exam' => $result->exam->title,
                    'marks_obtained' => $result->marks_obtained,
                    'total_marks' => $result->exam->total_marks,
                    'percentage' => ($result->marks_obtained / $result->exam->total_marks) * 100,
                    'date' => $result->exam->exam_date->format('Y-m-d')
                ];
            });

        $quizResults = $student->quizResults()
            ->whereHas('quiz', function ($query) use ($academicYear) {
                $query->where('academicYear', $academicYear);
            })
            ->with('quiz')
            ->get()
            ->map(function ($result) {
                return [
                    'quiz' => $result->quiz->title,
                    'marks_obtained' => $result->marks_obtained,
                    'total_marks' => $result->quiz->total_marks,
                    'percentage' => ($result->marks_obtained / $result->quiz->total_marks) * 100,
                    'date' => $result->created_at->format('Y-m-d')
                ];
            });

        $attendances = Attendance::where('student_code', $student->code)
            ->where('academicYear', $academicYear)
            ->get();

        $attendance = [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'attendance_percentage' => $attendances->count() > 0
                ? round(($attendances->where('status', 'present')->count() / $attendances->count()) * 100, 2)
                : 0,
            'recent' => $attendances
                ->sortByDesc('created_at')
                ->take(5)
                ->map(fn($att) => [
                    'date_time' => $att->created_at ? $att->created_at->format('Y-m-d H:i') : ($att->date?->format('Y-m-d') ?? 'N/A'),
                    'date' => $att->date?->format('Y-m-d') ?? 'N/A',
                    'status' => $att->status,
                    'notes' => $att->notes,
                ])
        ];

        $chartData = [
            'exam' => [
                'labels' => $examResults->pluck('exam')->toArray(),
                'data' => $examResults->map(fn($exam) => round($exam['percentage']))->toArray(),
                'backgroundColors' => array_fill(0, count($examResults), '#4f46e5')
            ],
            'quiz' => [
                'labels' => $quizResults->pluck('quiz')->toArray(),
                'data' => $quizResults->map(fn($quiz) => round($quiz['percentage']))->toArray(),
                'backgroundColors' => array_fill(0, count($quizResults), '#10b981')
            ],
            'attendance' => [
                'labels' => ['Present', 'Absent'],
                'data' => [
                    (int)($attendance['present'] ?? 0),
                    (int)($attendance['absent'] ?? 0)
                ],
                'backgroundColors' => ['#10b981', '#ef4444']
            ]
        ];

        // Load appropriate view based on locale
        $viewName = 'parent.son-dashboard';
        if (app()->getLocale() === 'ar') {
            $viewName = 'ar.parent.son-dashboard';
        }
        
        return view($viewName, [
            'parent' => $parent,
            'student' => $student,
            'examResults' => $examResults,
            'quizResults' => $quizResults,
            'attendance' => $attendance,
            'chartData' => $chartData,
            'academicYear' => $academicYear,
        ]);
    }
}
