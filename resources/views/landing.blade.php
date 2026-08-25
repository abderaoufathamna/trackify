<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trackify | Smart Management</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:'#f0fdf4', 100:'#dcfce7', 400:'#4ade80',
                            500:'#22c55e', 600:'#16a34a', 700:'#15803d',
                            800:'#14532d', 900:'#0f3d22',
                        }
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <nav class="navbar" id="navbar">
        <div class="logo">Trackify<span class="dot">.</span></div>
        <ul class="nav-links">
            <li><a href="#home" class="active">Home</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#cta">Get Started</a></li>
        </ul>
        <a href="{{ route('login') }}" class="btn btn-nav">Log In</a>
    </nav>

    <section id="home" class="hero">
        <div class="hero-text reveal">
            <span class="badge">✨ Smart Management System</span>
            <h1 id="txt-animate"></h1>
            <p>A modern, high-performance solution to manage students, subscriptions, and attendance efficiently.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn-primary">Start for Free</a>
                <a href="#features" class="btn-secondary">Explore Features</a>
            </div>
        </div>
        <div class="hero-image reveal">
            <div class="dashboard-placeholder floating">
                <img src="{{ asset('assets/img/landing/image.png') }}" alt="Dashboard Preview">
            </div>
        </div>
    </section>

    <section class="about">
        <div class="about-content reveal">
            <h2>Powering the next generation of management</h2>
            <div class="stats-grid">
                <div class="stat-item"><h3>3K+</h3><p>Shipments</p></div>
                <div class="stat-item"><h3>50+</h3><p>Clients</p></div>
                <div class="stat-item"><h3>12+</h3><p>Countries</p></div>
                <div class="stat-item"><h3>99.9%</h3><p>Uptime</p></div>
            </div>
        </div>
    </section>

    <section id="features" class="features">
        <div class="section-header reveal">
            <h2>Powerful Features</h2>
            <p>Everything you need to maintain full control.</p>
        </div>

        <div class="cards">
            <div class="card reveal" style="transition-delay: 100ms;">
                <div class="card-icon">🔄</div>
                <h3>Subscriptions</h3>
                <p>Track recurring memberships and services automatically.</p>
            </div>
            <div class="card reveal" style="transition-delay: 200ms;">
                <div class="card-icon">👥</div>
                <h3>Students</h3>
                <p>Organize and manage student data with precision.</p>
            </div>
            <div class="card reveal" style="transition-delay: 300ms;">
                <div class="card-icon">📅</div>
                <h3>Attendance</h3>
                <p>Monitor real-time attendance tracking and reports.</p>
            </div>
            <div class="card reveal" style="transition-delay: 400ms;">
                <div class="card-icon">📊</div>
                <h3>Dashboard</h3>
                <p>Gain actionable insights with rich analytics.</p>
            </div>
        </div>
    </section>

    <section id="cta" class="cta">
        <div class="cta-content reveal">
            <h2>Ready to streamline your workflow?</h2>
            <p style="color: #d1cb8a">Join Trackify today and experience seamless management.</p>
            <div class="cta-btn-group">
                <a href="{{ route('register') }}" class="btn-primary">Create Account</a>
            </div>
        </div>
    </section>

    @include('layouts.partials.footer')

    <a href="#" class="back-to-top" id="backToTop">↑</a>

    <script src="{{ asset('assets/js/landing.js') }}"></script>
</body>
</html>