@extends('layouts.user')

@section('title', 'My Attendance')

@section('content')

    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Take Absence</h2>

        <form method="POST" action="{{ route('user.attendance.store') }}" class="flex gap-3">
            @csrf
            <select name="module_id" required
                    class="flex-1 px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                <option value="">Select module</option>
                @foreach ($modules as $module)
                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                @endforeach
            </select>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 transition">
                <i data-lucide="check" class="w-4 h-4"></i> Submit
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800 text-sm">My Absences</h3>
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
                @forelse ($attendances as $attendance)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 text-slate-700">{{ $attendance->module->name }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-medium px-2 py-1 rounded-full bg-red-100 text-red-700">{{ $attendance->status }}</span>
                        </td>
                        <td class="px-5 py-3 text-slate-500">{{ $attendance->date->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-5 py-8 text-center text-slate-400">No records yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection