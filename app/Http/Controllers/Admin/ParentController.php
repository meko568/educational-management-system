<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParentController extends Controller
{
    public function index(Request $request): View
    {
        $parents = StudentParent::orderBy('code')->get();

        $studentNamesByCode = Student::whereIn('code', $parents->flatMap(function ($p) {
            return is_array($p->sons) ? $p->sons : [];
        })->unique()->values()->all())
            ->get(['code', 'name', 'academicYear'])
            ->keyBy('code');

        return $this->localeView('admin.parents.index', compact('parents', 'studentNamesByCode'));
    }
}
