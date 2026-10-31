<x-app-layout>
    <x-slot name="header">
        <h2>
            Visit information - {{ $reservation->patient->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-6 max-w-3xl">
                {{-- Reservation Details --}}
                <div class="mb-8 pb-6 border-b border-line">
                    <h3 class="text-lg font-medium text-ink-900 mb-4">Appointment details</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-ink-500">Patient name</p>
                            <p class="mt-1 text-sm text-ink-900">{{ $reservation->patient->name }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-ink-500">Patient email</p>
                            <p class="mt-1 text-sm text-ink-900">{{ $reservation->patient->email }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-ink-500">Service</p>
                            <p class="mt-1 text-sm text-ink-900">{{ $reservation->service?->name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-ink-500">Visit date</p>
                            <p class="mt-1 text-sm text-ink-900 tabular-nums">{{ $reservation->term->date }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-ink-500">Visit time</p>
                            <p class="mt-1 text-sm text-ink-900 tabular-nums">{{ $reservation->term->start_time }} - {{ $reservation->term->end_time }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-ink-500">Status</p>
                            <p class="mt-1 inline-flex items-center gap-2 text-sm text-ink-900">
                                <span class="w-1.5 h-1.5 rounded-full {{ $reservation->state === 'pending' ? 'bg-amber-600' : ($reservation->state === 'confirmed' ? 'bg-emerald-600' : ($reservation->state === 'cancelled' ? 'bg-red-600' : 'bg-ink-400')) }}"></span>
                                {{ ucfirst($reservation->state) }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Visit Info Display --}}
                <div>
                    <h3 class="text-lg font-medium text-ink-900 mb-4">
                        {{ isset($isReadOnly) && $isReadOnly ? 'Doctor\'s conclusion' : 'Visit notes' }}
                    </h3>

                    @if(isset($isReadOnly) && $isReadOnly)
                        {{-- Read-only view for patients --}}
                        <div class="mb-6 p-4 bg-ink-50 rounded-lg border border-line min-h-40">
                            @if($reservation->info)
                                <p class="text-sm text-ink-900 whitespace-pre-line">{{ $reservation->info }}</p>
                            @else
                                <p class="text-sm text-ink-500">Doctor has not yet written any conclusions about your visit.</p>
                            @endif
                        </div>
                    @else
                        {{-- Edit form for doctors --}}
                        <form method="POST" action="{{ route('doctor.reservations.updateInfo', $reservation) }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label for="info" class="block text-sm font-medium text-ink-900 mb-2">
                                    Doctor's conclusions and notes
                                </label>
                                <textarea
                                    id="info"
                                    name="info"
                                    rows="8"
                                    class="input h-auto w-full py-2"
                                    placeholder="Write your observations, diagnoses, recommendations, and any other important information about the patient's visit..."
                                >{{ old('info', $reservation->info) }}</textarea>
                                <p class="text-xs text-ink-500 mt-2">Maximum 5000 characters</p>
                                <x-input-error class="mt-2" :messages="$errors->get('info')" />
                            </div>

                            <div class="flex gap-3">
                                <button type="submit" class="btn">
                                    Save visit info
                                </button>
                                <a href="{{ route('doctor.terms.index') }}" class="btn-outline">
                                    Back to terms
                                </a>
                            </div>

                            @if (session('status') === 'visit-info-updated')
                                <p class="mt-4 text-sm text-ink-600">
                                    Visit information saved successfully.
                                </p>
                            @endif
                        </form>
                    @endif

                    {{-- Back button for patients --}}
                    @if(isset($isReadOnly) && $isReadOnly)
                        <div class="mt-6">
                            <a href="{{ route('user.reservations.index') }}" class="btn-outline">
                                Back to my reservations
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
