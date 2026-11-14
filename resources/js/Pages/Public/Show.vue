<script setup>
import { computed, onUnmounted, ref, watchEffect } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { CalendarPlus, Copy, Languages, MapPin, Share2, Sparkles } from 'lucide-vue-next';
import InvitationExperience from '../../Components/InvitationExperience.vue';
import ShareInvitation from '../../Components/ShareInvitation.vue';
import Modal from '../../Components/Modal.vue';
import ToastHost from '../../Components/ToastHost.vue';
import MusicToggle from '../../Components/MusicToggle.vue';
import { buildView } from '../../utils/invitation';
import { translate, useI18n } from '../../i18n';
import { toast } from '../../utils/toast';

const page = usePage();
const { locale } = useI18n();

const invitation = computed(() => page.props.invitation);
const meta = computed(() => page.props.meta ?? {});
const englishEnabled = computed(() => Boolean(invitation.value?.enable_english));

const lang = ref(locale.value === 'en' && invitation.value?.enable_english ? 'en' : 'ar');
const opened = ref(false);
const shareOpen = ref(false);

const t = (key, params = {}) => translate(key, lang.value, params);
const view = computed(() => buildView(invitation.value, lang.value));
const dir = computed(() => (lang.value === 'ar' ? 'rtl' : 'ltr'));

const initialHtmlLang = typeof document !== 'undefined' ? document.documentElement.lang : 'ar';
const initialHtmlDir = typeof document !== 'undefined' ? document.documentElement.dir : 'rtl';

// Guests can switch the invitation language without reloading the page, so
// keep the document language/direction in sync for layout, fonts and a11y.
watchEffect(() => {
    if (typeof document === 'undefined') return;
    document.documentElement.lang = lang.value;
    document.documentElement.dir = dir.value;
});

onUnmounted(() => {
    if (typeof document === 'undefined') return;
    document.documentElement.lang = initialHtmlLang;
    document.documentElement.dir = initialHtmlDir;
});

const publicUrl = computed(() => {
    if (invitation.value?.public_url) return invitation.value.public_url;
    if (typeof window !== 'undefined') return window.location.href;
    return '';
});

const shareText = computed(() =>
    t('public.shareText', {
        groom: view.value.couple.groom,
        bride: view.value.couple.bride,
    })
);

const shareTitle = computed(() =>
    lang.value === 'en'
        ? t('public.og.title', { groom: view.value.couple.groom, bride: view.value.couple.bride })
        : (meta.value.title ?? t('public.weddingInvitation'))
);

const shareDescription = computed(() => {
    if (lang.value !== 'en') return meta.value.description;

    return [
        t('public.og.title', { groom: view.value.couple.groom, bride: view.value.couple.bride }),
        view.value.event.dateFormatted,
        view.value.event.venueName,
        t('public.guestNote'),
    ].filter(Boolean).join(' — ');
});

function toggleLanguage() {
    lang.value = lang.value === 'ar' ? 'en' : 'ar';
}

async function copyLink() {
    try {
        if (navigator.clipboard?.writeText) {
            await navigator.clipboard.writeText(publicUrl.value);
        } else {
            const area = document.createElement('textarea');
            area.value = publicUrl.value;
            area.setAttribute('readonly', '');
            area.style.position = 'fixed';
            area.style.opacity = '0';
            document.body.appendChild(area);
            area.select();
            document.execCommand('copy');
            document.body.removeChild(area);
        }
        toast.success(t('public.linkCopied'));
    } catch {
        toast.error(t('public.copyFailed'));
    }
}
</script>

