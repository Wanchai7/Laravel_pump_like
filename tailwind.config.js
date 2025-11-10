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
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    '50': '#fdf2f8',
                    '100': '#fce7f3',
                    '200': '#fbcfe8',
                    '300': '#f9a8d4',
                    '400': '#f472b6',
                    '500': '#ec4899',
                    '600': '#db2777',
                    '700': '#be185d',
                    '800': '#9d174d',
                    '900': '#831843',
                    '950': '#500724',
                },
                secondary: {
                    '50': '#fdf4ff',
                    '100': '#fae8ff',
                    '200': '#f5d0fe',
                    '300': '#f0abfc',
                    '400': '#e879f9',
                    '500': '#d946ef',
                    '600': '#c026d3',
                    '700': '#a21caf',
                    '800': '#86198f',
                    '900': '#701a75',
                    '950': '#4a044e',
                },
                background: '#fdf2f8', // A very light pink
                textColor: '#1f2937', // A dark gray
            },
        },
    },

    plugins: [forms],
};
