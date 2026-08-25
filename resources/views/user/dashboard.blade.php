@extends('layouts.user')

@section('title', 'My Dashboard')

@section('bg', 'bg-[#fefce8]')

@section('content')

    <h2 class="text-lg font-semibold text-slate-800">Welcome, {{ $user->username }} 👋</h2>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center mb-3">
                <i data-lucide="credit-card" class="w-4.5 h-4.5"></i>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['subscriptions'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Subscriptions</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center mb-3">
                <i data-lucide="book-open" class="w-4.5 h-4.5"></i>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['modules'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Modules</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center mb-3">
                <i data-lucide="calendar-check" class="w-4.5 h-4.5"></i>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['attendances'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Attendance Records</p>
        </div>
    </div>

    {{-- SUBSCRIPTIONS --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800 text-sm">My Subscriptions</h3>
            <a href="{{ route('user.subscriptions.create') }}" class="text-xs font-medium text-brand-700 hover:text-brand-800">+ Add</a>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-slate-400 uppercase tracking-wide bg-slate-50">
                    <th class="px-5 py-2 font-medium">Type</th>
                    <th class="px-5 py-2 font-medium">Provider</th>
                    <th class="px-5 py-2 font-medium">Price</th>
                    <th class="px-5 py-2 font-medium">End Date</th>
                    <th class="px-5 py-2 font-medium">Status</th>
                    <th class="px-5 py-2 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($subscriptions as $subscription)
                    @php
                        $status = $subscription->end_date && $subscription->end_date->isPast() ? 'expired' : 'active';
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 text-slate-700">{{ $subscription->type->name }}</td>
                        <td class="px-5 py-3 text-slate-500">{{ $subscription->provider }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $subscription->price }} {{ $subscription->currency }}</td>
                        <td class="px-5 py-3 text-slate-500">{{ $subscription->end_date?->format('Y-m-d') }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-medium px-2 py-1 rounded-full {{ $status === 'expired' ? 'bg-red-100 text-red-700' : 'bg-brand-100 text-brand-700' }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('user.subscriptions.edit', $subscription) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-700 text-xs font-medium rounded-lg hover:bg-slate-200 transition">
                                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                </a>
                                <form action="{{ route('user.subscriptions.destroy', $subscription) }}" method="POST" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 text-xs font-medium rounded-lg hover:bg-red-100 transition">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-slate-400">No subscriptions yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- RECENT ATTENDANCE --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Recent Attendance</h3>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-400 uppercase tracking-wide bg-slate-50">
                        <th class="px-5 py-2 font-medium">Module</th>
                        <th class="px-5 py-2 font-medium">Status</th>
                        <th class="px-5 py-2 font-medium">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recentAttendance as $attendance)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 text-slate-700">{{ $attendance->module->name }}</td>
                            <td class="px-5 py-3">
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-red-100 text-red-700">{{ $attendance->status }}</span>
                            </td>
                            <td class="px-5 py-3 text-slate-500">{{ $attendance->date->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-5 py-8 text-center text-slate-400">No attendance yet.</td></tr>
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
                    <tr class="text-left text-xs text-slate-400 uppercase tracking-wide bg-slate-50">
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
                        <tr><td colspan="2" class="px-5 py-8 text-center text-slate-400">No modules yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection