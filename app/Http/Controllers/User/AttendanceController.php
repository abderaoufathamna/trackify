<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        $modules = Auth::user()->modules;

        $attendances = Attendance::with('module')
            ->where('student_id', $student->id)
            ->orderByDesc('date')
            ->get();

        return view('user.attendance.index', compact('attendances', 'modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => ['required', 'exists:modules,id'],
        ]);

        $student = Auth::user()->student;
        $today = today();

        $alreadyMarkedToday = Attendance::where('student_id', $student->id)
            ->where('module_id', $validated['module_id'])
            ->whereDate('date', $today)
            ->exists();

        if ($alreadyMarkedToday) {
            return back()->withErrors(['module_id' => 'Already marked for today.']);
        }

        $absenceCount = Attendance::where('student_id', $student->id)
            ->where('module_id', $validated['module_id'])
            ->where('status', 'absent')
            ->count();

        if ($absenceCount >= 3) {
            return back()->withErrors(['module_id' => 'Maximum absences reached (3).']);
        }

        Attendance::create([
            'student_id' => $student->id,
            'module_id'  => $validated['module_id'],
            'date'       => $today,
            'status'     => 'absent',
        ]);

        return redirect()->route('user.attendance.index')->with('success', 'Absence recorded.');
    }
}