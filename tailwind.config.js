import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php", // This tells Tailwind to scan all your Blade files
    "./resources/**/*.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
