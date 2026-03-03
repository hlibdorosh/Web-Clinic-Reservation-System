<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center gap-1.5 px-5 py-2.5 bg-white border-2 border-ocean-300 rounded-lg font-semibold text-xs text-ocean-700 uppercase tracking-widest shadow-sm hover:bg-ocean-50 hover:border-ocean-400 hover:text-ocean-800 focus:outline-none focus:ring-2 focus:ring-ocean-400 focus:ring-offset-2 active:bg-ocean-100 disabled:opacity-25 disabled:cursor-not-allowed transition-all duration-150 ease-in-out']) }}>
    {{ $slot }}
</button>
