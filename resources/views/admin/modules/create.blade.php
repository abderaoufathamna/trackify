@extends('layouts.admin')

@section('title', 'Add Module')

@section('content')

    <div class="max-w-lg bg-white rounded-2xl border border-slate-200 p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-5">Add Module</h2>

        <form method="POST" action="{{ route('admin.modules.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Module Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Assign to User</label>
                <select name="user_id"
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 transition">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Add Module
            </button>
        </form>
    </div>

@endsection