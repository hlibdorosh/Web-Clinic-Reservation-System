@props(['notifications'])

<div class="bg-white shadow sm:rounded-lg">
    <div class="p-4 border-b flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">
            Notifications
            @if($notifications->whereNull('read_at')->count() > 0)
                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    {{ $notifications->whereNull('read_at')->count() }} new
                </span>
            @endif
        </h3>
        @if($notifications->whereNull('read_at')->count() > 0)
            <form method="POST" action="{{ route('notifications.markAllRead') }}">
                @csrf
                <button type="submit" class="text-sm text-blue-600 hover:underline">
                    Mark all as read
                </button>
            </form>
        @endif
    </div>

    <div class="divide-y">
        @forelse($notifications as $notification)
            @php $data = $notification->data; @endphp
            <div class="p-4 {{ is_null($notification->read_at) ? 'bg-blue-50' : '' }}">
                <div class="flex items-start gap-3">
                    {{-- Icon by type --}}
                    @php
                        $iconClass = match($data['type'] ?? '') {
                            'reservation_made'             => 'bg-blue-100 text-blue-600',
                            'reservation_cancelled_patient'=> 'bg-orange-100 text-orange-600',
                            'reservation_confirmed'        => 'bg-green-100 text-green-600',
                            'reservation_cancelled_doctor' => 'bg-red-100 text-red-600',
                            'term_created'                 => 'bg-purple-100 text-purple-600',
                            default                        => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold {{ $iconClass }}">
                        @switch($data['type'] ?? '')
                            @case('reservation_made')             📋 @break
                            @case('reservation_cancelled_patient')✖️ @break
                            @case('reservation_confirmed')        ✔️ @break
                            @case('reservation_cancelled_doctor') ✖️ @break
                            @case('term_created')                 📅 @break
                            @default                              🔔
                        @endswitch
                    </span>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ $data['message'] ?? '' }}</p>

                        @if(!empty($data['date']))
                            <p class="mt-1 text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($data['date'])->format('d M Y') }}
                                · {{ $data['start_time'] ?? '' }} – {{ $data['end_time'] ?? '' }}
                                @if(!empty($data['department']))· {{ $data['department'] }}@endif
                                @if(!empty($data['cabinet']))· Cabinet {{ $data['cabinet'] }}@endif
                                @if(!empty($data['service']))· {{ $data['service'] }}@endif
                            </p>
                        @endif
                    </div>

                    <span class="text-xs text-gray-400 whitespace-nowrap">
                        {{ $notification->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-gray-400 text-sm">
                No notifications yet.
            </div>
        @endforelse
    </div>
</div>
