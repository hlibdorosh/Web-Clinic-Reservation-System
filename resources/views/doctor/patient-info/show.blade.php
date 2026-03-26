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

            {{-- Patient Reservations History --}}
            <div class="mt-6 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Visit History') }}</h3>

                    @if($reservations->isEmpty())
                        <p class="text-sm text-gray-500">{{ __('No reservations found for this patient.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="text-left border-b">
                                        <th class="py-2 px-2">{{ __('Date') }}</th>
                                        <th class="py-2 px-2">{{ __('Time') }}</th>
                                        <th class="py-2 px-2">{{ __('Service') }}</th>
                                        <th class="py-2 px-2">{{ __('Department') }}</th>
                                        <th class="py-2 px-2">{{ __('Cabinet') }}</th>
                                        <th class="py-2 px-2">{{ __('Status') }}</th>
                                        <th class="py-2 px-2">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                        <tr class="border-b">
                                            <td class="py-2 px-2">
                                                {{ optional($reservation->term->date)->format('Y-m-d') ?? $reservation->term->date }}
                                            </td>
                                            <td class="py-2 px-2">
                                                {{ $reservation->term->start_time }} - {{ $reservation->term->end_time }}
                                            </td>
                                            <td class="py-2 px-2">
                                                {{ $reservation->service?->name ?? '-' }}
                                            </td>
                                            <td class="py-2 px-2">
                                                {{ $reservation->term->department?->name ?? '-' }}
                                            </td>
                                            <td class="py-2 px-2">
                                                {{ $reservation->term->cabinet?->number ?? $reservation->term->cab_id }}
                                            </td>
                                            <td class="py-2 px-2">
                                                <span class="px-2 py-1 rounded text-xs font-medium
                                                    {{ $reservation->state === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $reservation->state === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $reservation->state === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                ">
                                                    {{ ucfirst($reservation->state) }}
                                                </span>
                                            </td>
                                            <td class="py-2 px-2">
                                                <a href="{{ route('doctor.reservations.showInfo', $reservation) }}" class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700 font-medium">
                                                    Conclusion
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

