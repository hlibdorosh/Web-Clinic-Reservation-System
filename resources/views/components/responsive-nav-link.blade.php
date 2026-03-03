@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full ps-3 pe-4 py-2.5 border-l-4 border-ocean-500 text-start text-base font-semibold text-ocean-700 bg-ocean-50 focus:outline-none focus:text-ocean-800 focus:bg-ocean-100 focus:border-ocean-600 rounded-r-lg transition duration-150 ease-in-out'
    : 'block w-full ps-3 pe-4 py-2.5 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-ocean-700 hover:bg-ocean-50 hover:border-ocean-300 focus:outline-none focus:text-ocean-700 focus:bg-ocean-50 focus:border-ocean-300 rounded-r-lg transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
