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
                <select name="dep_id" class="input w-full" required>
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="mb-4">
                <label>Cabinet</label>
                <select name="cab_id" class="input w-full">
                    @foreach($cabinets as $cab)
                        <option value="{{ $cab->id }}">{{ $cab->number }}</option>
                    @endforeach
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
