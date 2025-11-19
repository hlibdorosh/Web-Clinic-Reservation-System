<x-app-layout>
    <div class="p-6">
        <h1 class="text-xl mb-4">Add Cabinet</h1>

        <form method="POST" action="{{ route('admin.cabinets.store') }}">
            @csrf

            <div class="mb-3">
                <label>Number</label>
                <input name="number" class="input w-full" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="desc" class="textarea w-full"></textarea>
            </div>

            <div class="mb-3">
                <label>Department</label>
                <select name="dep_id" class="input w-full" required>
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Create</button>
        </form>
    </div>
</x-app-layout>
