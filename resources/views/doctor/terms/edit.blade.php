<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"><div class="card p-6 max-w-xl">

        <h1 class="page-title mb-6">Edit term</h1>

        @if ($errors->any())
            <div class="alert-error mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('doctor.terms.update', $term->id) }}" method="POST" onsubmit="formatTimeFields(event)">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-ink-900 mb-1">Date</label>
                <input type="date" name="date" value="{{ $term->date }}" class="input w-full" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-ink-900 mb-1">Department</label>
                <select name="dep_id" id="departmentSelect" class="input w-full" required onchange="filterCabinets()">
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}" @selected($term->dep_id == $dep->id)>
                            {{ $dep->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-ink-900 mb-1">Cabinet</label>
                <select name="cab_id" id="cabinetSelect" class="input w-full" required>
                    <option value="">Select cabinet</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-ink-900 mb-1">Start time</label>
                <input type="time" name="start_time" value="{{ substr($term->start_time, 0, 5) }}" class="input w-full" step="60" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-ink-900 mb-1">End time</label>
                <input type="time" name="end_time" value="{{ substr($term->end_time, 0, 5) }}" class="input w-full" step="60" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-ink-900 mb-1">Description</label>
                <textarea name="desc" rows="4" class="input h-auto w-full py-2">{{ $term->desc }}</textarea>
            </div>

            <button class="btn w-full">Update term</button>
        </form>

        <script>
            // Store cabinets grouped by department
            const cabinetsByDepartment = {!! json_encode(
                $departments->mapWithKeys(function($dep) {
                    return [$dep->id => $dep->cabinets->map(function($cab) {
                        return ['id' => $cab->id, 'number' => $cab->number];
                    })];
                })
            ) !!};

            const currentCabinetId = {{ $term->cab_id }};

            function filterCabinets() {
                const departmentId = document.getElementById('departmentSelect').value;
                const cabinetSelect = document.getElementById('cabinetSelect');

                // Clear existing options
                cabinetSelect.innerHTML = '<option value="">Select cabinet</option>';

                // Add cabinets for selected department
                if (departmentId && cabinetsByDepartment[departmentId]) {
                    cabinetsByDepartment[departmentId].forEach(cabinet => {
                        const option = document.createElement('option');
                        option.value = cabinet.id;
                        option.textContent = cabinet.number;
                        if (cabinet.id === currentCabinetId) {
                            option.selected = true;
                        }
                        cabinetSelect.appendChild(option);
                    });
                }
            }

            // Initialize cabinet list on page load
            window.addEventListener('DOMContentLoaded', function() {
                filterCabinets();
            });

            function formatTimeFields(event) {
                const startTimeInput = document.querySelector('input[name="start_time"]');
                const endTimeInput = document.querySelector('input[name="end_time"]');

                if (startTimeInput.value) {
                    startTimeInput.value = startTimeInput.value.substring(0, 5);
                }
                if (endTimeInput.value) {
                    endTimeInput.value = endTimeInput.value.substring(0, 5);
                }
            }
        </script>
    </div></div>
</x-app-layout>
