<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Exam;
use App\Models\Quiz;
use App\Models\Attendance;
use App\Models\ExamResult;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Default to primary1 academic year
        return $this->showByYear('primary1');
    }

    public function showByYear($academicYear)
    {
        $totalStudents = Student::where('academicYear', $academicYear)->count();
        $totalExams = Exam::where('academicYear', $academicYear)->count();
        $totalQuizzes = Quiz::where('academicYear', $academicYear)->count();
        $totalAttendance = Attendance::where('academicYear', $academicYear)->count();

        // Prepare chart data
        $chartData = [
            'studentPerformance' => $this->getStudentPerformanceData($academicYear),
            'examStats' => $this->getExamStatisticsData($academicYear),
            'quizStats' => $this->getQuizStatisticsData($academicYear),
            'attendance' => $this->getAttendanceData($academicYear)
        ];

        // Test: Force Arabic view for testing
        $viewName = 'admin.dashboard';
        if (app()->getLocale() === 'ar') {
            $viewName = 'ar.admin.dashboard';
        }
        
        return view($viewName, [
            'totalStudents' => $totalStudents,
            'totalExams' => $totalExams,
            'totalQuizzes' => $totalQuizzes,
            'totalAttendance' => $totalAttendance,
            'chartData' => $chartData,
            'hasCharts' => $this->hasChartData($chartData),
            'academicYear' => $academicYear
        ]);
    }

    private function hasChartData($chartData)
    {
        return (!empty($chartData['studentPerformance']['data']) && count($chartData['studentPerformance']['data']) > 0) ||
            (!empty($chartData['examStats']['avgScores']) && count($chartData['examStats']['avgScores']) > 0) ||
            (!empty($chartData['quizStats']['avgScores']) && count($chartData['quizStats']['avgScores']) > 0) ||
            (!empty($chartData['attendance']['total']) && $chartData['attendance']['total'] > 0);
    }

    private function getStudentPerformanceData($academicYear = null)
    {
        // First, get the top 5 students with their average scores
        $query = DB::table('students')
            ->select(
                'students.code',
                'students.name',
                DB::raw('COALESCE(AVG((er.marks_obtained / e.total_marks) * 100), 0) as avg_score')
            )
            ->join('exam_results as er', 'students.code', '=', 'er.student_code')
            ->join('exams as e', 'er.exam_id', '=', 'e.id')
            ->where('e.total_marks', '>', 0)
            ->whereNotNull('er.marks_obtained');

        if ($academicYear) {
            $query->where('e.academicYear', $academicYear);
        }

        $topStudents = $query
            ->groupBy('students.code', 'students.name')
            ->orderBy('avg_score', 'desc')
            ->limit(5)
            ->get();

        // If no students with exam results, return empty data
        if ($topStudents->isEmpty()) {
            return [
                'labels' => [],
                'data' => [],
                'backgroundColors' => [],
                'borderColor' => '#4f46e5',
                'label' => 'Average Score (%)'
            ];
        }

        return [
            'labels' => $topStudents->pluck('name')->toArray(),
            'data' => $topStudents->pluck('avg_score')->map(function ($score) {
                return (float) number_format($score, 2);
            })->toArray(),
            'backgroundColors' => array_fill(0, $topStudents->count(), '#4f46e5'),
            'borderColor' => '#4f46e5',
            'label' => 'Average Score (%)'
        ];
    }

    private function getExamStatisticsData($academicYear = null)
    {
        // Get the latest 5 exams with their statistics
        $query = DB::table('exams')
            ->select(
                'exams.id',
                'exams.title',
                'exams.total_marks',
                DB::raw('COUNT(exam_results.id) as total_attempts'),
                DB::raw('AVG(exam_results.marks_obtained) as avg_score')
            )
            ->leftJoin('exam_results', 'exams.id', '=', 'exam_results.exam_id')
            ->groupBy('exams.id', 'exams.title', 'exams.total_marks');

        if ($academicYear) {
            $query->where('exams.academicYear', $academicYear);
        }

        $exams = $query
            ->orderBy('exams.exam_date', 'desc')
            ->limit(5)
            ->get();

        // If no exams yet, return empty data
        if ($exams->isEmpty()) {
            return [
                'labels' => [],
                'avgScores' => [],
                'totalAttempts' => [],
                'avgScoreColor' => '#10b981',
                'attemptsColor' => '#3b82f6'
            ];
        }

        // Prepare the data for the chart
        $labels = [];
        $avgScores = [];
        $totalAttempts = [];

        foreach ($exams as $exam) {
            $labels[] = $exam->title;
            $totalMarks = $exam->total_marks > 0 ? $exam->total_marks : 1;
            $avgScore = $exam->avg_score ? round(($exam->avg_score / $totalMarks) * 100, 2) : 0;
            $avgScores[] = (float) $avgScore;
            $totalAttempts[] = (int) $exam->total_attempts;
        }

        return [
            'labels' => $labels,
            'avgScores' => $avgScores,
            'totalAttempts' => $totalAttempts,
            'avgScoreColor' => '#10b981',
            'attemptsColor' => '#3b82f6'
        ];
    }

    private function getQuizStatisticsData($academicYear = null)
    {
        // Get the latest 5 quizzes with their statistics
        $query = DB::table('quizzes')
            ->select(
                'quizzes.id',
                'quizzes.title',
                'quizzes.total_marks',
                DB::raw('COUNT(quiz_results.id) as total_attempts'),
                DB::raw('AVG(quiz_results.marks_obtained) as avg_score')
            )
            ->leftJoin('quiz_results', 'quizzes.id', '=', 'quiz_results.quiz_id')
            ->groupBy('quizzes.id', 'quizzes.title', 'quizzes.total_marks');

        if ($academicYear) {
            $query->where('quizzes.academicYear', $academicYear);
        }

        $quizzes = $query
            ->orderBy('quizzes.created_at', 'desc')
            ->limit(5)
            ->get();

        // If no quizzes yet, return empty data
        if ($quizzes->isEmpty()) {
            return [
                'labels' => [],
                'avgScores' => [],
                'totalAttempts' => [],
                'avgScoreColor' => '#f59e0b',
                'attemptsColor' => '#8b5cf6'
            ];
        }

        // Prepare the data for the chart
        $labels = [];
        $avgScores = [];
        $totalAttempts = [];

        foreach ($quizzes as $quiz) {
            $labels[] = $quiz->title;
            $totalMarks = $quiz->total_marks > 0 ? $quiz->total_marks : 1;
            $avgScore = $quiz->avg_score ? round(($quiz->avg_score / $totalMarks) * 100, 2) : 0;
            $avgScores[] = (float) $avgScore;
            $totalAttempts[] = (int) $quiz->total_attempts;
        }

        return [
            'labels' => $labels,
            'avgScores' => $avgScores,
            'totalAttempts' => $totalAttempts,
            'avgScoreColor' => '#f59e0b',
            'attemptsColor' => '#8b5cf6'
        ];
    }

    private function getAttendanceData($academicYear = null)
    {
        // Get attendance counts directly from the database
        $query = DB::table('attendances')
            ->select(
                DB::raw("COUNT(CASE WHEN status = 'present' THEN 1 END) as present_count"),
                DB::raw("COUNT(CASE WHEN status = 'absent' THEN 1 END) as absent_count")
            );

        if ($academicYear) {
            $query->where('academicYear', $academicYear);
        }

        $attendance = $query->first();

        $present = (int) ($attendance->present_count ?? 0);
        $absent = (int) ($attendance->absent_count ?? 0);
        $total = $present + $absent;

        return [
            'present' => $present,
            'absent' => $absent,
            'total' => $total,
            'percentage' => $total > 0 ? round(($present / $total) * 100) : 0,
            'backgroundColors' => ['#10b981', '#ef4444'],
            'labels' => ['Present', 'Absent'],
            'data' => [$present, $absent]
        ];
    }
}
