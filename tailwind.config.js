import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Fraunces', 'serif'],
                mono: ['JetBrains Mono', 'monospace'],
            },
            colors: {
                stone: {
                    50: '#fbf7ee',
                    100: '#f2ead7',
                    900: '#201a12',
                    950: '#171310',
                },
                bg: {
                    page: 'var(--bg-page)',
                    alt: 'var(--bg-alt)',
                    card: 'var(--bg-card)',
                    sidebar: 'var(--bg-sidebar)',
                },
                text: {
                    main: 'var(--text-main)',
                    muted: 'var(--text-muted)',
                    sidebar: 'var(--text-sidebar)',
                    'sidebar-muted': 'var(--text-sidebar-muted)',
                },
                border: 'var(--border-color)',
                accent: 'var(--accent-color)',
                success: 'var(--status-green)',
            },
        },
    },

    plugins: [forms],
};
