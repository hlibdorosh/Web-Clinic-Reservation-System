<x-app-layout>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.departments.update', $department) }}">
            @csrf
            @method('PUT')

            <div>
                <label>Name</label>
                <input name="name" value="{{ $department->name }}" class="input" required>
            </div>

            <div class="mt-3">
                <label>Description</label>
                <textarea name="desc" class="textarea">{{ $department->desc }}</textarea>
            </div>

            <button class="btn mt-4">Update</button>
        </form>
    </div>
</x-app-layout>
