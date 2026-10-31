@props(['notifications'])

@php $unreadCount = $notifications->whereNull('read_at')->count(); @endphp

<div class="card">
    <div class="px-5 py-4 border-b border-line flex items-center justify-between">
        <h3 class="text-base font-medium text-ink-900">
            Notifications
            @if($unreadCount > 0)
                <span class="ml-2 text-xs font-normal text-ink-500 tabular-nums">{{ $unreadCount }} new</span>
            @endif
        </h3>
        @if($unreadCount > 0)
            <form method="POST" action="{{ route('notifications.markAllRead') }}">
                @csrf
                <button type="submit" class="text-sm text-ocean-700 hover:underline">
                    Mark all as read
                </button>
            </form>
        @endif
    </div>

    <div class="divide-y divide-line">
        @forelse($notifications as $notification)
            @php
                $data = $notification->data;
                $dotClass = match($data['type'] ?? '') {
                    'reservation_confirmed'         => 'bg-emerald-600',
                    'reservation_cancelled_patient',
                    'reservation_cancelled_doctor'  => 'bg-red-600',
                    'reservation_made'              => 'bg-amber-600',
                    default                         => 'bg-ink-400',
                };
            @endphp
            <div class="px-5 py-4 {{ is_null($notification->read_at) ? 'bg-ink-50' : '' }}">
                <div class="flex items-start gap-3">
                    <span class="mt-1.5 w-1.5 h-1.5 rounded-full shrink-0 {{ $dotClass }}"></span>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-ink-900">{{ $data['message'] ?? '' }}</p>

                        @if(!empty($data['date']))
                            <p class="mt-1 text-xs text-ink-500 tabular-nums">
                                {{ \Carbon\Carbon::parse($data['date'])->format('d M Y') }}
                                · {{ $data['start_time'] ?? '' }} – {{ $data['end_time'] ?? '' }}
                                @if(!empty($data['department']))· {{ $data['department'] }}@endif
                                @if(!empty($data['cabinet']))· Cabinet {{ $data['cabinet'] }}@endif
                                @if(!empty($data['service']))· {{ $data['service'] }}@endif
                            </p>
                        @endif
                    </div>

                    <span class="text-xs text-ink-500 whitespace-nowrap">
                        {{ $notification->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-ink-500 text-sm">
                No notifications yet
            </div>
        @endforelse
    </div>
</div>
