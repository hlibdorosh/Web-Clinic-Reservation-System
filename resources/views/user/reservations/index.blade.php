<x-app-layout>
    <x-slot name="header">
        <h2>
            My reservations
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            {{-- Messages --}}
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert-error">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Quick Link --}}
            <div>
                <a href="{{ route('user.terms.index') }}" class="btn">
                    Browse available terms
                </a>
            </div>

            {{-- Reservations List --}}
            <div class="card overflow-x-auto">
                <table class="table">
                    <thead>
                    <tr class="text-left">
                        <th class="whitespace-nowrap">Date</th>
                        <th class="whitespace-nowrap">Time</th>
                        <th class="whitespace-nowrap">Doctor</th>
                        <th class="whitespace-nowrap">Department</th>
                        <th class="whitespace-nowrap">Cabinet</th>
                        <th class="whitespace-nowrap">Service</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="whitespace-nowrap">Conclusion</th>
                        <th class="whitespace-nowrap">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td class="tabular-nums">
                                {{ optional($reservation->term->date)->format('Y-m-d') ?? $reservation->term->date }}
                            </td>
                            <td class="whitespace-nowrap tabular-nums">
                                {{ $reservation->term->start_time }} - {{ $reservation->term->end_time }}
                            </td>
                            <td>
                                @if($reservation->term->doctor)
                                    <a href="{{ route('doctors.show', $reservation->term->doctor) }}"
                                       class="text-ocean-700 hover:underline">
                                        {{ $reservation->term->doctor->name }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                {{ $reservation->term->department?->name ?? '-' }}
                            </td>
                            <td>
                                {{ $reservation->term->cabinet?->number ?? $reservation->term->cab_id }}
                            </td>
                            <td>
                                {{ $reservation->service?->name ?? '-' }}
                            </td>
                            <td>
                                <span class="inline-flex items-center gap-2 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full
                                        {{ $reservation->state === 'pending' ? 'bg-amber-600' : '' }}
                                        {{ $reservation->state === 'confirmed' ? 'bg-emerald-600' : '' }}
                                        {{ $reservation->state === 'cancelled' ? 'bg-red-600' : '' }}
                                        {{ !in_array($reservation->state, ['pending', 'confirmed', 'cancelled']) ? 'bg-ink-400' : '' }}
                                    "></span>
                                    {{ ucfirst($reservation->state) }}
                                </span>
                            </td>
                            <td>
                                @if($reservation->state !== 'pending')
                                    <a href="{{ route('user.reservations.showInfo', $reservation) }}" class="btn btn-sm btn-outline">
                                        Conclusion
                                    </a>
                                @else
                                    <span class="text-ink-400">-</span>
                                @endif
                            </td>
                            <td>
                                @if($reservation->state === 'pending')
                                    <form method="POST" action="{{ route('user.reservations.cancel', $reservation) }}"
                                          onsubmit="return confirm('Are you sure you want to cancel this reservation?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline text-red-600 whitespace-nowrap">
                                            Cancel
                                        </button>
                                    </form>
                                @else
                                    <span class="text-ink-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-ink-500">
                                You have no reservations yet.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
