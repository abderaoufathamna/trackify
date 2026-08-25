@extends('layouts.admin')

@section('title', 'All Students')

@section('content')

    <h2 class="text-lg font-semibold text-slate-800">All Students</h2>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-slate-400 uppercase tracking-wide bg-slate-50">
                    <th class="px-5 py-3 font-medium">#</th>
                    <th class="px-5 py-3 font-medium">Full Name</th>
                    <th class="px-5 py-3 font-medium">Username</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($students as $student)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 text-slate-400">{{ $student->id }}</td>
                        <td class="px-5 py-3 text-slate-700 font-medium">{{ $student->user->full_name }}</td>
                        <td class="px-5 py-3 text-slate-500">{{ $student->user->username }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-5 py-8 text-center text-slate-400">No students yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection