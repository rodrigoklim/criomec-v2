import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.vue",
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ["Poppins Regular", ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: "#2f529a",
        secondary: "#26a69a",
        accent: "#9c27b0",
        dark: "#1d1d1d",
        "dark-page": "#121212",
        positive: "#21ba45",
        negative: "#c10015",
        info: "#31ccec",
        warning: "#f2c037",
      },
    },
    screens: {
      sm: "640px", // => @media (min-width: 640px) { ... }

      md: "768px", // => @media (min-width: 768px) { ... }

      lg: "1024px", // => @media (min-width: 1024px) { ... }

      xl: "1280px", // => @media (min-width: 1280px) { ... }

      "2xl": "1536px", // => @media (min-width: 1536px) { ... }
    },
  },

  plugins: [forms],
};
