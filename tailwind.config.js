import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            screens: {
                'xs': '480px',  // Extra small devices (phones, 480px and up)
                'sm': '640px',  // Small devices (landscape phones, 640px and up)
                'md': '768px',  // Medium devices (tablets, 768px and up)
                'lg': '1024px', // Large devices (desktops, 1024px and up)
                'xl': '1280px', // Extra large devices (large desktops, 1280px and up)
                '2xl': '1536px', // 2X large devices (larger desktops, 1536px and up)
            },
        },
    },
    plugins: [],
};
