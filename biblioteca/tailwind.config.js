module.exports = {
  content: ['frontend/views/**/*.{php,html}', 'common/widgets/**/*.php'],
  theme: {
    extend: {
      colors: {
        primary: '#3B82F6',          // azul bibliotech
        'sidebar-bg': '#f8f9fa',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('tailwindcss-gradients'),
  ],
}
