<x-app-layout>
    <div class="p-6">

        <h1 class="text-2xl mb-4">User Profile</h1>

        {{-- PERSONAL INFO --}}
        <div class="mb-6 p-4 border rounded-lg">
            <h2 class="text-xl mb-2">Personal Information</h2>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
        </div>

        {{-- TERMS --}}
        <h2 class="text-xl mb-2">Terms</h2>

        @if($terms->isEmpty())
            <p>No terms</p>
        @else
            <table class="table w-full">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Service</th>
                    <th>Doctor</th>
                    <th>Cabinet</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @foreach($terms as $term)
                    <tr>
                        <td>{{ $term->date }}</td>
                        <td>{{ $term->service?->name }}</td>
                        <td>{{ $term->doctor?->name }}</td>
                        <td>{{ $term->cabinet?->number }}</td>

                        <td class="text-right">
                            <form method="POST"
                                  action="{{ route('admin.users.term.delete', $term) }}"
                                  onsubmit="return confirm('Delete this term?');">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

    </div>
</x-app-layout>
