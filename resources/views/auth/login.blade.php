@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="container">

    <div class="form-container">
        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <h2>Login</h2>

            @error('identifier')
                <div class="alert error">{{ $message }}</div>
            @enderror

            <input type="text" name="identifier" placeholder="Username or Email"
                   value="{{ old('identifier') }}" required autofocus>
            <input type="password" name="password" placeholder="Password" required>

            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>

            <button type="submit" class="btn-primary">Login</button>
        </form>
    </div>

    <div class="overlay-panel">
        <h1>Hello, Friend! 👋</h1>
        <p>Register to start using Trackify</p>
        <a href="{{ route('register') }}" class="ghost">Register</a>
    </div>

</div>
@endsection