<x-app-layout>
    <div class="p-6">
        <h1 class="text-xl mb-4">Edit Cabinet</h1>

        <form method="POST" action="{{ route('admin.cabinets.update', $cabinet) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Number</label>
                <input name="number" class="input w-full" value="{{ $cabinet->number }}" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="desc" class="textarea w-full">{{ $cabinet->desc }}</textarea>
            </div>

            <div class="mb-3">
                <label>Department</label>

                <select name="dep_id" class="input w-full" required>
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}"
                            @selected($cabinet->dep_id == $dep->id)>
                            {{ $dep->name }}
                        </option>
                    @endforeach
                </select>

            </div>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</x-app-layout>
