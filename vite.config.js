import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

// Arabic fonts must request the `arabic` subset explicitly. Without it the
// loader only downloads the Latin glyphs and every Arabic face silently falls
// back to the system font, making all selections look identical.
const ARABIC = ['arabic', 'latin'];
const LATIN = ['latin'];

// `preload: false` keeps the <head> light: each invitation only downloads the
// font it actually uses instead of preloading the whole library on every page.
const arabicFont = (family, weights = [400, 700]) =>
    bunny(family, { weights, subsets: ARABIC, preload: false });

const latinFont = (family, options = {}) =>
    bunny(family, { subsets: LATIN, preload: false, ...options });

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                arabicFont('Cairo', [400, 500, 600, 700, 800]),
                arabicFont('Tajawal', [300, 400, 500, 700]),
                arabicFont('Noto Naskh Arabic', [400, 500, 600, 700]),
                arabicFont('Amiri'),
                arabicFont('Scheherazade New'),
                arabicFont('Aref Ruqaa'),
                arabicFont('Reem Kufi'),
                arabicFont('Noto Kufi Arabic'),
                arabicFont('El Messiri'),
                arabicFont('Almarai'),
                arabicFont('Markazi Text'),
                arabicFont('Changa'),
                arabicFont('Alexandria'),
                arabicFont('Lalezar', [400]),
                arabicFont('Rakkas', [400]),
                arabicFont('Jomhuria', [400]),
                latinFont('Playfair Display', { weights: [400, 500, 600, 700], styles: ['normal', 'italic'] }),
                latinFont('Cormorant Garamond', { weights: [300, 400, 500, 600, 700], styles: ['normal', 'italic'] }),
                latinFont('Montserrat', { weights: [300, 400, 500, 600, 700] }),
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
