const defaultTheme = require("tailwindcss/defaultTheme");
const forms = require("@tailwindcss/forms");
const typography = require("@tailwindcss/typography");

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./resources/**/*.blade.php", "./resources/**/*.js", "./resources/**/*.vue"],
  theme: {
    extend: {},
  },
  theme: {
    extend: {
      fontFamily: {
        sans: ["Inter", ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: "#ef4444",
        secondary: "#3b82f6",
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'), // Pastikan baris ini ada jika memang digunakan
  ],
};
