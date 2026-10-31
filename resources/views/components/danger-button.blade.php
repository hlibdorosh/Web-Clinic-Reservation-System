<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 h-9 px-4 rounded-lg text-sm font-medium bg-red-600 text-white border border-transparent cursor-pointer select-none transition-[background-color,transform] duration-150 ease-out hover:bg-red-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-600 focus-visible:ring-offset-2 active:scale-[0.98] disabled:opacity-50 disabled:pointer-events-none']) }}>
    {{ $slot }}
</button>
