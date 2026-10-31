<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <h1 class="page-title mb-6">Users</h1>

        {{-- FILTERS --}}
        <form method="GET" class="mb-6 flex flex-wrap gap-4 items-end">

            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1">Role</label>
                <select name="role" class="input">
                    <option value="">All</option>
                    <option value="admin"  @selected(request('role') === 'admin')>Admin</option>
                    <option value="doctor" @selected(request('role') === 'doctor')>Doctor</option>
                    <option value="patient" @selected(request('role') === 'patient')>Patient</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1">Search</label>
                <input name="search" value="{{ request('search') }}" class="input" placeholder="Name or email">
            </div>

            <button class="btn">Apply</button>
        </form>

        {{-- USERS TABLE --}}
        <div class="card overflow-hidden">
            <table class="table w-full">
                <thead>
                <tr>
                    <th class="text-left">ID</th>
                    <th class="text-left">Name</th>
                    <th class="text-left">Email</th>
                    <th class="text-left">Role</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="text-ink-500 tabular-nums">{{ $user->id }}</td>
                        <td class="text-ink-900">{{ $user->name }}</td>
                        <td class="text-ink-600">{{ $user->email }}</td>
                        <td class="text-ink-600">{{ $user->role }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn-outline btn-sm">Open</a>
                        </td>
                        <td>
                            <form action="{{ route('admin.users.destroy', $user) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this user?')">
                                @csrf
                                @method('DELETE')

                                <button class="text-sm text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $users->links() }}</div>

    </div>
</x-app-layout>
