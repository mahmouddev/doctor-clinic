import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'
import htmlPurge from 'vite-plugin-purgecss';

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel({
            input: [
              'resources/css/dashboard.css',
              'resources/js/dashboard.js',
              ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        
        
    ],
    build: {
        chunkSizeWarningLimit: 1600,
        rollupOptions: {}
    },

});