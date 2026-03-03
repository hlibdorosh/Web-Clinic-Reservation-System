@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-3 pt-1 pb-0.5 border-b-2 border-ocean-500 text-sm font-semibold leading-5 text-ocean-700 focus:outline-none focus:border-ocean-600 transition duration-150 ease-in-out'
    : 'inline-flex items-center px-3 pt-1 pb-0.5 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-ocean-600 hover:border-ocean-300 focus:outline-none focus:text-ocean-600 focus:border-ocean-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
