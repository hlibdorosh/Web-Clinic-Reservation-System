@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full px-3 py-2 text-start text-sm font-medium text-ocean-700 bg-ink-50 rounded-lg focus:outline-none focus:bg-ink-100 transition-colors duration-150'
    : 'block w-full px-3 py-2 text-start text-sm font-medium text-ink-600 hover:text-ink-900 hover:bg-ink-50 focus:outline-none focus:bg-ink-50 rounded-lg transition-colors duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
