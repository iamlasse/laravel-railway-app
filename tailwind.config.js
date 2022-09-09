const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

module.exports = {
    // mode: process.env === "development" ? "jit" : "",
    darkMode: "class",
    purge: {
        content: [
            "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
            "./vendor/laravel/jetstream/**/*.blade.php",
            "./storage/framework/views/*.php",
            "./resources/views/**/*.blade.php",
            "./resources/**/*.blade.php",
            "./app/**/*.php",
            "./resources/**/*.html",
            "./resources/**/*.js",
            "./resources/**/*.jsx",
            "./resources/**/*.ts",
            "./resources/**/*.tsx",
            "./resources/**/*.php",
            "./resources/**/*.vue",
            "./resources/**/*.twig",
            "/app/**/*.php",

            // WireUI
            './vendor/wireui/wireui/resources/**/*.blade.php',
            './vendor/wireui/wireui/ts/**/*.ts',
            './vendor/wireui/wireui/src/View/**/*.php',

            './vendor/filament/**/*.blade.php',
            './vendor/wire-elements/modal/resources/views/*.blade.php',
        ],
        options: {
            safelist: [
                'sm:max-w-3xl'
            ]
        }
    },
    theme: {
        // colors: {

        // },
        extend: {
            opacity: ['disabled'],
            backgroundColor: ["active", 'disabled'],
            fontFamily: {
                //sans: ["Inter", ...defaultTheme.fontFamily.sans],
                sans: ["Inter var", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // ...colors,
                // transparent: 'transparent',
                // current: 'currentColor',
                // black: colors.black,
                // white: colors.white,
                // gray: colors.gray,
                // emerald: colors.emerald,
                rose: colors.rose,
                red: colors.red,
                indigo: colors.indigo,
                yellow: colors.yellow,
                pink: colors.pink,
                gray: colors.gray,
                dark: {
                    ...colors.indigo,
                    "eval-0": "#151823",
                    "eval-1": "#222738",
                    "eval-2": "#2A2F42",
                    "eval-3": "#2C3142",
                    // cyan: colors.cyan,
                },


                telekom: {
                    lightorange: '#FFE8DF',
                    darkorange: '#FFCAB6',
                    lightgreen: '#D8FFF9',
                    midgreen: '#AAFFEF',
                    darkgreen: '#4FF1D2',
                    // lightblue: '',
                    darkblue: '#272657',
                    pink: '#FFE8DF',
                    50: "#D2D7E7",
                    100: "#C3CBEC",
                    200: "#B0B9DC",
                    300: "#929DC9",
                    400: "#808BB6",
                    500: "#747FA8",
                    600: "#6F789B",
                    700: "#626B8B",
                    800: "#464C64",
                    900: "#181E37",
                },
                'tkblue': {
                    '50': '#B4B3DE',
                    '100': '#9F9DD4',
                    '200': '#7473C2',
                    '300': '#4D4BAC',
                    '400': '#3A3982',
                    '500': '#272657',
                    '600': '#22214C',
                    '700': '#1D1D42',
                    '800': '#191837',
                    '900': '#14132C'
                },
                'tkteal': {
                    '50': '#F9FFFD',
                    '100': '#E6FDF9',
                    '200': '#D8FFF9',
                    '300': '#9BF7E5',
                    '400': '#75F4DC',
                    '500': '#4FF1D2',
                    '600': '#1BEDC5',
                    '700': '#07CFA9',
                    '800': '#059378',
                    '900': '#035D4C'
                },
                'tkmint': {
                    '50': '#FFFFFF',
                    '100': '#FFFFFF',
                    '200': '#FFFFFF',
                    '300': '#FFFFFF',
                    '400': '#FFFFFF',
                    '500': '#D8FFF9',
                    '600': '#A0FFF0',
                    '700': '#68FFE8',
                    '800': '#30FFDF',
                    '900': '#00F7D1'
                },
                'tkorange': {
                    '50': '#FFFCFB',
                    '100': '#FFE8DF',
                    '200': '#FFEBE4',
                    '300': '#FFE0D5',
                    '400': '#FFD5C5',
                    '500': '#FFCAB6',
                    '600': '#FFA17E',
                    '700': '#FF7946',
                    '800': '#FF500E',
                    '900': '#D53A00'
                },

                warning: colors.yellow,
                danger: colors.rose,
                positive: colors.indigo,
                primary: {
                    '50': '#F9FFFD',
                    '100': '#E6FDF9',
                    '200': '#C0FAEF',
                    '300': '#9BF7E5',
                    '400': '#75F4DC',
                    '500': '#4FF1D2',
                    '600': '#1BEDC5',
                    '700': '#0FC09F',
                    '800': '#0B8D74',
                    '900': '#075949'
                },
                blue: {
                    '50': '#B4B3DE',
                    '100': '#9F9DD4',
                    '200': '#7473C2',
                    '300': '#4D4BAC',
                    '400': '#3A3982',
                    '500': '#272657',
                    '600': '#22214C',
                    '700': '#1D1D42',
                    '800': '#191837',
                    '900': '#14132C'
                }
            },
        },
    },
    variants: {
        opacity: ({
            after
        }) => after(['disabled'])
    },
    presets: [
        require('./vendor/wireui/wireui/tailwind.config.js')
    ],
    plugins: [
        // require("@tailwindcss/forms"),
        // require("@tailwindcss/typography"),
    ],
    stats: {
        children: true
    }
};
