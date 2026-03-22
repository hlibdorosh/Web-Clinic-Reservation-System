<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Terms
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div>
                <a href="{{ route('doctor.terms.create') }}"
                   class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Add New Term
                </a>
            </div>

            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                        <tr class="text-left border-b">
                            <th class="py-2">Date</th>
                            <th class="py-2">Time</th>
                            <th class="py-2">Department</th>
                            <th class="py-2">Cabinet</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Patient</th>
                            <th class="py-2">Service</th>
                            <th class="py-2">Reservation Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($terms as $term)
                            <tr class="border-b {{ $term->is_taken ? 'bg-blue-50' : '' }}">
                                <td class="py-2">{{ optional($term->date)->format('Y-m-d') ?? $term->date }}</td>
                                <td class="py-2">{{ $term->start_time }} - {{ $term->end_time }}</td>
                                <td class="py-2">{{ $term->department?->name ?? '-' }}</td>
                                <td class="py-2">{{ $term->cabinet?->number ?? 'No cabinet' }}</td>
                                <td class="py-2">
                                    @if($term->is_taken)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">
                                            Booked
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">
                                            Available
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2">
                                    @if($term->reservations->isNotEmpty())
                                        @foreach($term->reservations as $reservation)
                                            <div class="mb-1">
                                                @if($reservation->patient)
                                                    <a href="{{ route('doctor.patients.info', $reservation->patient) }}" class="text-blue-600 hover:underline font-medium">
                                                        {{ $reservation->patient->name }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-2">
                                    @if($term->reservations->isNotEmpty())
                                        @foreach($term->reservations as $reservation)
                                            <div class="mb-1">{{ $reservation->service?->name ?? '-' }}</div>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-2 space-y-1">
                                    @if($term->reservations->isNotEmpty())
                                        @foreach($term->reservations as $reservation)
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span class="px-2 py-0.5 rounded text-xs font-medium
                                                    {{ $reservation->state === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $reservation->state === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $reservation->state === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                ">{{ ucfirst($reservation->state) }}</span>

                                                <a href="{{ route('doctor.patients.info', $reservation->patient) }}" class="px-2 py-0.5 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">
                                                    View Info
                                                </a>

                                                @if($reservation->state === 'pending')
                                                    <form method="POST" action="{{ route('doctor.reservations.confirm', $reservation) }}">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="px-2 py-0.5 bg-green-600 text-white rounded text-xs hover:bg-green-700">
                                                            Confirm
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('doctor.reservations.cancel', $reservation) }}"
                                                          onsubmit="return confirm('Cancel this reservation?')">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="px-2 py-0.5 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                                                            Cancel
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('doctor.terms.edit', $term) }}"
                                               class="text-blue-600 hover:underline text-xs">Edit</a>
                                            <form method="POST" action="{{ route('doctor.terms.destroy', $term) }}"
                                                  onsubmit="return confirm('Delete this term?')" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline text-xs">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-4 text-center text-gray-500">
                                    No terms found. Create your first term to get started.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
