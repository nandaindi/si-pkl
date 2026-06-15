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
                sans: ['"DM Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#DB2777',
                secondary: '#F472B6',
                cta: '#CA8A04',
                background: '#FDF2F8',
                textMain: '#831843',
                glass: 'rgba(255, 255, 255, 0.8)',
            },
            boxShadow: {
                'glass': '0 8px 32px 0 rgba(219, 39, 119, 0.1)',
            }
        },
    },

    plugins: [forms],
};
