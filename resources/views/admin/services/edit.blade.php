<x-app-layout>
    <div class="p-6">
        <h1 class="text-xl mb-4">Edit Service</h1>

        <form method="POST" action="{{ route('admin.services.update', $service) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input class="input w-full" name="name" value="{{ $service->name }}" required>
            </div>

            <div class="mb-3">
                <label>Price</label>
                <input class="input w-full" type="number" name="price" value="{{ $service->price }}" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea class="textarea w-full" name="desc">{{ $service->desc }}</textarea>
            </div>

            <div class="mb-3">
                <label>Department (optional)</label>
                <select class="input w-full" name="dep_id">
                    <option value="">No department</option>
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}"
                            @selected($service->dep_id == $dep->id)>
                            {{ $dep->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</x-app-layout>
