<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all distinct academic years
        $academicYears = DB::table('students')
            ->select('academicYear')
            ->distinct()
            ->orderBy('academicYear', 'desc')
            ->get()
            ->pluck('academicYear')
            ->toArray();

        // Get statistics for each academic year
        $yearStats = [];
        foreach ($academicYears as $year) {
            $students = Student::where('academicYear', $year)->count();
            $exams = DB::table('exams')->where('academicYear', $year)->count();
            $quizzes = DB::table('quizzes')->where('academicYear', $year)->count();
            $attendance = DB::table('attendances')->where('academicYear', $year)->count();

            $yearStats[] = [
                'academicYear' => $year,
                'students' => $students,
                'exams' => $exams,
                'quizzes' => $quizzes,
                'attendance' => $attendance
            ];
        }

        return $this->localeView('academic-year.selector', [
            'academicYears' => $academicYears,
            'yearStats' => $yearStats,
            'user' => $user
        ]);
    }

    public function selectYear($academicYear)
    {
        session(['selectedAcademicYear' => $academicYear]);

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard.year', ['academicYear' => $academicYear]);
        } else {
            return redirect()->route('student.dashboard.year', ['academicYear' => $academicYear]);
        }
    }
}
