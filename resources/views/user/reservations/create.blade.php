<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Book Appointment
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                {{-- Term Details --}}
                <div class="mb-6 pb-6 border-b">
                    <h3 class="text-lg font-semibold mb-3">Appointment Details</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Date:</span>
                            <span class="font-medium">{{ optional($term->date)->format('Y-m-d') ?? $term->date }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Time:</span>
                            <span class="font-medium">{{ $term->start_time }} - {{ $term->end_time }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Doctor:</span>
                            <span class="font-medium">{{ $term->doctor?->name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Department:</span>
                            <span class="font-medium">{{ $term->department?->name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Cabinet:</span>
                            <span class="font-medium">{{ $term->cabinet?->number ?? $term->cab_id }}</span>
                        </div>
                        @if($term->desc)
                            <div class="col-span-2">
                                <span class="text-gray-600">Note:</span>
                                <span class="font-medium">{{ $term->desc }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Booking Form --}}
                <form method="POST" action="{{ route('user.reservations.store') }}">
                    @csrf
                    <input type="hidden" name="term_id" value="{{ $term->id }}">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Select Service <span class="text-red-500">*</span>
                        </label>
                        <select name="serv_id" required
                                class="w-full border rounded px-3 py-2 @error('serv_id') border-red-500 @enderror">
                            <option value="">-- Choose a service --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" @selected(old('serv_id') == $service->id)>
                                    {{ $service->name }}
                                    @if($service->price)
                                        - ${{ number_format($service->price, 2) }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('serv_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex gap-3">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Confirm Booking
                        </button>
                        <a href="{{ route('user.terms.index') }}"
                           class="px-4 py-2 border rounded hover:bg-gray-50">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
