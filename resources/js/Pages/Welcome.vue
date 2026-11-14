<script setup>
import { computed, ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Check,
    Crown,
    Flower2,
    Globe2,
    Heart,
    Languages,
    Palette,
    Share2,
    Sparkles,
    Users,
} from 'lucide-vue-next';
import BaseButton from '../Components/BaseButton.vue';
import LanguageSwitcher from '../Components/LanguageSwitcher.vue';
import TemplateThumb from '../Components/TemplateThumb.vue';
import { getTemplate, templateCategories, templates } from '../data/templates';
import { useI18n } from '../i18n';

const page = usePage();
const { t, locale } = useI18n();

const user = computed(() => page.props.auth?.user ?? null);
const activeCategory = ref('all');
const filteredTemplates = computed(() =>
    activeCategory.value === 'all'
        ? templates
        : templates.filter((template) => template.category === activeCategory.value)
);

const featured = computed(() => [
    getTemplate('traditional_palestinian'),
    getTemplate('black_gold'),
    getTemplate('romantic_floral'),
]);

const features = computed(() => [
    { icon: Sparkles, title: t('home.feature1Title'), desc: t('home.feature1Desc'), tone: 'bg-champagne-100 text-champagne-700' },
    { icon: Crown, title: t('home.feature2Title'), desc: t('home.feature2Desc'), tone: 'bg-amber-100 text-amber-800' },
    { icon: Users, title: t('home.feature3Title'), desc: t('home.feature3Desc'), tone: 'bg-burgundy-600/10 text-burgundy-600' },
    { icon: Languages, title: t('home.feature4Title'), desc: t('home.feature4Desc'), tone: 'bg-emerald-100 text-emerald-700' },
    { icon: Share2, title: t('home.feature5Title'), desc: t('home.feature5Desc'), tone: 'bg-sky-100 text-sky-700' },
    { icon: Palette, title: t('home.feature6Title'), desc: t('home.feature6Desc'), tone: 'bg-rose-100 text-rose-700' },
]);

const steps = computed(() => [
    { n: '01', title: t('home.how1Title'), desc: t('home.how1Desc'), icon: Heart },
    { n: '02', title: t('home.how2Title'), desc: t('home.how2Desc'), icon: Palette },
    { n: '03', title: t('home.how3Title'), desc: t('home.how3Desc'), icon: Share2 },
]);

const categoryName = (category) => (locale.value === 'ar' ? category.name_ar : category.name_en);
const sampleGroom = computed(() => (locale.value === 'ar' ? 'أحمد' : 'Ahmad'));
const sampleBride = computed(() => (locale.value === 'ar' ? 'سارة' : 'Sara'));
</script>

