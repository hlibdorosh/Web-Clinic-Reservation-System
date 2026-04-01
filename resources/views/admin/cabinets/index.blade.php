<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('admin.cabinets.create') }}" class="btn">Add Cabinet</a>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" action="{{ route('admin.cabinets.index') }}" class="flex flex-wrap gap-4 items-end">
                <!-- Search Bar -->
                <div class="flex-1 min-w-64">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Cabinets</label>
                    <input
                        type="text"
                        name="search"
                        placeholder="Search by number or description..."
                        value="{{ request('search') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500"
                    >
                </div>

                <!-- Department Filter Dropdown -->
                <div class="relative group">
                    <button
                        type="button"
                        class="btn flex items-center gap-2"
                        id="dept-dropdown-btn"
                    >
                        Departments
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                        id="dept-dropdown-menu"
                        class="absolute left-0 mt-2 w-64 bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden"
                    >
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="font-semibold text-gray-700">Filter by Department</h3>
                                <button
                                    type="button"
                                    class="text-sm text-blue-500 hover:text-blue-700"
                                    id="clear-depts"
                                >
                                    Clear All
                                </button>
                            </div>
                            <div class="space-y-2">
                                @foreach($departments as $dept)
                                    <label class="flex items-center p-2 hover:bg-gray-100 rounded cursor-pointer">
                                        <input
                                            type="checkbox"
                                            name="departments[]"
                                            value="{{ $dept->id }}"
                                            @if(is_array(request('departments')) && in_array($dept->id, request('departments'))) checked @endif
                                            class="w-4 h-4 text-blue-500 rounded focus:ring-2 focus:ring-blue-500 dept-checkbox"
                                        >
                                        <span class="ml-3 text-gray-700">{{ $dept->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button>
                    <a href="{{ route('admin.cabinets.index') }}" class="btn">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <table class="table w-full mt-4">
            <thead>
            <tr>
                <th>Number</th>
                <th>Description</th>
                <th>Department</th>
                <th class="text-right"></th>
            </tr>
            </thead>

            <tbody>
            @forelse($cabinets as $cabinet)
                <tr>
                    <td>{{ $cabinet->number }}</td>
                    <td>{{ $cabinet->desc }}</td>
                    <td>{{ $cabinet->department?->name }}</td>
                    <td class="text-right">
                        <a href="{{ route('admin.cabinets.edit', $cabinet) }}" class="btn btn-sm">Edit</a>

                        <form action="{{ route('admin.cabinets.destroy', $cabinet) }}"
                              method="POST" class="inline-block"
                              onsubmit="return confirm('Delete?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">X</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">No cabinets found</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $cabinets->links() }}
    </div>

    <script>
        // Dropdown toggle functionality
        const dropdownBtn = document.getElementById('dept-dropdown-btn');
        const dropdownMenu = document.getElementById('dept-dropdown-menu');
        const clearBtn = document.getElementById('clear-depts');

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
                dropdownBtn.innerHTML = `Departments (${checkedCount}) <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>`;
            } else {
                dropdownBtn.innerHTML = `Departments <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>`;
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
