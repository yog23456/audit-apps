/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './application/views/**/*.php',
    './application/controllers/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        navy: {
          DEFAULT: '#1e3a5f',
          dark: '#16304f',
        },
        brand: {
          DEFAULT: '#2f6fe0',
          light: '#eaf1fd',
          hover: '#2559bd',
        },
        stage: {
          green: '#1f8a4c',
          purple: '#5b3fa6',
          amber: '#f2994a',
          teal: '#0f9b8e',
          gray: '#8a94a6',
          orange: '#e8622c',
          red: '#e0432c',
        },
      },
      fontFamily: {
        sans: ['Inter', 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', 'sans-serif'],
      },
      borderRadius: {
        card: '12px',
      },
    },
  },
  plugins: [],
};