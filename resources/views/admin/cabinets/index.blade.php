<x-app-layout>
    <div class="p-6">
        <a href="{{ route('admin.cabinets.create') }}" class="btn">Add Cabinet</a>

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
            @foreach($cabinets as $cabinet)
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
            @endforeach
            </tbody>
        </table>

        {{ $cabinets->links() }}
    </div>
</x-app-layout>