<template>
    <Head>
        <title>{{ shareTitle }}</title>
        <meta name="description" :content="shareDescription" />
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="Dawati" />
        <meta property="og:title" :content="shareTitle" />
        <meta property="og:description" :content="shareDescription" />
        <meta property="og:url" :content="meta.url" />
        <meta property="og:locale" :content="lang === 'en' ? 'en_US' : (meta.locale ?? 'ar_AR')" />
        <meta v-if="lang === 'en'" property="og:locale:alternate" content="ar_AR" />
        <meta v-if="lang !== 'en'" property="og:locale:alternate" content="en_US" />
        <meta name="twitter:card" :content="meta.image ? 'summary_large_image' : 'summary'" />
        <meta name="twitter:site" content="@dawati" />
        <meta name="twitter:title" :content="shareTitle" />
        <meta name="twitter:description" :content="shareDescription" />
        <meta v-if="meta.image" property="og:image" :content="meta.image" />
        <meta v-if="meta.image" property="og:image:secure_url" :content="meta.image" />
        <meta v-if="meta.image" property="og:image:alt" :content="shareTitle" />
        <meta v-if="meta.image" property="og:image:width" content="1200" />
        <meta v-if="meta.image" property="og:image:height" content="630" />
        <meta v-if="meta.image" name="twitter:image" :content="meta.image" />
        <meta name="theme-color" content="#6d1f33" />
        <link rel="canonical" :href="meta.url" />
    </Head>

    <div class="relative min-h-screen bg-ivory-100">
        <!-- Floating guest bar -->
        <header class="pointer-events-none fixed inset-x-0 top-0 z-40 flex justify-center px-3 pt-3 sm:pt-5">
            <div
                class="pointer-events-auto flex w-full max-w-xl items-center justify-between gap-3 rounded-full border border-white/50 bg-white/70 px-3 py-2 shadow-[0_18px_40px_-28px_rgba(36,31,25,.55)] backdrop-blur-xl sm:px-4"
                :dir="dir"
            >
                <span class="flex min-w-0 items-center gap-2">
                    <span class="flex size-7 shrink-0 items-center justify-center rounded-full bg-burgundy-600 text-[11px] font-bold text-ivory-50">د</span>
                    <span class="truncate text-[11px] font-semibold text-ink-700">
                        {{ t('brand') }}
                        <span class="mx-1 hidden text-ink-500/50 sm:inline">·</span>
                        <span class="hidden text-ink-500 sm:inline">{{ t('public.weddingInvitation') }}</span>
                    </span>
                </span>

                <span class="flex shrink-0 items-center gap-1.5">
                    <MusicToggle :lang="lang" />

                    <button
                        v-if="englishEnabled"
                        type="button"
                        class="inline-flex items-center gap-1.5 rounded-full border border-champagne-200 bg-white/80 px-3 py-1.5 text-[11px] font-bold text-ink-700 transition hover:border-champagne-400"
                        :aria-label="t('common.switchLanguage')"
                        @click="toggleLanguage"
                    >
                        <Languages class="size-3.5 text-champagne-600" />
                        {{ lang === 'ar' ? 'English' : 'العربية' }}
                    </button>

                    <button
                        type="button"
                        class="inline-flex size-8 items-center justify-center rounded-full border border-champagne-200 bg-white/80 text-ink-700 transition hover:border-champagne-400"
                        :aria-label="t('public.share')"
                        @click="shareOpen = true"
                    >
                        <Share2 class="size-3.5" />
                    </button>
                </span>
            </div>
        </header>

        <InvitationExperience v-model:opened="opened" :invitation="invitation" :lang="lang" />

        <!-- Guest action dock -->
        <Transition
            enter-active-class="transition duration-500 ease-out"
            enter-from-class="translate-y-6 opacity-0"
            leave-active-class="transition duration-200 ease-in"
            leave-to-class="translate-y-4 opacity-0"
        >
            <div v-if="opened" class="fixed inset-x-0 bottom-0 z-40 flex justify-center px-3 pb-3 sm:pb-5">
                <nav
                    class="flex w-full max-w-xl items-stretch gap-1 rounded-full border border-white/60 bg-white/80 p-1.5 shadow-[0_22px_60px_-30px_rgba(36,31,25,.65)] backdrop-blur-xl"
                    :dir="dir"
                    :aria-label="t('public.eventDetails')"
                >
                    <button
                        type="button"
                        class="flex flex-1 flex-col items-center justify-center gap-1 rounded-full px-2 py-2 text-[10px] font-bold text-ink-700 transition hover:bg-champagne-100/60 sm:flex-row sm:gap-1.5 sm:text-[11px]"
                        @click="shareOpen = true"
                    >
                        <Share2 class="size-4 text-burgundy-600" />
                        {{ t('public.share') }}
                    </button>

                    <button
                        type="button"
                        class="flex flex-1 flex-col items-center justify-center gap-1 rounded-full px-2 py-2 text-[10px] font-bold text-ink-700 transition hover:bg-champagne-100/60 sm:flex-row sm:gap-1.5 sm:text-[11px]"
                        @click="copyLink"
                    >
                        <Copy class="size-4 text-champagne-600" />
                        {{ t('public.copyLink') }}
                    </button>

                    <a
                        v-if="view.event.mapsUrl"
                        :href="view.event.mapsUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex flex-1 flex-col items-center justify-center gap-1 rounded-full px-2 py-2 text-[10px] font-bold text-ink-700 transition hover:bg-champagne-100/60 sm:flex-row sm:gap-1.5 sm:text-[11px]"
                    >
                        <MapPin class="size-4 text-emerald-600" />
                        {{ t('public.openMaps') }}
                    </a>

                    <a
                        v-if="invitation.calendar_url"
                        :href="invitation.calendar_url"
                        download
                        class="flex flex-1 flex-col items-center justify-center gap-1 rounded-full px-2 py-2 text-[10px] font-bold text-ink-700 transition hover:bg-champagne-100/60 sm:flex-row sm:gap-1.5 sm:text-[11px]"
                    >
                        <CalendarPlus class="size-4 text-sky-600" />
                        {{ t('public.addToCalendar') }}
                    </a>
                </nav>
            </div>
        </Transition>

        <!-- Tap hint before opening -->
        <Transition
            enter-active-class="transition duration-500"
            enter-from-class="opacity-0"
            leave-active-class="transition duration-200"
            leave-to-class="opacity-0"
        >
            <div v-if="!opened" class="pointer-events-none fixed inset-x-0 bottom-4 z-30 flex justify-center px-4">
                <p class="inline-flex items-center gap-1.5 rounded-full bg-black/25 px-3 py-1.5 text-[10px] font-medium text-white/80 backdrop-blur">
                    <Sparkles class="size-3" />
                    {{ t('public.guestNote') }}
                </p>
            </div>
        </Transition>

        <Modal
            :open="shareOpen"
            :title="t('public.shareTitle')"
            :description="t('public.guestNote')"
            max-width="max-w-md"
            @close="shareOpen = false"
        >
            <ShareInvitation :url="publicUrl" :text="shareText" :title="shareTitle" :lang="lang" />
        </Modal>

        <ToastHost />
    </div>


</template>
