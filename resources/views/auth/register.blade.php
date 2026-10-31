<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Consents: none pre-checked -->
        <fieldset class="mt-6 space-y-3">
            <legend class="sr-only">{{ __('Required confirmations') }}</legend>

            <div class="flex items-start gap-3">
                <input id="terms" name="terms" type="checkbox" value="1" required
                       @checked(old('terms'))
                       class="mt-0.5 h-4 w-4 rounded border-line-strong text-ocean-700 focus:ring-ocean-500">
                <label for="terms" class="text-sm text-ink-600 leading-5">
                    I have read and accept the <a href="{{ route('legal.terms') }}" target="_blank" rel="noopener" class="text-ocean-700 underline hover:no-underline">Terms of service</a>.
                </label>
            </div>
            <x-input-error :messages="$errors->get('terms')" class="mt-1" />

            <div class="flex items-start gap-3">
                <input id="privacy" name="privacy" type="checkbox" value="1" required
                       @checked(old('privacy'))
                       class="mt-0.5 h-4 w-4 rounded border-line-strong text-ocean-700 focus:ring-ocean-500">
                <label for="privacy" class="text-sm text-ink-600 leading-5">
                    I have read the <a href="{{ route('legal.privacy') }}" target="_blank" rel="noopener" class="text-ocean-700 underline hover:no-underline">Privacy policy</a> and agree to my data being processed to run my account and reservations.
                </label>
            </div>
            <x-input-error :messages="$errors->get('privacy')" class="mt-1" />

            <div class="flex items-start gap-3">
                <input id="age_confirmation" name="age_confirmation" type="checkbox" value="1" required
                       @checked(old('age_confirmation'))
                       class="mt-0.5 h-4 w-4 rounded border-line-strong text-ocean-700 focus:ring-ocean-500">
                <label for="age_confirmation" class="text-sm text-ink-600 leading-5">
                    I am 16 or older, or a parent or guardian creating this account on behalf of a minor.
                </label>
            </div>
            <x-input-error :messages="$errors->get('age_confirmation')" class="mt-1" />
        </fieldset>

        <div class="flex items-center justify-end mt-6">
            <a class="text-sm text-ocean-700 hover:underline rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-ocean-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
