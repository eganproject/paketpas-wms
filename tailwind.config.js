import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import plugin from 'tailwindcss/plugin';

/*
 * Token desain mengikuti panel admin wmsxshopee: abu-abu netral tanpa rona,
 * teks 14px, kontrol 32px, sudut 8px, kartu bergaris tepi tipis tanpa
 * bayangan. Warna status memakai palet bawaan Tailwind (emerald, rose,
 * amber, sky) seperti wmsxshopee.
 *
 * Palet `ink` tetap dipakai di seluruh view, jadi cukup nilainya yang
 * diganti. `brand` diambil dari kuning amber logo Paketpas (#F5B301) dan dipakai hemat:
 * garis tab aktif, bar progres, dan pilihan filter yang aktif.
 */
const gray = {
    50: '#f8f8f8',
    100: '#efefef',
    200: '#e2e2e2',
    300: '#c7c7c7',
    400: '#999999',
    500: '#7c7c7c',
    600: '#636363',
    700: '#525252',
    800: '#383838',
    900: '#262626',
    950: '#171717',
};

const brand = {
    50: '#fffbea',
    100: '#fff3c4',
    200: '#ffe58a',
    300: '#ffd54f',
    400: '#ffc61f',
    500: '#f5b301',
    600: '#b07800',
    700: '#8a5c00',
    800: '#6e4a06',
    900: '#5c3d0a',
    950: '#352102',
};

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './app/View/**/*.php',
        './app/Support/**/*.php',
        './app/Models/**/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter Variable', 'InterVariable', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ink: gray,
                gray,
                brand,
                control: '#efefef',
            },
            borderRadius: {
                xl: '12px',
                '2xl': '12px',
                '3xl': '12px',
            },
            boxShadow: {
                soft: 'none',
                card: 'none',
                lift: '0 10px 24px -6px rgb(0 0 0 / 0.12), 0 2px 6px -2px rgb(0 0 0 / 0.06)',
            },
            spacing: {
                navbar: '48px',
                sidebar: '240px',
            },
            keyframes: {
                'fade-in': {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                'slide-in': {
                    '0%': { opacity: '0', transform: 'translateX(8px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
            },
            animation: {
                'fade-in': 'fade-in .15s ease-out both',
                'slide-in': 'slide-in .2s ease-out both',
            },
        },
    },

    plugins: [
        forms,
        // Sidebar diciutkan jadi ikon saja: kelas `.sidebar-collapsed` di <html>, dipakai bersama lg:.
        plugin(({ addVariant }) => addVariant('collapsed', ':where(.sidebar-collapsed) &')),
    ],
};
