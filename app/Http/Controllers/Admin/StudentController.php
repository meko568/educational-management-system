<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentParent;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Get academic year from URL parameter or session or default
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');

        // Filter students by academic year
        $students = Student::where('academicYear', $academicYear)
            ->where('role', 'student')
            ->latest()
            ->paginate(10);

        return $this->localeView('admin.students.index', compact('students', 'academicYear'));
    }

    public function create(Request $request)
    {
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');
        return $this->localeView('admin.students.create', compact('academicYear'));
    }

    // In app/Http/Controllers/Admin/StudentController.php
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'parent_phone' => 'nullable|string|max:20',
        ]);

        $plainStudentPassword = bin2hex(random_bytes(4)); // 8 characters

        // Get the academic year from POST data, query, session, or default
        $academicYear = $request->input('academicYear') ?? $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');

        $parentPhone = isset($validated['parent_phone']) ? trim((string) $validated['parent_phone']) : null;
        if ($parentPhone === '') {
            $parentPhone = null;
        }

        $createdParent = null;

        $student = DB::transaction(function () use ($validated, $academicYear, $parentPhone, $plainStudentPassword, &$createdParent) {
            $student = Student::create([
                'name' => $validated['name'],
                'academicYear' => $academicYear,
                'phone' => $validated['phone'] ?? null,
                'parent_phone' => $parentPhone,
                'password' => Hash::make($plainStudentPassword),
                'plain_password' => $plainStudentPassword,
            ]);

            if ($parentPhone) {
                $parent = StudentParent::where('phone_number', $parentPhone)->first();

                if (!$parent) {
                    $plainParentPassword = bin2hex(random_bytes(4));

                    $parent = StudentParent::create([
                        'phone_number' => $parentPhone,
                        'password' => Hash::make($plainParentPassword),
                        'plain_password' => $plainParentPassword,
                        'sons' => [$student->code],
                    ]);

                    $createdParent = $parent;
                } else {
                    $sons = is_array($parent->sons) ? $parent->sons : [];
                    if (!in_array($student->code, $sons, true)) {
                        $sons[] = $student->code;
                        $parent->sons = array_values($sons);
                        $parent->save();
                    }
                }
            }

            return $student;
        });

        $message = "Student created. Password: {$plainStudentPassword}";
        if ($createdParent) {
            $message .= " | Parent created. Code: {$createdParent->code} Phone: {$createdParent->phone_number} Password: {$createdParent->plain_password}";
        }

        return redirect()
            ->route('admin.students.index', ['academicYear' => $academicYear])
            ->with('success', $message);
    }

    public function show($code)
    {
        $student = Student::with([
            'attendances',
            'examResults.exam',
            'quizResults.quiz'
        ])->where('code', $code)->firstOrFail();

        return $this->localeView('admin.students.show', compact('student'));
    }

    public function edit(Request $request, Student $student)
    {
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');
        return $this->localeView('admin.students.edit', compact('student', 'academicYear'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:students,code,' . $student->code . ',code',
            'phone' => 'nullable|string|max:20',
            'parent_phone' => 'nullable|string|max:20',
        ]);

        // Get the academic year from POST data, query, session, or default (don't override the student's existing year)
        $academicYear = $request->input('academicYear') ?? $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');

        // Map the form field to the database column
        $updateData = [
            'name' => $validated['name'],
            'code' => $validated['code'],
            'academicYear' => $academicYear,
            'phone' => $validated['phone'] ?? null,
            'parent_phone' => $validated['parent_phone'] ?? null,
        ];

        $student->update($updateData);

        return redirect()
            ->route('admin.students.index', ['academicYear' => $academicYear])
            ->with('success', 'Student updated successfully');
    }

    public function showPayment(Student $student)
    {
        return $this->localeView('admin.students.payment', compact('student'));
    }

    public function processPayment(Student $student)
    {
        $student->update([
            'paid_at' => now()
        ]);

        return redirect()
            ->route('admin.students.payment', $student)
            ->with('success', 'Payment recorded successfully!');
    }
    public function destroy(Request $request, Student $student)
    {
        $academicYear = $request->query('academicYear') ?? session('selectedAcademicYear', 'primary1');
        $student->delete();
        return redirect()->route('admin.students.index', ['academicYear' => $academicYear])
            ->with('success', 'Student deleted successfully.');
    }
}
