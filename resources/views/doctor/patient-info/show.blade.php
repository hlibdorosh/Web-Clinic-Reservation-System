<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient Information - ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-2xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Personal Information') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Name') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Email') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                        </div>

                        @if ($patientInfo)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('Birth Date') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if ($patientInfo->birth_date)
                                        {{ $patientInfo->birth_date->format('d.m.Y') }}
                                    @else
                                        <span class="text-gray-400">{{ __('Not provided') }}</span>
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('Age') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if ($patientInfo->birth_date)
                                        {{ \Carbon\Carbon::parse($patientInfo->birth_date)->age }} {{ __('years') }}
                                    @else
                                        <span class="text-gray-400">{{ __('Not provided') }}</span>
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('Sex') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if ($patientInfo->sex)
                                        {{ $patientInfo->sex === 'М' ? __('Male') : __('Female') }}
                                    @else
                                        <span class="text-gray-400">{{ __('Not provided') }}</span>
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('Height') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if ($patientInfo->height)
                                        {{ $patientInfo->height }} {{ __('cm') }}
                                    @else
                                        <span class="text-gray-400">{{ __('Not provided') }}</span>
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('Weight') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if ($patientInfo->weight)
                                        {{ $patientInfo->weight }} {{ __('kg') }}
                                    @else
                                        <span class="text-gray-400">{{ __('Not provided') }}</span>
                                    @endif
                                </dd>
                            </div>
                        @else
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">{{ __('Patient has not provided personal health information yet.') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <a href="javascript:history.back()" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

