<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth') - Trackify</title>
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
</head>
<body>

    <video autoplay muted loop id="bg-video">
        <source src="{{ asset('assets/video/intro.mp4') }}" type="video/mp4">
    </video>

    <div class="auth-container">
        @yield('content')
    </div>

    <script src="{{ asset('assets/js/auth.js') }}"></script>
</body>
</html>