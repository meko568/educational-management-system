<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradeSchedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $grades = ['primary1', 'primary2', 'primary3', 'primary4', 'primary5', 'primary6', 'prep1', 'prep2', 'prep3', 'sec1', 'sec2', 'sec3'];
        $schedules = GradeSchedule::all()->keyBy('grade');

        return $this->localeView('admin.schedules.index', compact('grades', 'schedules'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'grade' => 'required|string',
            'days' => 'required|array',
            'days.*' => 'string|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
        ]);

        GradeSchedule::updateOrCreate(
            ['grade' => $validated['grade']],
            ['days' => $validated['days']]
        );

        return redirect()->back()->with('success', 'Schedule updated successfully');
    }
}
