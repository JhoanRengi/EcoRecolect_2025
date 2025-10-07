import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    container: { center: true, padding: '1rem' },
    extend: {
      colors: {
        brand: { DEFAULT: '#2cb67d', 600: '#26a26f' },
        ink: '#0f172a',
        muted: '#64748b',
        surface: '#f5f7fb',
        line: '#e6eaf0',
      },
      boxShadow: {
        soft: '0 10px 30px rgba(15,23,42,.06)',
      },
      borderRadius: {
        xl2: '20px',
      },
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [forms],
}