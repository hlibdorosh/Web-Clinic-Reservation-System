<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="card p-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            @if(auth()->user()->role === 'patient')
                <div class="card p-6">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-ink-900">
                                {{ __('Patient information') }}
                            </h2>
                            <p class="mt-1 text-sm text-ink-600">
                                {{ __('Update your personal health information.') }}
                            </p>
                        </header>
                        <div class="mt-6">
                            <a href="{{ route('user.patient-info.edit') }}" class="btn">
                                {{ __('Edit patient information') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card p-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card p-6">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <!-- Google Calendar integration Section -->
            <div class="card p-6">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-ink-900">
                            {{ __('Google Calendar integration') }}
                        </h2>
                        <p class="mt-1 text-sm text-ink-600">
                            {{ __('Connect your Google Calendar to automatically receive appointment reminders.') }}
                        </p>
                    </header>

                    <div class="mt-6">
                        @if(auth()->user()->google_calendar_token)
                            <div class="p-4 bg-ink-50 border border-line rounded-lg mb-4 flex justify-between items-center">
                                <span class="inline-flex items-center gap-2 text-sm font-medium text-ink-900">
                                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                    {{ __('Google Calendar connected') }}
                                </span>
                                <form method="POST" action="{{ route('google.calendar.disconnect') }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="text-sm font-medium text-ocean-700 hover:underline">
                                        {{ __('Disconnect') }}
                                    </button>
                                </form>
                            </div>
                            <p class="text-sm text-ink-600">
                                {{ __('Appointments will be automatically added to your Google Calendar when confirmed.') }}
                            </p>
                        @else
                            <div class="p-4 bg-ink-50 border border-line rounded-lg">
                                <p class="mb-2">
                                    <a href="{{ route('google.calendar.redirect') }}"
                                       class="btn-outline">
                                        {{ __('Connect Google Calendar') }}
                                    </a>
                                </p>
                                <p class="text-sm text-ink-600">
                                    {{ __('Automatically receive appointment confirmations and reminders in your Google Calendar.') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
