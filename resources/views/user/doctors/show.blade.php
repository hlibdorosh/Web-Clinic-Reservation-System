<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Doctor: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="p-6">
        <p class="text-gray-600 mb-4">
            Email: {{ $user->email }}
        </p>

        <h3 class="text-lg font-semibold mb-2">Available Terms</h3>

        <table class="w-full border">
            <thead>
            <tr class="bg-gray-100">
                <th class="p-2">Date</th>
                <th class="p-2">Time</th>
                <th class="p-2">Cabinet</th>
            </tr>
            </thead>
            <tbody>
            @forelse($terms as $term)
                <tr class="border-t">
                    <td class="p-2">{{ $term->date }}</td>
                    <td class="p-2">{{ $term->start_time }} – {{ $term->end_time }}</td>
                    <td class="p-2">{{ $term->cabinet?->number ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500">
                        No available terms
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
