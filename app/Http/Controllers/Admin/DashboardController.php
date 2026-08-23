<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Module;
use App\Models\Subscription;
use App\Models\Student;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'admins'        => User::where('role', 'admin')->count(),
            'users'         => User::where('role', 'user')->count(),
            'students'      => Student::count(),
            'modules'       => Module::count(),
            'attendances'   => Attendance::count(),
            'subscriptions' => Subscription::count(),
        ];

        $latestSubscriptions = Subscription::with(['user', 'type'])
            ->latest('id')
            ->take(10)
            ->get();
        
        $latestUsers = User::latest('id')
            ->take(5)
            ->get(['id', 'username', 'role', 'created_at']);
        
        $recentAttendance = Attendance::with(['student.user', 'module'])
            ->latest('id')
            ->take(5)
            ->get();

        $absencesByModule = Module::withCount(['attendances as absences_count' => function ($query) {
            $query->where('status', 'absent');
        }])->get();

        return view('admin.dashboard', compact(
            'stats',
            'latestSubscriptions',
            'latestUsers',
            'recentAttendance',
            'absencesByModule',
        ));
    }
}