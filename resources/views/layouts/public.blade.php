<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'InterKlinik') · InterKlinik</title>
        <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-ink-900 bg-white antialiased">
        <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[70] focus:px-3 focus:py-2 focus:rounded-lg focus:bg-white focus:text-ink-900 focus:ring-2 focus:ring-ocean-500">
            Skip to content
        </a>

        <header class="border-b border-line bg-white">
            <div class="max-w-4xl mx-auto h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-ocean-500">
                    <img src="{{ asset('logo.png') }}" alt="" class="w-7 h-7">
                    <span class="text-sm font-medium text-ink-900">InterKlinik</span>
                </a>
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-ink-600 hover:text-ink-900">Log in</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main id="main" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @yield('content')
        </main>

        <footer class="border-t border-line bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <x-legal-links />
            </div>
        </footer>

        <x-cookie-notice />
    </body>
</html>
