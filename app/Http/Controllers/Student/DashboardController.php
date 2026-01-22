<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ExamResult;
use App\Models\QuizResult;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

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

        $attendances = $student->attendances()
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
                    'date' => $att->date->format('Y-m-d'),
                    'status' => $att->status,
                    'subject' => $att->subject ?? 'N/A'
                ])
        ];

        // Prepare chart data
        $chartData = [
            'exam' => [
                'labels' => $examResults->pluck('exam')->toArray(),
                'data' => $examResults->map(function ($exam) {
                    return round($exam['percentage']);
                })->toArray(),
                'backgroundColors' => array_fill(0, count($examResults), '#4f46e5')
            ],
            'quiz' => [
                'labels' => $quizResults->pluck('quiz')->toArray(),
                'data' => $quizResults->map(function ($quiz) {
                    return round($quiz['percentage']);
                })->toArray(),
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
        $viewName = 'student.dashboard';
        if (app()->getLocale() === 'ar') {
            $viewName = 'ar.student.dashboard';
        }
        
        return view($viewName, [
            'student' => $student,
            'examResults' => $examResults,
            'quizResults' => $quizResults,
            'attendance' => $attendance,
            'chartData' => $chartData,
            'academicYear' => $academicYear
        ]);
    }

    private function createExamChart($examResults)
    {
        if ($examResults->isEmpty()) {
            return null;
        }

        $labels = $examResults->pluck('exam');
        $scores = $examResults->pluck('percentage');

        $chart = new Chart();
        $chart->labels($labels);
        $chart->dataset('Score', 'bar', $scores)
            ->color('#4f46e5')
            ->backgroundColor('#4f46e5')
            ->fill(false);

        // Add explicit scale configuration
        $chart->options([
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'title' => ['display' => true, 'text' => 'Score (%)']
                ],
                'x' => [
                    'title' => ['display' => true, 'text' => 'Exams']
                ]
            ]
        ]);

        return $chart;
    }

    private function createQuizChart($quizResults)
    {
        if ($quizResults->isEmpty()) {
            return null;
        }

        $labels = $quizResults->pluck('quiz');
        $scores = $quizResults->pluck('percentage');

        $chart = new Chart();
        $chart->labels($labels);
        $chart->dataset('Score', 'line', $scores)
            ->color('#10b981')
            ->backgroundColor('rgba(16, 185, 129, 0.1)')
            ->fill(true);

        // Add explicit scale configuration
        $chart->options([
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'title' => ['display' => true, 'text' => 'Score (%)']
                ],
                'x' => [
                    'title' => ['display' => true, 'text' => 'Quizzes']
                ]
            ]
        ]);

        return $chart;
    }

    // Removed createAttendanceChart method as we're handling it in the view now
}
