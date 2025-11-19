<x-app-layout>
    <div class="p-6 max-w-xl mx-auto">

        <h1 class="text-2xl mb-4">Edit Term</h1>

        @if ($errors->any())
            <div class="p-4 bg-red-100 text-red-700 mb-4 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('doctor.terms.update', $term->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label>Date</label>
                <input type="date" name="date" value="{{ $term->date }}" class="input w-full" required>
            </div>

            <div class="mb-4">
                <label>Department</label>
                <select name="dep_id" class="input w-full" required>
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}" @selected($term->dep_id == $dep->id)>
                            {{ $dep->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label>Cabinet</label>
                <select name="cab_id" class="input w-full" required>
                    @foreach($cabinets as $cab)
                        <option value="{{ $cab->id }}" @selected($term->cab_id == $cab->id)>
                            {{ $cab->number }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label>Start time</label>
                <input type="time" name="start_time" value="{{ $term->start_time }}" class="input w-full" required>
            </div>

            <div class="mb-4">
                <label>End time</label>
                <input type="time" name="end_time" value="{{ $term->end_time }}" class="input w-full" required>
            </div>

            <div class="mb-4">
                <label>Description</label>
                <textarea name="desc" class="input w-full">{{ $term->desc }}</textarea>
            </div>

            <button class="btn btn-primary w-full">Update term</button>
        </form>
    </div>
</x-app-layout>
