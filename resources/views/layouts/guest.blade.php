<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>InterKlinik</title>
        <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-ink-900 antialiased">
        <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[70] focus:px-3 focus:py-2 focus:rounded-lg focus:bg-white focus:text-ink-900 focus:ring-2 focus:ring-ocean-500">
            Skip to content
        </a>
        <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 pt-10 pb-12 sm:pt-0">

            <div class="flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" alt="InterKlinik" class="w-10 h-10">
                <div>
                    <h1 class="text-lg font-medium text-ink-900 leading-tight">InterKlinik</h1>
                    <p class="text-xs text-ink-500">Medical clinic</p>
                </div>
            </div>

            <main id="main" class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white border border-line rounded-xl
                        shadow-[0_1px_2px_rgba(17,24,39,0.04)]">
                {{ $slot }}
            </main>

            <div class="mt-6 max-w-md w-full px-2">
                <x-legal-links />
            </div>
        </div>

        <x-cookie-notice />
    </body>
</html>
