<x-app-layout>
    <div class="p-6">

        <h1 class="text-2xl mb-4">Users</h1>

        {{-- FILTERS --}}
        <form method="GET" class="mb-4 flex gap-4 items-end">

            <div>
                <label class="block">Role</label>
                <select name="role" class="input">
                    <option value="">All</option>
                    <option value="admin"  @selected(request('role') === 'admin')>Admin</option>
                    <option value="doctor" @selected(request('role') === 'doctor')>Doctor</option>
                    <option value="patient" @selected(request('role') === 'patient')>Patient</option>
                </select>
            </div>

            <div>
                <label class="block">Search</label>
                <input name="search" value="{{ request('search') }}" class="input" placeholder="name or email">
            </div>

            <button class="btn">Apply</button>
        </form>

        {{-- USERS TABLE --}}
        <table class="table w-full">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td class="text-right">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm">Open</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.users.destroy', $user) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this user?')">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>

        {{ $users->links() }}

    </div>
</x-app-layout>
