@extends('layouts.admin')

@section('title', 'All Modules')

@section('content')

    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-800">All Modules</h2>
        <a href="{{ route('admin.modules.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 transition">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Add Module
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-slate-400 uppercase tracking-wide bg-slate-50">
                    <th class="px-5 py-3 font-medium">#</th>
                    <th class="px-5 py-3 font-medium">Name</th>
                    <th class="px-5 py-3 font-medium">Owner</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($modules as $module)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 text-slate-400">{{ $module->id }}</td>
                        <td class="px-5 py-3 text-slate-700 font-medium">{{ $module->name }}</td>
                        <td class="px-5 py-3 text-slate-500">{{ $module->user->username }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-5 py-8 text-center text-slate-400">No modules yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection