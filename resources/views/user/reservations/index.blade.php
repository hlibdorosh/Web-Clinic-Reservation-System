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
                    <table class="w-full text-sm border-collapse">
                        <thead>
                        <tr class="text-left border-b-2 border-gray-300 bg-gray-50">
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Date</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Time</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Doctor</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Department</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Cabinet</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Service</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Status</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Conclusion</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 whitespace-nowrap">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($reservations as $reservation)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-4">
                                    {{ optional($reservation->term->date)->format('Y-m-d') ?? $reservation->term->date }}
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    {{ $reservation->term->start_time }} - {{ $reservation->term->end_time }}
                                </td>
                                <td class="py-3 px-4">
                                    @if($reservation->term->doctor)
                                        <a href="{{ route('doctors.show', $reservation->term->doctor) }}"
                                           class="text-blue-600 hover:underline font-medium">
                                            {{ $reservation->term->doctor->name }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    {{ $reservation->term->department?->name ?? '-' }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    {{ $reservation->term->cabinet?->number ?? $reservation->term->cab_id }}
                                </td>
                                <td class="py-3 px-4">
                                    {{ $reservation->service?->name ?? '-' }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        {{ $reservation->state === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $reservation->state === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $reservation->state === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ ucfirst($reservation->state) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($reservation->state !== 'pending')
                                        <a href="{{ route('user.reservations.showInfo', $reservation) }}" class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700 font-medium">
                                            Conclusion
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($reservation->state === 'pending')
                                        <form method="POST" action="{{ route('user.reservations.cancel', $reservation) }}"
                                              onsubmit="return confirm('Are you sure you want to cancel this reservation?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium whitespace-nowrap">
                                                Cancel
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-4 px-4 text-center text-gray-500">
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
