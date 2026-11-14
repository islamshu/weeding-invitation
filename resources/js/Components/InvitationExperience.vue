<script setup>
import { computed, onBeforeUnmount, ref, watch } from 'vue';
import { Heart, MousePointerClick, Sparkles } from 'lucide-vue-next';
import { buildView } from '../utils/invitation';
import { translate } from '../i18n';
import InvitationEnvelope from './InvitationEnvelope.vue';
import InvitationCard from './InvitationCard.vue';
import EffectsLayer from './EffectsLayer.vue';
import { useInvitationMusic } from '../composables/useInvitationMusic';

const props = defineProps({
    invitation: { type: Object, required: true },
    lang: { type: String, default: 'ar' },
    preview: { type: Boolean, default: false },
    music: { type: Boolean, default: true },
});

const emit = defineEmits(['opened']);
const opened = defineModel('opened', { type: Boolean, default: false });

const t = (key, params = {}) => translate(key, props.lang, params);
const opening = ref(false);
let timer = null;

// The guest's click is a real user gesture, which is exactly when browsers
// allow an AudioContext to start. Preview surfaces opt out with :music="false".
const { start: startMusic, stop: stopMusic } = useInvitationMusic();

const view = computed(() => buildView(props.invitation, props.lang));
const effects = computed(() => view.value.design.effects ?? { petals: false, sparkles: false, confetti: false });
const palette = computed(() => view.value.template?.palette ?? { background: '#fbf7f0', decorative: '#c9a86a', secondary: '#e6d2ae', primary: '#8a6a3b' });

const backdrop = computed(() => ({
    background: `radial-gradient(75% 55% at 50% 0%, ${palette.value.secondary}55, transparent 62%), radial-gradient(70% 50% at 50% 100%, ${palette.value.decorative}22, transparent 60%), ${palette.value.background}`,
}));

function open() {
    if (opening.value || opened.value) return;

    if (props.music) startMusic();

    opening.value = true;
    timer = window.setTimeout(() => {
        opened.value = true;
        opening.value = false;
    }, 1250);
}

watch(
    () => opened.value,
    (value) => {
        if (value) emit('opened');
    }
);

onBeforeUnmount(() => {
    window.clearTimeout(timer);
    if (props.music) stopMusic();
});
</script>

<template>
    <div class="relative">
        <Transition
            mode="out-in"
            enter-active-class="transition duration-700 ease-out"
            enter-from-class="opacity-0 translate-y-4"
            leave-active-class="transition duration-500 ease-in"
            leave-to-class="opacity-0 -translate-y-3"
        >
            <div
                v-if="!opened"
                key="envelope"
                class="relative flex flex-col items-center justify-center overflow-hidden px-5 py-14 sm:py-20"
                :class="preview ? 'min-h-[72vh]' : 'min-h-[100svh]'"
                :style="backdrop"
                :dir="view.dir"
            >
                <!-- soft ornaments -->
                <div class="pointer-events-none absolute inset-0 opacity-[0.18]" :style="{ color: palette.decorative, backgroundImage: 'radial-gradient(currentColor 1px, transparent 1px)', backgroundSize: '26px 26px' }" />
                <div class="pointer-events-none absolute -start-24 top-1/4 size-72 rounded-full opacity-20 blur-3xl" :style="{ background: palette.decorative }" />
                <div class="pointer-events-none absolute -end-24 bottom-1/4 size-72 rounded-full opacity-20 blur-3xl" :style="{ background: palette.primary }" />

                <div class="relative mb-8 text-center">
                    <span class="inline-flex items-center gap-2 rounded-full border px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.3em]" :style="{ borderColor: palette.decorative + '66', color: palette.primary }">
                        <Sparkles class="size-3.5" />
                        {{ view.content.title || t('public.weddingInvitation') }}
                    </span>

                    <p class="mt-5 text-2xl font-semibold leading-tight sm:text-3xl" :style="{ color: palette.primary }">
                        {{ view.couple.groom }}
                        <span class="mx-1.5 opacity-50">&</span>
                        {{ view.couple.bride }}
                    </p>
                    <p v-if="view.event.dateShort" class="mt-2 text-[11px] tracking-[0.2em] opacity-60">{{ view.event.dateShort }}</p>
                </div>

                <button
                    type="button"
                    class="group relative block w-full max-w-[430px] cursor-pointer rounded-[1.6rem] outline-none transition focus-visible:ring-4 focus-visible:ring-champagne-300/60"
                    :aria-label="t('public.envelope.tap')"
                    @click="open"
                >
                    <InvitationEnvelope :invitation="invitation" :view="view" :lang="lang" :opening="opening" />
                    <span class="absolute -bottom-1 start-1/2 flex size-11 -translate-x-1/2 translate-y-1/2 items-center justify-center rounded-full border border-white/80 bg-white shadow-lg transition group-hover:scale-105" :style="{ color: palette.primary }">
                        <Heart class="size-4 fill-current opacity-80" />
                    </span>
                </button>

                <button
                    type="button"
                    class="relative mt-10 inline-flex items-center gap-2 rounded-full px-6 py-3 text-xs font-bold shadow-[0_18px_40px_-20px_rgba(0,0,0,.5)] transition hover:-translate-y-0.5"
                    :style="{ background: palette.primary, color: '#fffdf8' }"
                    @click="open"
                >
                    <MousePointerClick class="size-4" />
                    {{ t('public.envelope.tap') }}
                </button>

                <p class="relative mt-3 text-[11px] opacity-55">{{ t('public.envelope.hint') }}</p>
            </div>

            <div v-else key="card" class="relative">
                <InvitationCard :invitation="invitation" :lang="lang" :preview="preview" />

                <div v-if="!preview" class="border-t border-champagne-200/40 bg-ivory-100/70 py-6 text-center">
                    <p class="inline-flex items-center gap-2 text-[11px] font-medium tracking-wide text-ink-500">
                        {{ t('public.footer') }}
                        <Heart class="size-3.5 text-burgundy-500" />
                        {{ t('brand') }}
                    </p>
                </div>
            </div>
        </Transition>

        <EffectsLayer v-if="opened" :effects="effects" />
    </div>
</template>
