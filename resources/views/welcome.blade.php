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
    <body class="font-sans text-ink-900 bg-white antialiased">
        <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[70] focus:px-3 focus:py-2 focus:rounded-lg focus:bg-white focus:text-ink-900 focus:ring-2 focus:ring-ocean-500">
            Skip to content
        </a>

        <!-- Header -->
        <header class="border-b border-line bg-white">
            <div class="max-w-6xl mx-auto h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('logo.png') }}" alt="" class="w-7 h-7">
                    <span class="text-sm font-medium text-ink-900">InterKlinik</span>
                </a>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-sm">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-ink-600 hover:text-ink-900 transition-colors duration-150">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-sm">Create account</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <main id="main">
            <!-- Hero: text on one side, the product preview on the other -->
            <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20 lg:pt-24 lg:pb-28 grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <p class="text-sm font-medium text-ocean-700">Medical clinic, Bratislava</p>
                    <h1 class="mt-4 text-4xl sm:text-5xl font-medium leading-[1.08] tracking-[-0.02em] text-ink-900">
                        Book your next visit online
                    </h1>
                    <p class="mt-5 text-lg leading-7 text-ink-600 max-w-xl">
                        Choose a department and a doctor, pick a free time, and keep every reservation in one place.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn h-11 px-5">Go to your dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="btn h-11 px-5">Create account</a>
                            <a href="{{ route('login') }}" class="btn-outline h-11 px-5">Log in</a>
                        @endauth
                    </div>

                    <p class="mt-8 text-sm text-ink-500">
                        Emergency care is available 24/7. Opening hours Monday to Friday 08:00 to 18:00.
                    </p>
                </div>

                <!-- Product preview: a doctor's free times for one day -->
                <div class="relative">
                    <div class="card p-5 sm:p-6">
                        <p class="mb-3 text-xs text-ink-500">Example of the booking screen</p>
                        <div class="flex items-start justify-between gap-4 pb-4 border-b border-line">
                            <div>
                                <p class="text-sm font-medium text-ink-900">Example doctor</p>
                                <p class="text-xs text-ink-500">General practice, Cabinet 3</p>
                            </div>
                            <p class="text-sm text-ink-600 tabular-nums">Tue 10 Nov</p>
                        </div>

                        <p class="mt-5 mb-3 text-xs font-medium text-ink-500">Free times</p>
                        <div class="grid grid-cols-3 gap-2 tabular-nums">
                            <div class="h-10 rounded-lg border border-line-strong bg-white flex items-center justify-center gap-2 text-sm text-ink-900">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600" aria-hidden="true"></span>08:00
                            </div>
                            <div class="h-10 rounded-lg border border-line-strong bg-white flex items-center justify-center gap-2 text-sm text-ink-900">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600" aria-hidden="true"></span>08:30
                            </div>
                            <div class="h-10 rounded-lg border border-line bg-ink-50 flex items-center justify-center gap-2 text-sm text-ink-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-ink-400" aria-hidden="true"></span>09:00
                            </div>
                            <div class="h-10 rounded-lg border border-line bg-ink-50 flex items-center justify-center gap-2 text-sm text-ink-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-ink-400" aria-hidden="true"></span>09:30
                            </div>
                            <div class="h-10 rounded-lg bg-ocean-700 text-white flex items-center justify-center text-sm font-medium">
                                10:00
                            </div>
                            <div class="h-10 rounded-lg border border-line-strong bg-white flex items-center justify-center gap-2 text-sm text-ink-900">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600" aria-hidden="true"></span>10:30
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-t border-line flex items-center justify-between gap-4">
                            <p class="text-sm text-ink-600">Selected: <span class="text-ink-900 font-medium tabular-nums">10:00</span></p>
                            <span class="btn btn-sm pointer-events-none">Reserve</span>
                        </div>
                    </div>

                    <p class="mt-3 flex items-center gap-4 text-xs text-ink-500">
                        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-600" aria-hidden="true"></span>Free</span>
                        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-ink-400" aria-hidden="true"></span>Reserved</span>
                    </p>
                </div>
            </section>

            <!-- Clinic facts -->
            <section class="border-t border-line bg-ink-50">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h2 class="text-sm font-medium text-ink-900">Departments</h2>
                        <p class="mt-2 text-sm text-ink-600 leading-6">See the departments, the doctors in each one and the services they offer.</p>
                    </div>
                    <div>
                        <h2 class="text-sm font-medium text-ink-900">Your reservations</h2>
                        <p class="mt-2 text-sm text-ink-600 leading-6">Follow every upcoming visit, cancel one when your plans change and keep your health information up to date.</p>
                    </div>
                    <div>
                        <h2 class="text-sm font-medium text-ink-900">Doctors and staff</h2>
                        <p class="mt-2 text-sm text-ink-600 leading-6">Doctors publish their free times and confirm reservations from the same calendar.</p>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-line bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-xs text-ink-500">
                <div>
                    <p>&copy; 2026 InterKlinik. All rights reserved.</p>
                    <p class="mt-1">Bratislava, Slovakia · +421 2 123 456 789 · info@interklinik.sk</p>
                </div>
                <x-legal-links />
            </div>
        </footer>

        <x-cookie-notice />
    </body>
</html>
