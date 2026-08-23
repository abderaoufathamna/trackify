<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        $modules = $user->modules;

        $subscriptions = $user->subscriptions()->with('type')->latest('id')->get();

        $recentAttendance = Attendance::with('module')
            ->where('student_id', $student->id)
            ->latest('id')
            ->take(5)
            ->get();

        $absencesByModule = Module::where('user_id', $user->id)
            ->withCount(['attendances as absences_count' => function ($query) {
                $query->where('status', 'absent');
            }])->get();

        $stats = [
            'modules'       => $modules->count(),
            'subscriptions' => $subscriptions->count(),
            'attendances'   => $recentAttendance->count(),
        ];

        return view('user.dashboard', compact(
            'user', 'modules', 'subscriptions', 'recentAttendance', 'absencesByModule', 'stats'
        ));
    }
}