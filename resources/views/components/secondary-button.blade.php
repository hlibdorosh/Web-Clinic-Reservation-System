<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn-outline disabled:opacity-50 disabled:pointer-events-none']) }}>
    {{ $slot }}
</button>
