<x-app-layout>
    <x-slot name="header">
        <h2>
            Doctor: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col sm:flex-row gap-6">
                {{-- Doctor Photo --}}
                @if($user->photo)
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $user->photo) }}"
                             alt="{{ $user->name }}"
                             class="h-48 w-48 object-cover rounded-xl border border-line flex-shrink-0">
                    </div>
                @else
                    <div class="flex-shrink-0 h-48 w-48 bg-ink-50 border border-line rounded-xl flex items-center justify-center">
                        <span class="text-sm text-ink-500">No photo</span>
                    </div>
                @endif

                {{-- Doctor Info --}}
                <div class="flex-1">
                    <p class="text-sm text-ink-600 mb-4">
                        <span class="font-medium text-ink-900">Email:</span> {{ $user->email }}
                    </p>

                    @if($user->bio)
                        <div class="p-4 bg-ink-50 rounded-lg border border-line">
                            <h3 class="text-base font-medium text-ink-900 mb-2">About</h3>
                            <p class="text-sm text-ink-600 whitespace-pre-line">{{ $user->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="text-base font-medium text-ink-900 mb-3">Available terms</h3>

                <div class="card overflow-x-auto">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-left">Date</th>
                            <th class="text-left">Time</th>
                            <th class="text-left">Cabinet</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($terms as $term)
                            <tr>
                                <td class="tabular-nums">{{ $term->date }}</td>
                                <td class="tabular-nums">{{ $term->start_time }} – {{ $term->end_time }}</td>
                                <td>{{ $term->cabinet?->number ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-ink-500">
                                    No available terms
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
