import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";

/* if you're using React */
// import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        /* react(), // if you're using React */
        symfonyPlugin({
            publicDirectory: './public',
            buildDirectory: 'build',
            servePublic: false,
        }),
    ],
    build: {
        minify: process.env.NODE_ENV === 'production',
        outDir: './public/build',
        rollupOptions: {
            input: {
                app: "./assets/app.js"
            },
        }
    },
    optimizeDeps: {
        include: process.env.NODE_ENV === 'production' ? [] : ['tailwindcss'],
    },
});