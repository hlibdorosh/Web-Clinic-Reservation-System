@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center h-9 px-3 rounded-lg text-sm font-medium bg-ink-50 text-ocean-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-ocean-500 transition-colors duration-150'
    : 'inline-flex items-center h-9 px-3 rounded-lg text-sm font-medium text-ink-600 hover:bg-ink-50 hover:text-ink-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-ocean-500 transition-colors duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
