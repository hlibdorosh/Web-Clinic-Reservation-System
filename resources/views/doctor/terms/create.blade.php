<x-app-layout>
    <div class="p-6 max-w-xl mx-auto">

        <h1 class="text-2xl mb-4">Create New Term</h1>

        @if ($errors->any())
            <div class="p-4 bg-red-100 text-red-700 mb-4 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('doctor.terms.store') }}" method="POST" onsubmit="formatTimeFields(event)">
            @csrf

            <div class="mb-4">
                <label>Department</label>
                <select name="dep_id" id="departmentSelect" class="input w-full" required onchange="filterCabinets()">
                    <option value="">Select Department</option>
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="mb-4">
                <label>Cabinet</label>
                <select name="cab_id" id="cabinetSelect" class="input w-full" required>
                    <option value="">Select Cabinet</option>
                </select>
            </div>

            <div class="mb-4">
                <label>Date</label>
                <input type="date" name="date" class="input w-full" required>
            </div>


            <div class="mb-4">
                <label>Start time</label>
                <input type="time" name="start_time" class="input w-full" step="60" required>
            </div>

            <div class="mb-4">
                <label>End time</label>
                <input type="time" name="end_time" class="input w-full" step="60" required>
            </div>

            <div class="mb-4">
                <label>Description (optional)</label>
                <textarea name="desc" class="input w-full"></textarea>
            </div>

            <button class="btn btn-primary w-full">Create term</button>
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

            function filterCabinets() {
                const departmentId = document.getElementById('departmentSelect').value;
                const cabinetSelect = document.getElementById('cabinetSelect');

                // Clear existing options
                cabinetSelect.innerHTML = '<option value="">Select Cabinet</option>';

                // Add cabinets for selected department
                if (departmentId && cabinetsByDepartment[departmentId]) {
                    cabinetsByDepartment[departmentId].forEach(cabinet => {
                        const option = document.createElement('option');
                        option.value = cabinet.id;
                        option.textContent = cabinet.number;
                        cabinetSelect.appendChild(option);
                    });
                }
            }

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
    </div>
</x-app-layout>
