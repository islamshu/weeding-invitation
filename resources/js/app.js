import '../css/app.css';
import './i18n';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { locale, translate } from './i18n';

const appName = import.meta.env.VITE_APP_NAME || 'Dawati';

createInertiaApp({
    title: (title) => (title ? `${title} — ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.config.globalProperties.$t = (key, params = {}) => translate(key, locale.value, params);
        app.config.globalProperties.$locale = locale;
        app.config.globalProperties.$dir = () => (locale.value === 'ar' ? 'rtl' : 'ltr');

        return app.use(plugin).mount(el);
    },
    progress: {
        color: '#b08d57',
        showSpinner: false,
    },
});

// Restore scroll position on browser back/forward for a native feel.
window.addEventListener('popstate', () => {
    document.documentElement.classList.remove('overflow-hidden');
});
