import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/sass/app.scss", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        outDir: "public/build",
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `$enable-shadows: true;`,
            },
        },
    },
});
