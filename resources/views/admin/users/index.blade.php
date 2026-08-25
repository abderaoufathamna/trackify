@extends('layouts.admin')

@section('title', 'All Users')

@section('content')

    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-800">All Users</h2>
        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 transition">
            <i data-lucide="user-plus" class="w-4 h-4"></i> Add User
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-slate-400 uppercase tracking-wide bg-slate-50">
                    <th class="px-5 py-3 font-medium">#</th>
                    <th class="px-5 py-3 font-medium">Username</th>
                    <th class="px-5 py-3 font-medium">Role</th>
                    <th class="px-5 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 text-slate-400">{{ $user->id }}</td>
                        <td class="px-5 py-3 text-slate-700 font-medium">{{ $user->username }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-medium px-2 py-1 rounded-full
                                {{ $user->role === 'admin' ? 'bg-brand-100 text-brand-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-700 text-xs font-medium rounded-lg hover:bg-slate-200 transition">
                                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Edit
                                </a>

                                @if (!($user->role === 'admin' && $user->id === auth()->id()))
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 text-xs font-medium rounded-lg hover:bg-red-100 transition">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-slate-400">No users yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection