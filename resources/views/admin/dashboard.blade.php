@extends('layouts.admin')

@section('title', 'Dashboard')
@section('bg', 'bg-[#fefce8]')
@section('content')

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach ([
            ['label' => 'Admins', 'value' => $stats['admins'], 'icon' => 'shield-check'],
            ['label' => 'Users', 'value' => $stats['users'], 'icon' => 'users'],
            ['label' => 'Students', 'value' => $stats['students'], 'icon' => 'graduation-cap'],
            ['label' => 'Modules', 'value' => $stats['modules'], 'icon' => 'book-open'],
            ['label' => 'Attendance', 'value' => $stats['attendances'], 'icon' => 'calendar-check'],
            ['label' => 'Subscriptions', 'value' => $stats['subscriptions'], 'icon' => 'credit-card'],
        ] as $card)
            <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:shadow-md transition">
                <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center mb-3">
                    <i data-lucide="{{ $card['icon'] }}" class="w-4.5 h-4.5"></i>
                </div>
                <p class="text-2xl font-bold text-slate-800">{{ $card['value'] }}</p>
                <p class="text-xs text-slate-500 mt-1">{{ $card['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- LATEST SUBSCRIPTIONS --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Latest Subscriptions</h3>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-400 uppercase tracking-wide">
                        <th class="px-5 py-2 font-medium">User</th>
                        <th class="px-5 py-2 font-medium">Type</th>
                        <th class="px-5 py-2 font-medium">Price</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($latestSubscriptions as $subscription)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 text-slate-700">{{ $subscription->user->username }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ $subscription->type->name }}</td>
                            <td class="px-5 py-3 text-slate-700 font-medium">{{ $subscription->price }} {{ $subscription->currency }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-5 py-6 text-center text-slate-400">No subscriptions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- LATEST USERS --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Latest Users</h3>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-400 uppercase tracking-wide">
                        <th class="px-5 py-2 font-medium">Username</th>
                        <th class="px-5 py-2 font-medium">Role</th>
                        <th class="px-5 py-2 font-medium">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($latestUsers as $user)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 text-slate-700">{{ $user->username }}</td>
                            <td class="px-5 py-3">
                                <span class="text-xs font-medium px-2 py-1 rounded-full
                                    {{ $user->role === 'admin' ? 'bg-brand-100 text-brand-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-slate-500">{{ $user->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-5 py-6 text-center text-slate-400">No users yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- RECENT ATTENDANCE --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Recent Attendance</h3>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-400 uppercase tracking-wide">
                        <th class="px-5 py-2 font-medium">Student</th>
                        <th class="px-5 py-2 font-medium">Module</th>
                        <th class="px-5 py-2 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recentAttendance as $attendance)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 text-slate-700">{{ $attendance->student->user->full_name }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ $attendance->module->name }}</td>
                            <td class="px-5 py-3">
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-red-100 text-red-700">
                                    {{ $attendance->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-5 py-6 text-center text-slate-400">No attendance yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ABSENCES BY MODULE --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Absences by Module</h3>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-400 uppercase tracking-wide">
                        <th class="px-5 py-2 font-medium">Module</th>
                        <th class="px-5 py-2 font-medium">Absences</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($absencesByModule as $module)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 text-slate-700">{{ $module->name }}</td>
                            <td class="px-5 py-3 text-slate-700 font-medium">{{ $module->absences_count }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="px-5 py-6 text-center text-slate-400">No modules yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection