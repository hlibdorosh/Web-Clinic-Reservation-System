<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-sm cursor-pointer select-none transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-ocean-400 focus:ring-offset-2 active:translate-y-px disabled:opacity-50 disabled:cursor-not-allowed']) }}
     style="background: linear-gradient(135deg, #0582a3 0%, #0a6884 100%);"
     onmouseover="if(!this.disabled) this.style.background='linear-gradient(135deg,#03a2c1 0%,#0582a3 100%)'"
     onmouseout="if(!this.disabled) this.style.background='linear-gradient(135deg,#0582a3 0%,#0a6884 100%)'">
    {{ $slot }}
</button>
