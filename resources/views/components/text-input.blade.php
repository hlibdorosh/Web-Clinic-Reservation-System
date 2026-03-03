@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-ocean-200 focus:border-ocean-500 focus:ring-ocean-400/40 rounded-lg shadow-sm bg-white text-gray-800 placeholder-gray-400 transition-all duration-150 disabled:bg-ocean-50 disabled:text-gray-500 disabled:cursor-not-allowed']) }}>
