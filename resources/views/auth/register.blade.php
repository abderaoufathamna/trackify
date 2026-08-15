@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="container">

    <div class="overlay-panel">
        <h1>Welcome Back 👋</h1>
        <p>Login to continue using Trackify</p>
        <a href="{{ route('login') }}" class="ghost">Login</a>
    </div>

    <div class="form-container">
        <form method="POST" action="{{ route('register.store') }}">
            @csrf
            <h2>Create Account</h2>

            <input type="text" name="full_name" placeholder="Full Name" value="{{ old('full_name') }}" required>
            @error('full_name') <div class="alert error">{{ $message }}</div> @enderror

            <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
            @error('username') <div class="alert error">{{ $message }}</div> @enderror

            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            @error('email') <div class="alert error">{{ $message }}</div> @enderror

            <input type="password" name="password" placeholder="Password" required>
            @error('password') <div class="alert error">{{ $message }}</div> @enderror

            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

            <button type="submit" class="btn-primary">Register</button>
        </form>
    </div>

</div>
@endsection