<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700|work-sans:300,400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Work Sans', sans-serif;
            }
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Outfit', sans-serif;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden"
             style="background: linear-gradient(135deg, #0a1628 0%, #1a2a5c 50%, #1e1b4b 100%);">

            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
                <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-indigo-500/5 rounded-full blur-3xl"></div>
            </div>

            <div class="absolute inset-0 pointer-events-none" style="background: url('{{ asset('images/mncu right logo background.png') }}') no-repeat right center / contain;"></div>

            <div class="relative z-10 w-full sm:max-w-md px-4">

                <div class="text-center mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="MNC University" class="mx-auto" style="width: 156px; height: auto;">
                </div>

                <div class="bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl shadow-black/20 ring-1 ring-white/20 p-8">
                    {{ $slot }}
                </div>

                <p class="text-center mt-6 text-blue-200/30 text-xs">&copy; {{ date('Y') }} MNC University. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
