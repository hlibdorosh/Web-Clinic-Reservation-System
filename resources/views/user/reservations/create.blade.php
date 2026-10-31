<x-app-layout>
    <x-slot name="header">
        <h2>
            Book appointment
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-5 sm:p-6">

                {{-- Term Details --}}
                <div class="mb-6 pb-6 border-b border-line">
                    <h3 class="text-base font-medium text-ink-900 mb-3">Appointment details</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-ink-500">Date:</span>
                            <span class="font-medium text-ink-900 tabular-nums">{{ optional($term->date)->format('Y-m-d') ?? $term->date }}</span>
                        </div>
                        <div>
                            <span class="text-ink-500">Time:</span>
                            <span class="font-medium text-ink-900 tabular-nums">{{ $term->start_time }} - {{ $term->end_time }}</span>
                        </div>
                        <div>
                            <span class="text-ink-500">Doctor:</span>
                            <span class="font-medium text-ink-900">{{ $term->doctor?->name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-ink-500">Department:</span>
                            <span class="font-medium text-ink-900">{{ $term->department?->name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-ink-500">Cabinet:</span>
                            <span class="font-medium text-ink-900">{{ $term->cabinet?->number ?? $term->cab_id }}</span>
                        </div>
                        @if($term->desc)
                            <div class="col-span-2">
                                <span class="text-ink-500">Note:</span>
                                <span class="font-medium text-ink-900">{{ $term->desc }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Booking Form --}}
                <form method="POST" action="{{ route('user.reservations.store') }}">
                    @csrf
                    <input type="hidden" name="term_id" value="{{ $term->id }}">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-ink-900 mb-2">
                            Select service <span class="text-red-600">*</span>
                        </label>
                        <select name="serv_id" required
                                class="input w-full @error('serv_id') border-red-600 @enderror">
                            <option value="">Choose a service</option>
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
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if(session('error'))
                        <div class="alert-error mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex gap-3">
                        <button type="submit" class="btn">
                            Confirm booking
                        </button>
                        <a href="{{ route('user.terms.index') }}" class="btn btn-outline">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
