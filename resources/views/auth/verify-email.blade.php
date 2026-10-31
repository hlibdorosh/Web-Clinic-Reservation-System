<x-guest-layout>
    <div class="mb-4 text-sm text-ink-600">
        {{ __('Thanks for signing up. Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm text-ink-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend verification email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-sm text-ocean-700 hover:underline rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-ocean-500">
                {{ __('Log out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
