<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Reservations
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Messages --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Quick Link --}}
            <div>
                <a href="{{ route('user.terms.index') }}"
                   class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Browse Available Terms
                </a>
            </div>

            {{-- Reservations List --}}
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                        <tr class="text-left border-b">
                            <th class="py-2">Date</th>
                            <th class="py-2">Time</th>
                            <th class="py-2">Doctor</th>
                            <th class="py-2">Department</th>
                            <th class="py-2">Cabinet</th>
                            <th class="py-2">Service</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($reservations as $reservation)
                            <tr class="border-b">
                                <td class="py-2">
                                    {{ optional($reservation->term->date)->format('Y-m-d') ?? $reservation->term->date }}
                                </td>
                                <td class="py-2">
                                    {{ $reservation->term->start_time }} - {{ $reservation->term->end_time }}
                                </td>
                                <td class="py-2">
                                    @if($reservation->term->doctor)
                                        <a href="{{ route('doctors.show', $reservation->term->doctor) }}"
                                           class="text-blue-600 hover:underline">
                                            {{ $reservation->term->doctor->name }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-2">
                                    {{ $reservation->term->department?->name ?? '-' }}
                                </td>
                                <td class="py-2">
                                    {{ $reservation->term->cabinet?->number ?? $reservation->term->cab_id }}
                                </td>
                                <td class="py-2">
                                    {{ $reservation->service?->name ?? '-' }}
                                </td>
                                <td class="py-2">
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        {{ $reservation->state === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $reservation->state === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $reservation->state === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ ucfirst($reservation->state) }}
                                    </span>
                                </td>
                                <td class="py-2">
                                    @if($reservation->state === 'pending')
                                        <form method="POST" action="{{ route('user.reservations.cancel', $reservation) }}"
                                              onsubmit="return confirm('Are you sure you want to cancel this reservation?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-4 text-center text-gray-500">
                                    You have no reservations yet.
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
