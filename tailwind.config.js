const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    purge: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                orangered: {
                    light: "#ff906e",
                    DEFAULT: "orangered",
                    dark: "#ff5019",
                },
            },
            textColor: {
                primary: {
                    light: "#ff906e",
                    DEFAULT: "orangered",
                    dark: "#ff5019",
                },
                secondary: "#ffed4a",
                danger: "#e3342f",
            },
        },
    },

    variants: {
        extend: {
            opacity: ["disabled"],
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
