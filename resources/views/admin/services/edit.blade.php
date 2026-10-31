<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="page-title mb-6">Edit service</h1>

        <form method="POST" action="{{ route('admin.services.update', $service) }}" class="card max-w-xl p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1">Name</label>
                <input class="input" name="name" value="{{ $service->name }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1">Price</label>
                <input class="input tabular-nums" type="number" name="price" value="{{ $service->price }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1">Description</label>
                <textarea class="input h-auto py-2" rows="3" name="desc">{{ $service->desc }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1">Department (optional)</label>
                <select class="input" name="dep_id">
                    <option value="">No department</option>
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}"
                            @selected($service->dep_id == $dep->id)>
                            {{ $dep->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn">Update</button>
        </form>
    </div>
</x-app-layout>
