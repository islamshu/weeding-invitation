<script setup>
import { computed, watch } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Heart, Sparkles, Quote } from 'lucide-vue-next';
import { useI18n } from '../i18n';
import LanguageSwitcher from '../Components/LanguageSwitcher.vue';
import ToastHost from '../Components/ToastHost.vue';
import { toast } from '../utils/toast';

defineProps({
    title: { type: String, default: '' },
    subtitle: { type: String, default: '' },
});

const { t } = useI18n();
const page = usePage();

watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    },
    { immediate: true, deep: true }
);

const year = computed(() => new Date().getFullYear());
</script>

<template>
    <div class="app-bg flex min-h-screen flex-col">
        <header class="border-b border-champagne-200/50">
            <div class="container-page flex h-[68px] items-center justify-between">
                <Link href="/" class="group flex items-center gap-2.5">
                    <span class="relative flex size-10 items-center justify-center rounded-full border border-champagne-400/70 bg-white text-burgundy-600 shadow-sm">
                        <Heart class="size-4 fill-burgundy-600/10" />
                        <Sparkles class="absolute -end-1 -top-1 size-3 text-champagne-500" />
                    </span>
                    <span class="leading-none">
                        <span class="block text-xl font-semibold text-ink-900">{{ t('brand') }}</span>
                        <span class="mt-1 block text-[8px] font-bold tracking-[0.32em] text-champagne-600">{{ t('brand.latin') }}</span>
                    </span>
                </Link>
                <LanguageSwitcher />
            </div>
        </header>

        <main class="flex-1">
            <div class="container-page grid min-h-[calc(100vh-68px)] items-center gap-8 py-10 lg:grid-cols-[1.05fr_.95fr] lg:py-16">
                <div class="order-2 lg:order-1">
                    <div class="mx-auto w-full max-w-md">
                        <p class="eyebrow">{{ t('brand.tagline') }}</p>
                        <h1 class="luxury-title mt-3 text-3xl font-semibold sm:text-4xl">{{ title }}</h1>
                        <p class="mt-3 text-sm leading-7 text-ink-500">{{ subtitle }}</p>
                        <div class="mt-7">
                            <slot />
                        </div>
                    </div>
                </div>

                <div class="order-1 lg:order-2">
                    <slot name="aside">
                        <div class="relative mx-auto hidden max-w-md lg:block">
                            <div class="absolute -inset-4 rounded-[2.5rem] bg-champagne-200/30 blur-2xl" />
                            <div class="relative overflow-hidden rounded-[2rem] border border-champagne-200 bg-ivory-50 p-8 shadow-[0_40px_80px_-50px_rgba(61,44,21,.6)]">
                                <div class="absolute inset-3 rounded-[1.6rem] border border-champagne-300/60" />
                                <div class="relative flex flex-col items-center py-10 text-center">
                                    <div class="flex size-14 items-center justify-center rounded-full border border-champagne-400/70 text-burgundy-600">
                                        <Heart class="size-6" />
                                    </div>
                                    <p class="mt-6 text-2xl font-semibold text-burgundy-600">أحمد <span class="text-champagne-500">&</span> سارة</p>
                                    <div class="mt-4 flex items-center gap-3 text-champagne-500">
                                        <span class="h-px w-10 bg-champagne-300" />
                                        <Sparkles class="size-4" />
                                        <span class="h-px w-10 bg-champagne-300" />
                                    </div>
                                    <p class="mt-5 text-xs tracking-[0.25em] text-ink-500">دعوة زفاف</p>
                                    <p class="mt-2 text-[11px] text-ink-500">قاعة الياسمين · رام الله</p>
                                    <div class="mt-8 rounded-2xl bg-white/60 px-5 py-4">
                                        <Quote class="mx-auto size-4 text-champagne-500" />
                                        <p class="mt-2 text-sm leading-8 text-ink-700">حضوركم شرف لنا ويضيف لفرحتنا بهجة.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </slot>
                </div>
            </div>
        </main>

        <footer class="border-t border-champagne-200/50 py-5">
            <p class="text-center text-[11px] text-ink-500">© {{ year }} {{ t('brand') }} · {{ t('footer.rights') }}</p>
        </footer>

        <ToastHost />
    </div>
</template>
