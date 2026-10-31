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
                // Brand accent, from the clinic's existing ocean palette
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
                // Cool ink neutrals for every surface and every text role
                ink: {
                    50:  '#f5f7fa',
                    100: '#eceff4',
                    200: '#dfe4ec',
                    400: '#9aa3b2',
                    500: '#6b7487',
                    600: '#4b5565',
                    900: '#111827',
                },
            },
            borderColor: {
                // Hairlines: ink at low opacity
                line: 'rgba(17, 24, 39, 0.08)',
                'line-strong': 'rgba(17, 24, 39, 0.14)',
            },
        },
    },

    plugins: [forms],
};
