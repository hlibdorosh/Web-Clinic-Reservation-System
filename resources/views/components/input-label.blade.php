@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-ocean-800 mb-0.5']) }}>
    {{ $value ?? $slot }}
</label>
