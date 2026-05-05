import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                "surface-dim": "#ccdbf3",
                "on-tertiary-container": "#ffede6",
                "surface-bright": "#f8f9ff",
                "on-tertiary": "#ffffff",
                "on-error-container": "#93000a",
                "primary-fixed": "#dbe1ff",
                "on-primary-fixed": "#00174b",
                "inverse-on-surface": "#eaf1ff",
                "surface-tint": "#0053db",
                "primary": "#004ac6",
                "secondary-fixed": "#dbe1ff",
                "on-secondary-fixed": "#00174b",
                "tertiary-fixed": "#ffdbcd",
                "surface-container": "#e6eeff",
                "surface-container-lowest": "#ffffff",
                "on-primary-container": "#eeefff",
                "on-primary": "#ffffff",
                "background": "#f8f9ff",
                "on-background": "#0d1c2e",
                "on-tertiary-fixed": "#360f00",
                "on-secondary-container": "#394c84",
                "surface-container-high": "#dce9ff",
                "outline": "#737686",
                "inverse-surface": "#233144",
                "surface-container-low": "#eff4ff",
                "error": "#ba1a1a",
                "surface-variant": "#d5e3fc",
                "tertiary": "#943700",
                "secondary-container": "#acbfff",
                "on-secondary-fixed-variant": "#31447b",
                "primary-container": "#2563eb",
                "primary-fixed-dim": "#b4c5ff",
                "on-secondary": "#ffffff",
                "on-surface-variant": "#434655",
                "on-error": "#ffffff",
                "error-container": "#ffdad6",
                "secondary-fixed-dim": "#b4c5ff",
                "on-tertiary-fixed-variant": "#7d2d00",
                "inverse-primary": "#b4c5ff",
                "tertiary-container": "#bc4800",
                "on-surface": "#0d1c2e",
                "on-primary-fixed-variant": "#003ea8",
                "outline-variant": "#c3c6d7",
                "tertiary-fixed-dim": "#ffb596",
                "surface-container-highest": "#d5e3fc",
                "surface": "#f8f9ff",
                "secondary": "#495c95"
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                headline: ["Manrope"],
                body: ["Inter"],
                label: ["Inter"]
            },
        },
    },

    plugins: [forms],
};
