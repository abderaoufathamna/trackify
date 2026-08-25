@extends('layouts.user')

@section('title', 'Add Module')

@section('content')

    <div class="max-w-lg bg-white rounded-2xl border border-slate-200 p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-5">Add Module</h2>

        <form method="POST" action="{{ route('user.modules.store') }}" class="flex gap-3">
            @csrf
            <input type="text" name="name" placeholder="New Module Name" value="{{ old('name') }}" required
                   class="flex-1 px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Add
            </button>
        </form>
    </div>

@endsection