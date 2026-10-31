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
    <body class="font-sans antialiased">
        <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[70] focus:px-3 focus:py-2 focus:rounded-lg focus:bg-white focus:text-ink-900 focus:ring-2 focus:ring-ocean-500">
            Skip to content
        </a>
        <div class="min-h-screen bg-transparent flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-b border-line">
                    <div class="max-w-7xl mx-auto h-14 px-4 sm:px-6 lg:px-8 flex items-center page-header-bar">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main id="main" class="flex-grow">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <x-footer />
        </div>

        <x-cookie-notice />
    </body>
</html>
