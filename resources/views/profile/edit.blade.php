<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            @if(auth()->user()->role === 'patient')
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Patient Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Update your personal health information.') }}
                            </p>
                        </header>
                        <div class="mt-6">
                            <a href="{{ route('user.patient-info.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                {{ __('Edit Patient Information') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <!-- Google Calendar Integration Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Google Calendar Integration') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Connect your Google Calendar to automatically receive appointment reminders.') }}
                        </p>
                    </header>

                    <div class="mt-6">
                        @if(auth()->user()->google_calendar_token)
                            <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-md mb-4 flex justify-between items-center">
                                <span class="font-medium">✓ {{ __('Google Calendar Connected') }}</span>
                                <form method="POST" action="{{ route('google.calendar.disconnect') }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="text-sm font-medium underline hover:no-underline text-green-700">
                                        {{ __('Disconnect') }}
                                    </button>
                                </form>
                            </div>
                            <p class="text-sm text-gray-600">
                                {{ __('Appointments will be automatically added to your Google Calendar when confirmed.') }}
                            </p>
                        @else
                            <div class="p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-md">
                                <p class="mb-3">
                                    <a href="{{ route('google.calendar.redirect') }}"
                                       class="font-medium hover:underline inline-flex items-center">
                                        🔗 {{ __('Connect Google Calendar') }}
                                    </a>
                                </p>
                                <p class="text-sm">
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
