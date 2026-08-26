@extends('layouts.user')

@section('title', 'Edit Profile')

@section('content')

    <div class="max-w-lg bg-white rounded-2xl border border-slate-200 p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-5">Edit Profile</h2>

        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="flex items-center gap-4">
                @if ($user->profile_image)
                    <img src="{{ asset('storage/'.$user->profile_image) }}"
                        class="w-16 h-16 rounded-full object-cover">
                @else
                    <div class="w-16 h-16 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-semibold text-xl">
                        {{ strtoupper(substr($user->username, 0, 1)) }}
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Profile Picture</label>
                    <input type="file" name="profile_image" accept="image/*"
                        class="text-sm text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-brand-50 file:text-brand-700 file:text-sm file:font-medium hover:file:bg-brand-100">
                    @error('profile_image')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
                <input type="password" name="password" placeholder="Leave empty if no change"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
            </div>

            <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-brand-600 text-white text-sm font-medium rounded-lg hover:bg-brand-700 transition">
                <i data-lucide="save" class="w-4 h-4"></i> Update
            </button>
        </form>
    </div>

@endsection