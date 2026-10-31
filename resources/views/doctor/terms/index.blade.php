<x-app-layout>
    <x-slot name="header">
        <h2>
            My terms
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div>
                <a href="{{ route('doctor.terms.create') }}" class="btn">
                    Add new term
                </a>
            </div>

            <div class="card overflow-x-auto">
                <table class="table">
                    <thead>
                    <tr class="text-left">
                        <th class="whitespace-nowrap">Date</th>
                        <th class="whitespace-nowrap">Time</th>
                        <th class="whitespace-nowrap">Department</th>
                        <th class="whitespace-nowrap">Cabinet</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="whitespace-nowrap">Patient</th>
                        <th class="whitespace-nowrap">Service</th>
                        <th class="whitespace-nowrap">Reservation</th>
                        <th class="whitespace-nowrap">Conclusion</th>
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($terms as $term)
                        <tr>
                            <td class="tabular-nums">{{ optional($term->date)->format('Y-m-d') ?? $term->date }}</td>
                            <td class="whitespace-nowrap tabular-nums">{{ $term->start_time }} - {{ $term->end_time }}</td>
                            <td>{{ $term->department?->name ?? '-' }}</td>
                            <td class="tabular-nums">{{ $term->cabinet?->number ?? 'No cabinet' }}</td>
                            <td>
                                @if($term->is_taken)
                                    <span class="inline-flex items-center gap-2 text-sm text-ink-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Booked
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 text-sm text-ink-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-ink-400"></span>
                                        Available
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($term->reservations->isNotEmpty())
                                    @foreach($term->reservations as $reservation)
                                        <div class="mb-1">
                                            @if($reservation->patient)
                                                <a href="{{ route('doctor.patients.info', $reservation->patient) }}" class="text-ocean-700 hover:underline">
                                                    {{ $reservation->patient->name }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-ink-500">-</span>
                                @endif
                            </td>
                            <td>
                                @if($term->reservations->isNotEmpty())
                                    @foreach($term->reservations as $reservation)
                                        <div class="mb-1">{{ $reservation->service?->name ?? '-' }}</div>
                                    @endforeach
                                @else
                                    <span class="text-ink-500">-</span>
                                @endif
                            </td>
                            <td>
                                @if($term->reservations->isNotEmpty())
                                    @foreach($term->reservations as $reservation)
                                        <div class="mb-2">
                                            <span class="inline-flex items-center gap-2 text-sm text-ink-600 whitespace-nowrap">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $reservation->state === 'pending' ? 'bg-amber-600' : ($reservation->state === 'confirmed' ? 'bg-emerald-600' : ($reservation->state === 'cancelled' ? 'bg-red-600' : 'bg-ink-400')) }}"></span>
                                                {{ ucfirst($reservation->state) }}
                                            </span>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-ink-500">-</span>
                                @endif
                            </td>
                            <td>
                                @if($term->reservations->isNotEmpty())
                                    @foreach($term->reservations as $reservation)
                                        <div class="mb-2">
                                            @if($reservation->state !== 'pending')
                                                <a href="{{ route('doctor.reservations.showInfo', $reservation) }}" class="btn-outline btn-sm">
                                                    Conclusion
                                                </a>
                                            @else
                                                <span class="text-ink-500">-</span>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-ink-500">-</span>
                                @endif
                            </td>
                            <td>
                                @if($term->reservations->isNotEmpty())
                                    @foreach($term->reservations as $reservation)
                                        <div class="flex items-center gap-2 mb-2">
                                            @if($reservation->state === 'pending')
                                                <form method="POST" action="{{ route('doctor.reservations.confirm', $reservation) }}" style="display:inline;">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="btn btn-sm">
                                                        Confirm
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('doctor.reservations.cancel', $reservation) }}"
                                                      onsubmit="return confirm('Cancel this reservation?')" style="display:inline;">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="text-sm text-red-600 hover:underline">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('doctor.terms.edit', $term) }}"
                                           class="btn-outline btn-sm whitespace-nowrap">Edit</a>
                                        <form method="POST" action="{{ route('doctor.terms.destroy', $term) }}"
                                              onsubmit="return confirm('Delete this term?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:underline whitespace-nowrap">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-ink-500">
                                No terms found. Create your first term to get started.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
