@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-ink-900 mb-1']) }}>
    {{ $value ?? $slot }}
</label>
