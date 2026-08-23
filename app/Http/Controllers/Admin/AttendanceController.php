<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Module;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with(['student.user', 'module'])
            ->latest('date')
            ->get();

        $absencesByModule = Module::withCount(['attendances as absences_count' => function ($query) {
            $query->where('status', 'absent');
        }])->get();

        return view('admin.attendance.index', compact('attendances', 'absencesByModule'));
    }
}