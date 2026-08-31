<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trackify')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col">

    <div class="flex flex-1">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0">
            <div class="h-16 flex items-center gap-2 px-6 border-b border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center text-white font-bold">T</div>
                <span class="text-white font-semibold text-lg">Trackify</span>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-6 overflow-y-auto">

                @if (auth()->check() && auth()->user()->role === 'admin')
                    <div>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                                {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Admin Dashboard
                        </a>
                    </div>
                @endif
                <div>
                    <a href="{{ route('user.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                            {{ request()->routeIs('user.dashboard') ? 'bg-brand-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                    </a>
                </div>

                <div>
                    <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Account</p>
                    <a href="{{ route('user.profile.edit') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                            {{ request()->routeIs('user.profile.*') ? 'bg-brand-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="user-cog" class="w-4 h-4"></i> Edit Profile
                    </a>
                </div>

                <div>
                    <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Student</p>
                    <a href="{{ route('user.attendance.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                            {{ request()->routeIs('user.attendance.*') ? 'bg-brand-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="calendar-check" class="w-4 h-4"></i> Attendance
                    </a>
                    <a href="{{ route('user.modules.create') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                            {{ request()->routeIs('user.modules.*') ? 'bg-brand-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="book-open" class="w-4 h-4"></i> Add Module
                    </a>
                </div>

                <div>
                    <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Subscriptions</p>
                    <a href="{{ route('user.subscriptions.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                            {{ request()->routeIs('user.subscriptions.index') ? 'bg-brand-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="credit-card" class="w-4 h-4"></i> My Subscriptions
                    </a>
                    <a href="{{ route('user.subscriptions.create') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                            {{ request()->routeIs('user.subscriptions.create') ? 'bg-brand-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i> Add Subscription
                    </a>
                </div>

            </nav>
        </aside>

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- TOPBAR --}}
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 shrink-0">
                <h1 class="text-slate-800 font-semibold">@yield('title', 'Dashboard')</h1>

                <div class="flex items-center gap-4">
                    <button class="relative text-slate-500 hover:text-slate-800 transition">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                    </button>

                    <div class="w-px h-6 bg-slate-200"></div>

                    <a href="{{ route('user.profile.edit') }}" class="flex items-center gap-2 group">
                        @if (auth()->user()->profile_image)
                            <img src="{{ asset('storage/'.auth()->user()->profile_image) }}"
                                class="w-9 h-9 rounded-full object-cover ring-2 ring-transparent group-hover:ring-brand-500 transition">
                        @else
                            <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-semibold text-sm ring-2 ring-transparent group-hover:ring-brand-500 transition">
                                {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-sm font-medium text-slate-700 hidden sm:block">{{ auth()->user()->username }}</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-500 transition" title="Logout">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </header>

            {{-- CONTENT --}}
            <main class="flex-1 p-6 space-y-6 @yield('bg', 'bg-slate-50')">
                @if (session('success'))
                    <div class="bg-brand-50 text-brand-800 border border-brand-200 rounded-xl px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 text-red-700 border border-red-200 rounded-xl px-4 py-3 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>