/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/**/*.blade.php",
    ],
    theme: {
        extend: {
            boxShadow: {
                'custom': '0 0 13px #818181',
            },
            colors: {
                'theme-red': '#fc064c',
            },
        }
    },
    plugins: [],
}
