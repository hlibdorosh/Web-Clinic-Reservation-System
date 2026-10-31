@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'text-sm text-ink-600']) }}>
        {{ $status }}
    </div>
@endif
