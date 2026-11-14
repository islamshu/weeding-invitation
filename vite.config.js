import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Cairo', { weights: [400, 500, 600, 700, 800] }),
                bunny('Tajawal', { weights: [300, 400, 500, 700] }),
                bunny('Noto Naskh Arabic', { weights: [400, 500, 600, 700] }),
                bunny('Playfair Display', { weights: [400, 500, 600, 700], styles: ['normal', 'italic'] }),
                bunny('Cormorant Garamond', { weights: [300, 400, 500, 600, 700], styles: ['normal', 'italic'] }),
                bunny('Montserrat', { weights: [300, 400, 500, 600, 700] }),
            ],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
