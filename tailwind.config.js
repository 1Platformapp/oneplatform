/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/**/**/*.blade.php",
    ],
    theme: {
        extend: {
            screens: {
                'xs2': '320px',
                'sm': '640px',
                'md': '768px',
            },
            boxShadow: {
                'custom': '0 0 13px #818181',
            },
            colors: {
                'theme-red': '#fc064c',
                'theme-blue': '#0c66e4',
                'input-b': 'rgb(230, 230, 230)',
                'main-icons': '#989898'
            },
            height: {
                '200': '12.5rem',
                '400': '25rem',
              },
        }
    },
    plugins: [],
}
