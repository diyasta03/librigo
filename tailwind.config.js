import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // Gabungkan semua path content dari kedua blok sebelumnya
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        // Jika Anda punya file JS/Vue di resources yang juga perlu dipindai Tailwind:
        // "./resources/**/*.js",
        // "./resources/**/*.vue",
    ],

    // PENTING: Kontrol Dark Mode di sini
    // Opsi 1: Nonaktifkan Dark Mode sepenuhnya (jika Anda tidak ingin dark/light mode)
    // darkMode: false,
    // Opsi 2: Kontrol Dark Mode secara manual dengan class 'dark' di HTML (disarankan untuk kontrol penuh)
    darkMode: 'class', 

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    // Gabungkan semua plugin
    plugins: [forms],
};