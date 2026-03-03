<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Available Terms
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

            {{-- Filters --}}
            <div class="bg-white shadow sm:rounded-lg p-4">
                <form method="GET" class="flex flex-col md:flex-row gap-3 md:items-end">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Date</label>
                        <input type="date" name="date" value="{{ request('date') }}"
                               class="border rounded px-3 py-2 w-full">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Department</label>
                        <select name="dep_id" class="border rounded px-3 py-2 w-full">
                            <option value="">All</option>
                            @foreach($departments as $dep)
                                <option value="{{ $dep->id }}" @selected(request('dep_id') == $dep->id)>
                                    {{ $dep->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Doctor</label>
                        <input type="text" name="doctor" value="{{ request('doctor') }}"
                               placeholder="Doctor name..."
                               class="border rounded px-3 py-2 w-full">
                    </div>

                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-black text-white rounded">
                            Apply
                        </button>

                        <a href="{{ route('user.terms.index') }}"
                           class="px-4 py-2 border rounded">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- List --}}
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                        <tr class="text-left border-b">
                            <th class="py-2">Date</th>
                            <th class="py-2">Time</th>
                            <th class="py-2">Department</th>
                            <th class="py-2">Doctor</th>
                            <th class="py-2">Cabinet</th>
                            <th class="py-2">Note</th>
                            <th class="py-2">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($terms as $term)
                            <tr class="border-b">
                                <td class="py-2">{{ optional($term->date)->format('Y-m-d') ?? $term->date }}</td>
                                <td class="py-2">{{ $term->start_time }} - {{ $term->end_time }}</td>
                                <td class="py-2">{{ $term->department?->name ?? '-' }}</td>

                                <td class="py-2">
                                    @if($term->doctor)
                                        <a href="{{ route('doctors.show', $term->doctor) }}"
                                           class="text-blue-600 hover:underline">
                                            {{ $term->doctor->name }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="py-2">
                                    {{ $term->cabinet?->number ?? $term->cab_id }}
                                </td>
                                <td class="py-2 text-gray-600">{{ $term->desc ?? '' }}</td>
                                <td class="py-2">
                                    <a href="{{ route('user.reservations.create', $term) }}"
                                       class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                        Book
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center text-gray-500">
                                    No available terms found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $terms->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
