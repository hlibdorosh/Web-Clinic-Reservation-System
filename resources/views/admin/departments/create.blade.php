<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="page-title mb-6">Add department</h1>

        <form method="POST" action="{{ route('admin.departments.store') }}" class="card max-w-xl p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1">Name</label>
                <input name="name" class="input" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1">Description</label>
                <textarea name="desc" rows="3" class="input h-auto py-2"></textarea>
            </div>

            <button class="btn">Create</button>
        </form>
    </div>
</x-app-layout>
