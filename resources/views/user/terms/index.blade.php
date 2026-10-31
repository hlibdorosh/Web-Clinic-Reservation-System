<x-app-layout>
    <x-slot name="header">
        <h2>
            Available terms
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            {{-- Messages --}}
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert-error">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Filters --}}
            <div class="card p-4">
                <form method="GET" class="flex flex-col md:flex-row gap-3 md:items-end">
                    <div>
                        <label class="block text-sm text-ink-600 mb-1">Date</label>
                        <input type="date" name="date" value="{{ request('date') }}"
                               class="input w-full">
                    </div>

                    <div>
                        <label class="block text-sm text-ink-600 mb-1">Department</label>
                        <select name="dep_id" class="input w-full">
                            <option value="">All</option>
                            @foreach($departments as $dep)
                                <option value="{{ $dep->id }}" @selected(request('dep_id') == $dep->id)>
                                    {{ $dep->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-ink-600 mb-1">Doctor</label>
                        <input type="text" name="doctor" value="{{ request('doctor') }}"
                               placeholder="Doctor name"
                               class="input w-full">
                    </div>

                    <div class="flex gap-2">
                        <button class="btn">
                            Apply
                        </button>

                        <a href="{{ route('user.terms.index') }}"
                           class="btn btn-outline">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- List --}}
            <div class="card overflow-x-auto">
                <table class="table">
                    <thead>
                    <tr class="text-left">
                        <th>Date</th>
                        <th>Time</th>
                        <th>Department</th>
                        <th>Doctor</th>
                        <th>Cabinet</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($terms as $term)
                        <tr>
                            <td class="tabular-nums">{{ optional($term->date)->format('Y-m-d') ?? $term->date }}</td>
                            <td class="tabular-nums">{{ $term->start_time }} - {{ $term->end_time }}</td>
                            <td>{{ $term->department?->name ?? '-' }}</td>

                            <td>
                                @if($term->doctor)
                                    <a href="{{ route('doctors.show', $term->doctor) }}"
                                       class="text-ocean-700 hover:underline">
                                        {{ $term->doctor->name }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                {{ $term->cabinet?->number ?? $term->cab_id }}
                            </td>
                            <td class="text-ink-600">{{ $term->desc ?? '' }}</td>
                            <td>
                                <a href="{{ route('user.reservations.create', $term) }}"
                                   class="btn btn-sm">
                                    Book
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-ink-500">
                                No available terms found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="px-4 py-3 border-t border-line">
                    {{ $terms->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
