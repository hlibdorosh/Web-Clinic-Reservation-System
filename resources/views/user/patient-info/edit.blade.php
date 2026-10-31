<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Patient Information') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-5 sm:p-6">
                <div class="max-w-2xl">
                    @include('user.patient-info.partials.update-patient-info-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

