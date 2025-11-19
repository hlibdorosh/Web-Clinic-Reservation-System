<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl mb-4">My Terms</h1>

        <a href="{{ route('doctor.terms.create') }}" class="btn btn-primary mb-4">
            Add New Term
        </a>

        <table class="table w-full">
            <thead>
            <tr>
                <th>Cabinet</th>
                <th>Start</th>
                <th>End</th>
                <th>Taken?</th>
            </tr>
            </thead>
            <tbody>
            @foreach($terms as $term)
                <tr>
                    <td>{{ $term->cabinet->number ?? 'No cabinet' }}</td>
                    <td>{{ $term->start_time }}</td>
                    <td>{{ $term->end_time }}</td>
                    <td>{{ $term->is_taken ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
