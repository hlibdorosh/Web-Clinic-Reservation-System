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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0"
             style="background: linear-gradient(160deg, #f0fdff 0%, #ccf7fe 40%, #e8fbff 70%, #f0fdff 100%);">

            <!-- Decorative blobs -->
            <div class="fixed inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
                <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full opacity-30"
                     style="background: radial-gradient(circle, #4dd9f5 0%, transparent 70%);"></div>
                <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full opacity-20"
                     style="background: radial-gradient(circle, #0582a3 0%, transparent 70%);"></div>
            </div>

            <div class="relative z-10 flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" alt="InterKlinik" class="w-16 h-16">
                <div>
                    <h1 class="text-2xl font-bold text-ocean-600">InterKlinik</h1>
                    <p class="text-xs text-ocean-500">Medical Clinic</p>
                </div>
            </div>

            <div class="relative z-10 w-full sm:max-w-md mt-6 px-6 py-8 bg-white/80 backdrop-blur-md
                        overflow-hidden sm:rounded-2xl border border-ocean-100"
                 style="box-shadow: 0 8px 40px -4px rgba(5,130,163,0.20), 0 2px 12px -2px rgba(5,130,163,0.12);">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
