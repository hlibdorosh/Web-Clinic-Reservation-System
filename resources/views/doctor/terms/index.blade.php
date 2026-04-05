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
                    <table class="w-full text-sm border-collapse">
                        <thead>
                        <tr class="text-left border-b-2 border-gray-300 bg-gray-50">
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Date</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Time</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Department</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Cabinet</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Status</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Patient</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Service</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Reservation</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Conclusion</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($terms as $term)
                            <tr class="border-b hover:bg-gray-50 transition {{ $term->is_taken ? 'bg-blue-50' : '' }}">
                                <td class="py-3 px-4">{{ optional($term->date)->format('Y-m-d') ?? $term->date }}</td>
                                <td class="py-3 px-4 whitespace-nowrap">{{ $term->start_time }} - {{ $term->end_time }}</td>
                                <td class="py-3 px-4">{{ $term->department?->name ?? '-' }}</td>
                                <td class="py-3 px-4 text-center">{{ $term->cabinet?->number ?? 'No cabinet' }}</td>
                                <td class="py-3 px-4">
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
                                <td class="py-3 px-4">
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
                                <td class="py-3 px-4">
                                    @if($term->reservations->isNotEmpty())
                                        @foreach($term->reservations as $reservation)
                                            <div class="mb-1">{{ $reservation->service?->name ?? '-' }}</div>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($term->reservations->isNotEmpty())
                                        @foreach($term->reservations as $reservation)
                                            <div class="mb-2">
                                                <span class="px-2 py-0.5 rounded text-xs font-medium whitespace-nowrap
                                                    {{ $reservation->state === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $reservation->state === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $reservation->state === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                ">{{ ucfirst($reservation->state) }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($term->reservations->isNotEmpty())
                                        @foreach($term->reservations as $reservation)
                                            <div class="mb-2">
                                                @if($reservation->state !== 'pending')
                                                    <a href="{{ route('doctor.reservations.showInfo', $reservation) }}" class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700 font-medium">
                                                        Conclusion
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($term->reservations->isNotEmpty())
                                        @foreach($term->reservations as $reservation)
                                            <div class="flex items-center gap-2 mb-2">
                                                @if($reservation->state === 'pending')
                                                    <form method="POST" action="{{ route('doctor.reservations.confirm', $reservation) }}" style="display:inline;">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="px-2 py-0.5 bg-green-600 text-white rounded text-xs hover:bg-green-700 font-medium">
                                                            Confirm
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('doctor.reservations.cancel', $reservation) }}"
                                                          onsubmit="return confirm('Cancel this reservation?')" style="display:inline;">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="px-2 py-0.5 bg-red-600 text-white rounded text-xs hover:bg-red-700 font-medium">
                                                            Cancel
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="flex items-center justify-between gap-2">
                                            <a href="{{ route('doctor.terms.edit', $term) }}"
                                               class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700 font-medium whitespace-nowrap">Edit</a>
                                            <form method="POST" action="{{ route('doctor.terms.destroy', $term) }}"
                                                  onsubmit="return confirm('Delete this term?')" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-orange-600 text-white rounded text-xs hover:bg-orange-700 font-medium whitespace-nowrap">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="py-4 px-4 text-center text-gray-500">
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
