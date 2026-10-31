<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="page-title">Services</h1>
            <a href="{{ route('admin.services.create') }}" class="btn">Add service</a>
        </div>

        <!-- Filter section -->
        <div class="card p-5 mb-6">
            <form method="GET" action="{{ route('admin.services.index') }}" class="flex flex-wrap gap-4 items-end">
                <!-- Search -->
                <div class="flex-1 min-w-64">
                    <label class="block text-sm font-medium text-ink-900 mb-1">Search</label>
                    <input
                        type="text"
                        name="search"
                        placeholder="Name or description"
                        value="{{ request('search') }}"
                        class="input"
                    >
                </div>

                <!-- Department filter dropdown -->
                <div class="relative">
                    <button
                        type="button"
                        class="btn-outline flex items-center gap-2"
                        id="dept-dropdown-btn"
                    >
                        Departments
                        <svg class="w-4 h-4 text-ink-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div
                        id="dept-dropdown-menu"
                        class="absolute left-0 mt-2 w-64 bg-white border border-line-strong rounded-xl z-10 hidden"
                    >
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-sm font-medium text-ink-900">Filter by department</h3>
                                <button
                                    type="button"
                                    class="text-sm text-ocean-700 hover:underline"
                                    id="clear-depts"
                                >
                                    Clear all
                                </button>
                            </div>
                            <div class="space-y-1">
                                @foreach($departments as $dept)
                                    <label class="flex items-center gap-3 px-2 py-2 hover:bg-ink-50 rounded-lg cursor-pointer">
                                        <input
                                            type="checkbox"
                                            name="departments[]"
                                            value="{{ $dept->id }}"
                                            @if(is_array(request('departments')) && in_array($dept->id, request('departments'))) checked @endif
                                            class="w-4 h-4 text-ocean-700 rounded focus:ring-2 focus:ring-ocean-600 dept-checkbox"
                                        >
                                        <span class="text-sm text-ink-600">{{ $dept->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="btn">
                        Filter
                    </button>
                    <a href="{{ route('admin.services.index') }}" class="btn-outline">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="card overflow-hidden">
            <table class="table w-full">
                <thead>
                <tr>
                    <th class="text-left">Name</th>
                    <th class="text-left">Department</th>
                    <th class="text-left">Price</th>
                    <th class="text-right"></th>
                </tr>
                </thead>

                <tbody>
                @forelse($services as $item)
                    <tr>
                        <td class="text-ink-900">{{ $item->name }}</td>
                        <td class="text-ink-600">{{ $item->department?->name ?? '—' }}</td>
                        <td class="text-ink-600 tabular-nums">{{ $item->price }}</td>
                        <td class="text-right whitespace-nowrap">
                            <a href="{{ route('admin.services.edit', $item) }}" class="btn-outline btn-sm">Edit</a>

                            <form action="{{ route('admin.services.destroy', $item) }}"
                                  method="POST" class="inline-block"
                                  onsubmit="return confirm('Delete?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline btn-sm text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-ink-500">No services found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $services->links() }}</div>
    </div>

    <script>
        // Dropdown toggle functionality
        const dropdownBtn = document.getElementById('dept-dropdown-btn');
        const dropdownMenu = document.getElementById('dept-dropdown-menu');
        const clearBtn = document.getElementById('clear-depts');
        const chevron = '<svg class="w-4 h-4 text-ink-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>';

        // Toggle dropdown
        dropdownBtn.addEventListener('click', function(e) {
            e.preventDefault();
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        // Clear all checkboxes
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.dept-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
        });

        // Update button text to show selected departments count
        function updateButtonText() {
            const checkedCount = document.querySelectorAll('.dept-checkbox:checked').length;

            if (checkedCount > 0) {
                dropdownBtn.innerHTML = `Departments (${checkedCount}) ${chevron}`;
            } else {
                dropdownBtn.innerHTML = `Departments ${chevron}`;
            }
        }

        // Update text on checkbox change
        document.querySelectorAll('.dept-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateButtonText);
        });

        // Initialize button text on page load
        updateButtonText();
    </script>
</x-app-layout>