<template>
    <Head>
        <title>{{ t('brand') }} — {{ t('home.title') }} {{ t('home.titleAccent') }}</title>
        <meta name="description" :content="t('home.description')" />
        <meta property="og:type" content="website" />
        <meta property="og:title" :content="`${t('brand')} — ${t('home.title')} ${t('home.titleAccent')}`" />
        <meta property="og:description" :content="t('home.description')" />
        <meta property="og:locale" :content="locale === 'ar' ? 'ar_AR' : 'en_US'" />
    </Head>

    <div class="app-bg min-h-screen">
        <!-- Header -->
        <header class="sticky top-0 z-50 border-b border-champagne-200/50 bg-ivory-100/80 backdrop-blur-xl">
            <div class="container-page flex h-[68px] items-center justify-between gap-4">
                <Link href="/" class="group flex items-center gap-2.5">
                    <span class="relative flex size-10 items-center justify-center rounded-full border border-champagne-400/70 bg-white text-burgundy-600 shadow-sm">
                        <Heart class="size-4 fill-burgundy-600/10" />
                        <Sparkles class="absolute -end-1 -top-1 size-3 text-champagne-500" />
                    </span>
                    <span class="leading-none">
                        <span class="block font-serif text-xl font-semibold tracking-wide text-ink-900">{{ t('brand') }}</span>
                        <span class="mt-1 block text-[8px] font-bold tracking-[0.32em] text-champagne-600">{{ t('brand.latin') }}</span>
                    </span>
                </Link>

                <nav class="hidden items-center gap-1 md:flex">
                    <a href="#features" class="rounded-full px-4 py-2 text-sm font-semibold text-ink-600 transition hover:bg-white/70 hover:text-ink-900">{{ t('nav.features') }}</a>
                    <a href="#templates" class="rounded-full px-4 py-2 text-sm font-semibold text-ink-600 transition hover:bg-white/70 hover:text-ink-900">{{ t('nav.templates') }}</a>
                    <a href="#how" class="rounded-full px-4 py-2 text-sm font-semibold text-ink-600 transition hover:bg-white/70 hover:text-ink-900">{{ t('home.howTitle') }}</a>
                </nav>

                <div class="flex items-center gap-2">
                    <LanguageSwitcher class="hidden sm:inline-flex" />
                    <template v-if="user">
                        <BaseButton href="/dashboard" size="sm">
                            {{ t('nav.dashboard') }}
                            <ArrowLeft class="size-3.5 rotate-180 rtl:rotate-0" />
                        </BaseButton>
                    </template>
                    <template v-else>
                        <Link
                            href="/login"
                            class="hidden rounded-full px-4 py-2 text-sm font-semibold text-ink-600 transition hover:text-ink-900 sm:inline-flex"
                        >
                            {{ t('common.login') }}
                        </Link>
                        <BaseButton href="/register" size="sm">
                            {{ t('common.register') }}
                        </BaseButton>
                    </template>
                </div>
            </div>
        </header>

        <main>
            <!-- Hero -->
            <section class="relative overflow-hidden">
                <div class="pointer-events-none absolute -end-40 -top-48 size-[30rem] rounded-full bg-champagne-200/30 blur-3xl" />
                <div class="pointer-events-none absolute -start-40 top-1/3 size-[26rem] rounded-full bg-burgundy-500/5 blur-3xl" />

                <div class="container-page relative grid items-center gap-10 py-14 lg:grid-cols-[1.02fr_.98fr] lg:py-24">
                    <div class="order-2 text-center lg:order-1 lg:text-start">
                        <span class="inline-flex items-center gap-2 rounded-full border border-champagne-300/70 bg-white/60 px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.2em] text-champagne-700 backdrop-blur">
                            <Sparkles class="size-3.5" />
                            {{ t('home.eyebrow') }}
                        </span>

                        <h1 class="luxury-title mt-5 text-4xl font-semibold leading-[1.18] sm:text-5xl lg:text-[3.75rem]">
                            {{ t('home.title') }}
                            <span class="relative mt-1 block text-burgundy-600">
                                {{ t('home.titleAccent') }}
                                <span class="absolute -bottom-2 start-1/2 h-px w-32 -translate-x-1/2 bg-gradient-to-r from-transparent via-champagne-400 to-transparent rtl:translate-x-1/2" />
                            </span>
                        </h1>

                        <p class="mx-auto mt-6 max-w-xl text-sm leading-8 text-ink-500 sm:text-base lg:mx-0">
                            {{ t('home.description') }}
                        </p>

                        <div class="mt-8 flex flex-wrap items-center justify-center gap-2.5 lg:justify-start">
                            <BaseButton :href="user ? '/invitations/create' : '/register'" size="lg">
                                {{ t('home.ctaPrimary') }}
                                <ArrowLeft class="size-4 rotate-180 rtl:rotate-0" />
                            </BaseButton>
                            <BaseButton href="#templates" variant="secondary" size="lg">
                                <Flower2 class="size-4 text-champagne-600" />
                                {{ t('home.ctaSecondary') }}
                            </BaseButton>
                        </div>

                        <div class="mt-7 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-[11px] font-semibold text-ink-500 lg:justify-start">
                            <span class="inline-flex items-center gap-1.5"><Check class="size-3.5 text-emerald-600" /> {{ t('home.statTemplates', { count: templates.length }) }}</span>
                            <span class="inline-flex items-center gap-1.5"><Check class="size-3.5 text-emerald-600" /> {{ t('home.statLanguages') }}</span>
                            <span class="inline-flex items-center gap-1.5"><Check class="size-3.5 text-emerald-600" /> {{ t('home.statLink') }}</span>
                        </div>

                        <p v-if="!user" class="mt-5 inline-flex items-center gap-1.5 rounded-full bg-white/60 px-3 py-1.5 text-[10px] text-ink-500">
                            <Sparkles class="size-3 text-champagne-600" />
                            {{ t('home.demoNote') }}
                        </p>
                    </div>

                    <!-- Layered template showcase -->
                    <div class="order-1 lg:order-2">
                        <div class="relative mx-auto h-[370px] w-full max-w-[410px] sm:h-[430px]">
                            <div class="absolute inset-x-8 bottom-0 h-40 rounded-full bg-champagne-300/25 blur-3xl" />

                            <div class="absolute start-0 top-8 w-[52%] rotate-[-8deg] overflow-hidden rounded-[1.3rem] border border-white/80 shadow-2xl shadow-ink-900/15 transition duration-500 hover:rotate-[-4deg]">
                                <div class="h-64 sm:h-72">
                                    <TemplateThumb :template="featured[1]" :groom="sampleGroom" :bride="sampleBride" :lang="locale" />
                                </div>
                            </div>

                            <div class="absolute end-0 top-3 w-[52%] rotate-[7deg] overflow-hidden rounded-[1.3rem] border border-white/80 shadow-2xl shadow-ink-900/15 transition duration-500 hover:rotate-[3deg]">
                                <div class="h-64 sm:h-72">
                                    <TemplateThumb :template="featured[2]" :groom="sampleGroom" :bride="sampleBride" :lang="locale" />
                                </div>
                            </div>

                            <div class="absolute start-1/2 top-20 z-10 w-[58%] -translate-x-1/2 overflow-hidden rounded-[1.5rem] border border-white/90 shadow-[0_35px_80px_-30px_rgba(61,44,21,.55)] transition duration-500 hover:-translate-y-1 hover:-translate-x-1/2 rtl:translate-x-1/2 rtl:hover:translate-x-1/2">
                                <div class="h-80 sm:h-[22rem]">
                                    <TemplateThumb :template="featured[0]" :groom="sampleGroom" :bride="sampleBride" :lang="locale" />
                                </div>
                            </div>

                            <div class="absolute -bottom-1 start-1/2 z-20 -translate-x-1/2 rtl:translate-x-1/2">
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-white/80 bg-white/90 px-3.5 py-2 text-[10px] font-bold text-ink-700 shadow-lg backdrop-blur">
                                    <Sparkles class="size-3 text-champagne-600" />
                                    {{ t('home.templatePreview') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Feature strip -->
            <section id="features" class="border-y border-champagne-200/50 bg-white/35 py-14 sm:py-20">
                <div class="container-page">
                    <div class="mx-auto max-w-2xl text-center">
                        <p class="eyebrow">{{ t('nav.features') }}</p>
                        <h2 class="luxury-title mt-2.5 text-2xl font-semibold sm:text-3xl">{{ t('home.featuresTitle') }}</h2>
                        <p class="mt-3 text-sm leading-7 text-ink-500">{{ t('home.featuresDescription') }}</p>
                    </div>

                    <div class="mt-9 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        <article
                            v-for="feature in features"
                            :key="feature.title"
                            class="group rounded-[1.4rem] border border-champagne-200 bg-white/70 p-5 transition duration-300 hover:-translate-y-1 hover:border-champagne-300 hover:shadow-[0_24px_50px_-38px_rgba(61,44,21,.55)]"
                        >
                            <span class="inline-flex size-10 items-center justify-center rounded-xl" :class="feature.tone">
                                <component :is="feature.icon" class="size-5" />
                            </span>
                            <h3 class="mt-4 font-serif text-lg font-semibold text-ink-900">{{ feature.title }}</h3>
                            <p class="mt-2 text-xs leading-7 text-ink-500">{{ feature.desc }}</p>
                        </article>
                    </div>
                </div>
            </section>

            <!-- Templates -->
            <section id="templates" class="py-14 sm:py-20">
                <div class="container-page">
                    <div class="mx-auto max-w-2xl text-center">
                        <p class="eyebrow">{{ t('nav.templates') }}</p>
                        <h2 class="luxury-title mt-2.5 text-2xl font-semibold sm:text-3xl">{{ t('home.templatesTitle') }}</h2>
                        <p class="mt-3 text-sm leading-7 text-ink-500">{{ t('home.templatesDescription') }}</p>
                    </div>

                    <div class="mt-6 flex flex-wrap justify-center gap-1.5">
                        <button
                            v-for="category in templateCategories"
                            :key="category.key"
                            type="button"
                            class="rounded-full border px-3.5 py-2 text-[11px] font-bold transition"
                            :class="activeCategory === category.key
                                ? 'border-burgundy-600 bg-burgundy-600 text-ivory-50 shadow-sm'
                                : 'border-champagne-200 bg-white/60 text-ink-600 hover:border-champagne-400'"
                            @click="activeCategory = category.key"
                        >
                            {{ categoryName(category) }}
                        </button>
                    </div>

                    <TransitionGroup
                        tag="div"
                        name="section"
                        class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4"
                    >
                        <article
                            v-for="template in filteredTemplates"
                            :key="template.key"
                            class="group min-w-0 overflow-hidden rounded-2xl border border-champagne-200 bg-white/60 transition duration-300 hover:-translate-y-1 hover:shadow-[0_22px_45px_-36px_rgba(61,44,21,.6)]"
                        >
                            <div class="h-44 sm:h-52">
                                <TemplateThumb
                                    :template="template"
                                    :groom="sampleGroom"
                                    :bride="sampleBride"
                                    :lang="locale"
                                    rounded="rounded-none"
                                    :show-name="false"
                                />
                            </div>
                            <div class="p-3">
                                <p class="truncate text-[11px] font-bold text-ink-900">{{ locale === 'ar' ? template.name_ar : template.name_en }}</p>
                                <p class="mt-0.5 line-clamp-2 text-[9px] leading-4 text-ink-500">{{ locale === 'ar' ? template.description_ar : template.description_en }}</p>
                            </div>
                        </article>
                    </TransitionGroup>
                </div>
            </section>

            <!-- How it works -->
            <section id="how" class="border-y border-champagne-200/50 bg-ivory-200/35 py-14 sm:py-20">
                <div class="container-page">
                    <div class="mx-auto max-w-2xl text-center">
                        <p class="eyebrow">{{ t('home.howTitle') }}</p>
                        <h2 class="luxury-title mt-2.5 text-2xl font-semibold sm:text-3xl">{{ t('home.howTitle') }}</h2>
                    </div>

                    <div class="mt-9 grid gap-3 md:grid-cols-3">
                        <article
                            v-for="(step, index) in steps"
                            :key="step.n"
                            class="relative overflow-hidden rounded-[1.4rem] border border-champagne-200 bg-white/70 p-6"
                        >
                            <span class="absolute -end-2 -top-5 font-serif text-7xl font-semibold text-champagne-200/70">{{ step.n }}</span>
                            <span class="relative inline-flex size-10 items-center justify-center rounded-xl bg-champagne-100 text-champagne-700">
                                <component :is="step.icon" class="size-5" />
                            </span>
                            <h3 class="relative mt-4 font-serif text-lg font-semibold text-ink-900">{{ step.title }}</h3>
                            <p class="relative mt-2 text-xs leading-7 text-ink-500">{{ step.desc }}</p>
                            <span v-if="index < steps.length - 1" class="absolute end-4 top-1/2 hidden size-7 -translate-y-1/2 items-center justify-center rounded-full border border-champagne-200 bg-ivory-50 text-champagne-600 md:flex">
                                <ArrowLeft class="size-3.5 rotate-180 rtl:rotate-0" />
                            </span>
                        </article>
                    </div>
                </div>
            </section>

            <!-- Final CTA -->
            <section class="py-14 sm:py-20">
                <div class="container-page">
                    <div class="relative overflow-hidden rounded-[2rem] bg-burgundy-600 px-6 py-14 text-center text-ivory-50 shadow-[0_45px_90px_-50px_rgba(87,24,39,.9)] sm:px-12">
                        <div class="pointer-events-none absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 0%, #e8d3a2 0, transparent 35%), radial-gradient(circle at 85% 100%, #c9a86a 0, transparent 40%);" />
                        <div class="pointer-events-none absolute inset-3 rounded-[1.6rem] border border-champagne-300/30" />
                        <div class="relative">
                            <Sparkles class="mx-auto size-6 text-champagne-300" />
                            <h2 class="mt-4 font-serif text-2xl font-semibold sm:text-4xl">{{ t('home.finalTitle') }}</h2>
                            <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-ivory-100/80">{{ t('home.finalDescription') }}</p>
                            <BaseButton :href="user ? '/invitations/create' : '/register'" variant="gold" size="lg" class="mt-7">
                                {{ t('home.ctaPrimary') }}
                                <ArrowLeft class="size-4 rotate-180 rtl:rotate-0" />
                            </BaseButton>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-champagne-200/60 py-7">
            <div class="container-page flex flex-col items-center justify-between gap-3 text-xs text-ink-500 sm:flex-row">
                <p class="inline-flex items-center gap-1.5">
                    <Heart class="size-3.5 text-burgundy-500" />
                    {{ t('home.footer') }}
                </p>
                <div class="flex items-center gap-4">
                    <Link href="/login" class="transition hover:text-ink-900">{{ t('common.login') }}</Link>
                    <Link href="/register" class="font-semibold text-burgundy-600 transition hover:underline">{{ t('common.register') }}</Link>
                    <span>© {{ new Date().getFullYear() }}</span>
                </div>
            </div>
        </footer>
    </div>
</template>
