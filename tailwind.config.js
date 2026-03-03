import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ocean: {
                    50:  '#f0fdff',
                    100: '#ccf7fe',
                    200: '#99edfc',
                    300: '#4dd9f5',
                    400: '#0fbedd',
                    500: '#03a2c1',
                    600: '#0582a3',
                    700: '#0a6884',
                    800: '#0f546b',
                    900: '#124659',
                    950: '#072d3d',
                },
            },
            boxShadow: {
                'ocean-sm': '0 2px 10px -1px rgba(5,130,163,0.12), 0 1px 4px -1px rgba(5,130,163,0.08)',
                'ocean':    '0 4px 20px -2px rgba(5,130,163,0.16), 0 2px 8px -2px rgba(5,130,163,0.10)',
                'ocean-lg': '0 8px 40px -4px rgba(5,130,163,0.22), 0 4px 16px -4px rgba(5,130,163,0.14)',
                'ocean-xl': '0 16px 60px -8px rgba(5,130,163,0.28), 0 8px 24px -6px rgba(5,130,163,0.18)',
            },
        },
    },

    plugins: [forms],
};
