<x-app-layout>
    <div class="p-6">
        <a href="{{ route('admin.services.create') }}" class="btn">Add Service</a>

        <table class="table w-full mt-4">
            <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Price</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td>{{ $service->department?->name ?? '—' }}</td>
                    <td>{{ $service->price }}</td>

                    <td class="text-right">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm">Edit</a>

                        <form action="{{ route('admin.services.destroy', $service) }}"
                              method="POST" class="inline-block"
                              onsubmit="return confirm('Delete?');">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">X</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $services->links() }}
    </div>
</x-app-layout>
