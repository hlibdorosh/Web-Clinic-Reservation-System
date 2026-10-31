<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Patient Information - ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="card p-6">
                <h3 class="text-lg font-medium text-ink-900 mb-4">{{ __('Personal Information') }}</h3>

                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl">
                    <div>
                        <dt class="text-xs text-ink-500">{{ __('Name') }}</dt>
                        <dd class="mt-1 text-sm text-ink-900">{{ $user->name }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs text-ink-500">{{ __('Email') }}</dt>
                        <dd class="mt-1 text-sm text-ink-900">{{ $user->email }}</dd>
                    </div>

                    @if ($patientInfo)
                        <div>
                            <dt class="text-xs text-ink-500">{{ __('Birth Date') }}</dt>
                            <dd class="mt-1 text-sm text-ink-900 tabular-nums">
                                @if ($patientInfo->birth_date)
                                    {{ $patientInfo->birth_date->format('d.m.Y') }}
                                @else
                                    <span class="text-ink-500">{{ __('Not provided') }}</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-ink-500">{{ __('Age') }}</dt>
                            <dd class="mt-1 text-sm text-ink-900 tabular-nums">
                                @if ($patientInfo->birth_date)
                                    {{ \Carbon\Carbon::parse($patientInfo->birth_date)->age }} {{ __('years') }}
                                @else
                                    <span class="text-ink-500">{{ __('Not provided') }}</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-ink-500">{{ __('Sex') }}</dt>
                            <dd class="mt-1 text-sm text-ink-900">
                                @if ($patientInfo->sex)
                                    {{ $patientInfo->sex === 'М' ? __('Male') : __('Female') }}
                                @else
                                    <span class="text-ink-500">{{ __('Not provided') }}</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-ink-500">{{ __('Height') }}</dt>
                            <dd class="mt-1 text-sm text-ink-900 tabular-nums">
                                @if ($patientInfo->height)
                                    {{ $patientInfo->height }} {{ __('cm') }}
                                @else
                                    <span class="text-ink-500">{{ __('Not provided') }}</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-ink-500">{{ __('Weight') }}</dt>
                            <dd class="mt-1 text-sm text-ink-900 tabular-nums">
                                @if ($patientInfo->weight)
                                    {{ $patientInfo->weight }} {{ __('kg') }}
                                @else
                                    <span class="text-ink-500">{{ __('Not provided') }}</span>
                                @endif
                            </dd>
                        </div>
                    @else
                        <div class="md:col-span-2">
                            <p class="text-sm text-ink-500">{{ __('Patient has not provided personal health information yet.') }}</p>
                        </div>
                    @endif
                </dl>

                <div class="mt-6">
                    <a href="javascript:history.back()" class="btn-outline">
                        {{ __('Back') }}
                    </a>
                </div>
            </div>

            {{-- Patient Reservations History --}}
            <div class="card p-6">
                <h3 class="text-lg font-medium text-ink-900 mb-4">{{ __('Visit History') }}</h3>

                @if($reservations->isEmpty())
                    <p class="text-sm text-ink-500">{{ __('No reservations found for this patient.') }}</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr class="text-left">
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Time') }}</th>
                                    <th>{{ __('Service') }}</th>
                                    <th>{{ __('Department') }}</th>
                                    <th>{{ __('Cabinet') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservations as $reservation)
                                    <tr>
                                        <td class="tabular-nums">
                                            {{ optional($reservation->term->date)->format('Y-m-d') ?? $reservation->term->date }}
                                        </td>
                                        <td class="tabular-nums whitespace-nowrap">
                                            {{ $reservation->term->start_time }} - {{ $reservation->term->end_time }}
                                        </td>
                                        <td>
                                            {{ $reservation->service?->name ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $reservation->term->department?->name ?? '-' }}
                                        </td>
                                        <td class="tabular-nums">
                                            {{ $reservation->term->cabinet?->number ?? $reservation->term->cab_id }}
                                        </td>
                                        <td>
                                            <span class="inline-flex items-center gap-2 text-sm text-ink-600">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $reservation->state === 'pending' ? 'bg-amber-600' : ($reservation->state === 'confirmed' ? 'bg-emerald-600' : ($reservation->state === 'cancelled' ? 'bg-red-600' : 'bg-ink-400')) }}"></span>
                                                {{ ucfirst($reservation->state) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('doctor.reservations.showInfo', $reservation) }}" class="btn-outline btn-sm">
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
</x-app-layout>
