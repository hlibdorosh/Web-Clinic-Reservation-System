<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Terms Calendar
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Add New Term Button --}}
            <div>
                <a href="{{ route('doctor.terms.create') }}"
                   class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                    + Add New Term
                </a>
            </div>

            {{-- Calendar View --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                {{-- Calendar Header --}}
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 text-center">{{ $calendarData['month'] }}</h3>
                </div>

                {{-- Day Headers --}}
                <div class="grid grid-cols-7 gap-1 mb-2">
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                        <div class="text-center font-semibold text-gray-700 py-2 text-sm">{{ $dayName }}</div>
                    @endforeach
                </div>

                {{-- Calendar Days --}}
                <div class="grid grid-cols-7 gap-1 bg-gray-50 p-2 rounded">
                    @foreach($calendarData['days'] as $dayData)
                        @if($dayData === null)
                            <div class="bg-white h-24 rounded"></div>
                        @else
                            <div class="bg-white border border-gray-200 rounded h-24 p-1 overflow-hidden hover:shadow-md transition cursor-pointer
                                {{ $dayData['hasTerms'] ? 'ring-2 ring-blue-400' : '' }}">
                                <div class="text-sm font-semibold text-gray-700 mb-1">{{ $dayData['day'] }}</div>

                                @if($dayData['hasTerms'])
                                    <div class="space-y-0.5">
                                        @foreach($dayData['terms']->take(2) as $term)
                                            @php
                                                $statusColor = 'bg-gray-500 text-white';
                                                if($term->reservations->isNotEmpty()) {
                                                    // Get the first non-cancelled reservation
                                                    $reservation = $term->reservations->where('state', '!=', 'cancelled')->first();
                                                    if($reservation) {
                                                        if($reservation->state === 'pending') {
                                                            $statusColor = 'bg-amber-500 text-amber-950';
                                                        } elseif($reservation->state === 'confirmed') {
                                                            $statusColor = 'bg-green-500 text-white';
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <div class="text-xs px-1 py-0.5 rounded font-medium truncate
                                                {{ $statusColor }}
                                                {{ count($dayData['terms']) > 2 ? 'text-xs' : 'text-xs' }}">
                                                {{ $term->start_time }}
                                            </div>
                                        @endforeach

                                        @if(count($dayData['terms']) > 2)
                                            <div class="text-xs text-gray-500 px-1">
                                                +{{ count($dayData['terms']) - 2 }} more
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-xs text-gray-400">-</div>
                                @endif

                                {{-- Quick Add Button --}}
                                <a href="{{ route('doctor.terms.create') }}"
                                   class="hidden group-hover:block text-xs text-blue-600 hover:text-blue-800 mt-1">
                                    Add
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Legend --}}
                <div class="mt-6 flex gap-6 justify-center text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-amber-500 rounded"></div>
                        <span>Pending</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-green-500 rounded"></div>
                        <span>Confirmed</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-gray-500 rounded"></div>
                        <span>Available</span>
                    </div>
                </div>
            </div>

            {{-- Terms Table for Current Month --}}
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-4 overflow-x-auto">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">All Terms - {{ $calendarData['month'] }}</h3>

                    @if($terms->isEmpty())
                        <p class="text-gray-500">No terms for this month.</p>
                    @else
                        <table class="min-w-full text-sm">
                            <thead>
                            <tr class="text-left border-b">
                                <th class="py-2 px-2">Date</th>
                                <th class="py-2 px-2">Time</th>
                                <th class="py-2 px-2">Department</th>
                                <th class="py-2 px-2">Cabinet</th>
                                <th class="py-2 px-2">Status</th>
                                <th class="py-2 px-2">Patient</th>
                                <th class="py-2 px-2">Service</th>
                                <th class="py-2 px-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($terms as $term)
                                @if($term->date->month === $calendarData['monthNum'] && $term->date->year === $calendarData['year'])
                                    <tr class="border-b {{ $term->is_taken ? 'bg-blue-50' : '' }}">
                                        <td class="py-2 px-2">{{ optional($term->date)->format('Y-m-d') ?? $term->date }}</td>
                                        <td class="py-2 px-2">{{ $term->start_time }} - {{ $term->end_time }}</td>
                                        <td class="py-2 px-2">{{ $term->department?->name ?? '-' }}</td>
                                        <td class="py-2 px-2">{{ $term->cabinet?->number ?? 'No cabinet' }}</td>
                                        <td class="py-2 px-2">
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
                                        <td class="py-2 px-2">
                                            @if($term->reservations->isNotEmpty())
                                                @foreach($term->reservations as $reservation)
                                                    <div class="mb-1">
                                                        @if($reservation->patient)
                                                            <a href="{{ route('doctor.patients.info', $reservation->patient) }}" class="text-blue-600 hover:underline font-medium text-sm">
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
                                        <td class="py-2 px-2">
                                            @if($term->reservations->isNotEmpty())
                                                @foreach($term->reservations as $reservation)
                                                    <div class="mb-1">{{ $reservation->service?->name ?? '-' }}</div>
                                                @endforeach
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-2 space-y-1">
                                            @if($term->reservations->isNotEmpty())
                                                @foreach($term->reservations as $reservation)
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        <span class="px-2 py-0.5 rounded text-xs font-medium
                                                            {{ $reservation->state === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                            {{ $reservation->state === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                                            {{ $reservation->state === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                        ">{{ ucfirst($reservation->state) }}</span>

                                                        <a href="{{ route('doctor.reservations.showInfo', $reservation) }}" class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700 font-medium">
                                                            Conclusion
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
                                @endif
                            @empty
                                <tr>
                                    <td colspan="8" class="py-4 text-center text-gray-500">
                                        No terms found. Create your first term to get started.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

