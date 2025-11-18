<x-app-layout>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.departments.store') }}">
            @csrf

            <div>
                <label>Name</label>
                <input name="name" class="input" required>
            </div>

            <div class="mt-3">
                <label>Description</label>
                <textarea name="desc" class="textarea"></textarea>
            </div>

            <button class="btn mt-4">Create</button>
        </form>
    </div>
</x-app-layout>
