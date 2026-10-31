<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            <p class="text-sm text-ink-600">Welcome, {{ Auth::user()->name }}</p>
            <x-notifications-panel :notifications="$notifications" />
        </div>
    </div>
</x-app-layout>
