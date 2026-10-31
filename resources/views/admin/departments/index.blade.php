<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="page-title">Departments</h1>
            <a href="{{ route('admin.departments.create') }}" class="btn">Add department</a>
        </div>

        <div class="card overflow-hidden">
            <table class="table w-full">
                <thead>
                <tr>
                    <th class="text-left">Name</th>
                    <th class="text-left">Description</th>
                    <th class="text-right"></th>
                </tr>
                </thead>

                <tbody>
                @foreach($departments as $department)
                    <tr>
                        <td class="text-ink-900">{{ $department->name }}</td>
                        <td class="text-ink-600">{{ $department->desc }}</td>

                        <td class="text-right whitespace-nowrap">
                            <a href="{{ route('admin.departments.edit', $department) }}" class="btn-outline btn-sm">Edit</a>

                            <form action="{{ route('admin.departments.destroy', $department) }}"
                                  method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Delete?')">

                                @csrf
                                @method('DELETE')
                                <button class="btn-outline btn-sm text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $departments->links() }}</div>
    </div>
</x-app-layout>
