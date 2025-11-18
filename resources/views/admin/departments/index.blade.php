<x-app-layout>
    <div class="p-6">
        <a href="{{ route('admin.departments.create') }}" class="btn">Add Department</a>

        <table class="table w-full mt-4">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th class="text-right"></th>
            </tr>
            </thead>

            <tbody>
            @foreach($departments as $department)
                <tr>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->desc }}</td>

                    <td class="text-right">
                        <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-sm">Edit</a>

                        <form action="{{ route('admin.departments.destroy', $department) }}"
                              method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Delete?')">

                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">X</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $departments->links() }}
    </div>
</x-app-layout>
