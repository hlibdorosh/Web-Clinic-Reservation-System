<x-app-layout>
    <x-slot name="header">
        <h2>
            My terms calendar
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Add New Term Button --}}
            <div>
                <a href="{{ route('doctor.terms.create') }}" class="btn">
                    Add new term
                </a>
            </div>

            {{-- Calendar View --}}
            <div class="card p-6">
                {{-- Calendar Header --}}
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-ink-900">{{ $calendarData['month'] }}</h3>
                </div>

                {{-- Day Headers --}}
                <div class="grid grid-cols-7 gap-1 mb-2">
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                        <div class="text-center font-medium text-ink-500 py-2 text-xs">{{ $dayName }}</div>
                    @endforeach
                </div>

                {{-- Calendar Days --}}
                <div class="grid grid-cols-7 gap-1">
                    @foreach($calendarData['days'] as $dayData)
                        @if($dayData === null)
                            <div class="bg-ink-50 h-24 rounded-md"></div>
                        @else
                            <div class="bg-white border rounded-md h-24 p-1 overflow-hidden transition-colors cursor-pointer
                                {{ $dayData['hasTerms'] ? 'border-ocean-700' : 'border-line' }}">
                                <div class="text-sm font-medium text-ink-900 mb-1 tabular-nums">{{ $dayData['day'] }}</div>

                                @if($dayData['hasTerms'])
                                    <div class="space-y-0.5">
                                        @foreach($dayData['terms']->take(2) as $term)
                                            @php
                                                $statusColor = 'bg-ink-400';
                                                if($term->reservations->isNotEmpty()) {
                                                    // Get the first non-cancelled reservation
                                                    $reservation = $term->reservations->where('state', '!=', 'cancelled')->first();
                                                    if($reservation) {
                                                        if($reservation->state === 'pending') {
                                                            $statusColor = 'bg-amber-600';
                                                        } elseif($reservation->state === 'confirmed') {
                                                            $statusColor = 'bg-emerald-600';
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <div class="flex items-center gap-1 text-xs text-ink-600 px-1 truncate tabular-nums">
                                                <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ $statusColor }}"></span>
                                                {{ $term->start_time }}
                                            </div>
                                        @endforeach

                                        @if(count($dayData['terms']) > 2)
                                            <div class="text-xs text-ink-500 px-1">
                                                +{{ count($dayData['terms']) - 2 }} more
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-xs text-ink-500">-</div>
                                @endif

                                {{-- Quick Add Button --}}
                                <a href="{{ route('doctor.terms.create') }}"
                                   class="hidden group-hover:block text-xs text-ocean-700 hover:underline mt-1">
                                    Add
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Legend --}}
                <div class="mt-6 flex gap-6 text-sm text-ink-600">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                        <span>Pending</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                        <span>Confirmed</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-ink-400"></span>
                        <span>Available</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
