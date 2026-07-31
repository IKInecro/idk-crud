<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @fonts
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: 'Instrument Sans', sans-serif; background: #0a1628; color: #fff; min-height: 100vh; display: flex; flex-direction: column; position: relative; overflow-x: hidden; }
            .page-wrap { position: relative; flex: 1; display: flex; flex-direction: column; }
            .bg-overlay { position: absolute; inset: 0; pointer-events: none; background: url("{{ asset('images/mncu right logo background.png') }}") no-repeat right center / contain; }
            header { padding: 1.5rem 2rem; display: flex; justify-content: flex-end; position: relative; z-index: 1; }
            .hero { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 2rem; position: relative; z-index: 1; }
            .logo { width: 280px; height: auto; margin-bottom: 2rem; }
            h1 { font-size: 2.5rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem; }
            p { color: #94a3b8; font-size: 1.1rem; margin-bottom: 2rem; }
            .btn-group { display: flex; gap: 1rem; }
            .btn { padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem; text-decoration: none; transition: all .2s; }
            .btn-primary { background: #2563eb; color: #fff; }
            .btn-primary:hover { background: #1d4ed8; }
            .btn-outline { border: 1px solid #334155; color: #cbd5e1; }
            .btn-outline:hover { background: #1e293b; }
            footer { text-align: center; padding: 1.5rem; color: #475569; font-size: 0.8rem; position: relative; z-index: 1; }
        </style>
    </head>
    <body>
        <div class="page-wrap">
            <div class="bg-overlay"></div>
            <header>
                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <div class="hero">
                <img src="{{ asset('images/logo.png') }}" alt="MNC University" class="logo">
                <h1>moga gak error :V</h1>
                <div class="btn-group">
                    <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-outline">Daftar</a>
                </div>
            </div>

            <footer>&copy; {{ date('Y') }} MNC University. All rights reserved.</footer>
        </div>
    </body>
</html>
