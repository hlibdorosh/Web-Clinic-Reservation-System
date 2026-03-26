<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Visit Information - {{ $reservation->patient->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                {{-- Reservation Details --}}
                <div class="mb-8 pb-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Appointment Details</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Patient Name</p>
                            <p class="text-lg font-medium text-gray-900">{{ $reservation->patient->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Patient Email</p>
                            <p class="text-lg font-medium text-gray-900">{{ $reservation->patient->email }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Service</p>
                            <p class="text-lg font-medium text-gray-900">{{ $reservation->service?->name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Visit Date</p>
                            <p class="text-lg font-medium text-gray-900">{{ $reservation->term->date }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Visit Time</p>
                            <p class="text-lg font-medium text-gray-900">{{ $reservation->term->start_time }} - {{ $reservation->term->end_time }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="text-lg font-medium">
                                <span class="px-3 py-1 rounded text-xs font-medium
                                    {{ $reservation->state === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $reservation->state === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $reservation->state === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ ucfirst($reservation->state) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Visit Info Display --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        {{ isset($isReadOnly) && $isReadOnly ? 'Doctor\'s Conclusion' : 'Visit Notes' }}
                    </h3>

                    @if(isset($isReadOnly) && $isReadOnly)
                        {{-- Read-only view for patients --}}
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200 min-h-40">
                            @if($reservation->info)
                                <p class="text-gray-700 whitespace-pre-line">{{ $reservation->info }}</p>
                            @else
                                <p class="text-gray-500 italic">Doctor has not yet written any conclusions about your visit.</p>
                            @endif
                        </div>
                    @else
                        {{-- Edit form for doctors --}}
                        <form method="POST" action="{{ route('doctor.reservations.updateInfo', $reservation) }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label for="info" class="block text-sm font-medium text-gray-700 mb-2">
                                    Doctor's Conclusions and Notes
                                </label>
                                <textarea
                                    id="info"
                                    name="info"
                                    rows="8"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Write your observations, diagnoses, recommendations, and any other important information about the patient's visit..."
                                >{{ old('info', $reservation->info) }}</textarea>
                                <p class="text-xs text-gray-500 mt-2">Maximum 5000 characters</p>
                                <x-input-error class="mt-2" :messages="$errors->get('info')" />
                            </div>

                            <div class="flex gap-4">
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                    Save Visit Info
                                </button>
                                <a href="{{ route('doctor.terms.index') }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 font-medium">
                                    Back to Terms
                                </a>
                            </div>

                            @if (session('status') === 'visit-info-updated')
                                <p class="mt-4 text-sm text-green-600 font-medium">
                                    ✓ Visit information saved successfully!
                                </p>
                            @endif
                        </form>
                    @endif

                    {{-- Back button for patients --}}
                    @if(isset($isReadOnly) && $isReadOnly)
                        <div class="mt-6">
                            <a href="{{ route('user.reservations.index') }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 font-medium inline-block">
                                Back to My Reservations
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

