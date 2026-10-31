<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="page-title mb-6">Add cabinet</h1>

        <form method="POST" action="{{ route('admin.cabinets.store') }}" class="card max-w-xl p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1">Number</label>
                <input name="number" class="input" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1">Description</label>
                <textarea name="desc" rows="3" class="input h-auto py-2"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1">Department</label>
                <select name="dep_id" class="input" required>
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn">Create</button>
        </form>
    </div>
</x-app-layout>
