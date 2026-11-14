<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { translate } from '../i18n';

const props = defineProps({
    target: { type: String, default: null },
    lang: { type: String, default: 'ar' },
    variant: { type: String, default: 'light' },
    compact: { type: Boolean, default: false },
});

const t = (key) => translate(key, props.lang);
const now = ref(Date.now());
let timer = null;

onMounted(() => {
    timer = window.setInterval(() => (now.value = Date.now()), 1000);
});
onBeforeUnmount(() => window.clearInterval(timer));

const targetTime = computed(() => (props.target ? new Date(props.target).getTime() : null));
const diff = computed(() => (targetTime.value ? Math.max(0, targetTime.value - now.value) : 0));
const started = computed(() => !targetTime.value || targetTime.value <= now.value);

const parts = computed(() => {
    const total = Math.floor(diff.value / 1000);
    return {
        days: Math.floor(total / 86400),
        hours: Math.floor((total % 86400) / 3600),
        minutes: Math.floor((total % 3600) / 60),
        seconds: total % 60,
    };
});

const dark = computed(() => ['dark', 'royal', 'emerald'].includes(props.variant));
const boxClass = computed(() =>
    dark.value
        ? 'border-white/20 bg-white/[0.07] text-white'
        : 'border-[color:var(--inv-decor)]/35 bg-white/45 text-[color:var(--inv-text)]'
);
const labelClass = computed(() => (dark.value ? 'text-white/55' : 'text-[color:var(--inv-text)]/55'));

const items = computed(() => [
    { key: 'days', value: parts.value.days, label: t('public.days') },
    { key: 'hours', value: parts.value.hours, label: t('public.hours') },
    { key: 'minutes', value: parts.value.minutes, label: t('public.minutes') },
    { key: 'seconds', value: parts.value.seconds, label: t('public.seconds') },
]);
</script>

<template>
    <div class="w-full text-center">
        <p v-if="!compact" class="text-[10px] font-bold uppercase tracking-[0.28em] opacity-60">{{ t('public.countdownTitle') }}</p>

        <p v-if="started" class="mt-3 text-sm italic opacity-80">{{ t('public.celebrationStarted') }}</p>

        <div v-else class="mt-3 flex items-stretch justify-center gap-2 sm:gap-3" :dir="lang === 'ar' ? 'rtl' : 'ltr'">
            <div
                v-for="item in items"
                :key="item.key"
                class="min-w-0 flex-1 rounded-xl border px-2 py-2.5 sm:max-w-[84px] sm:px-3 sm:py-3"
                :class="boxClass"
            >
                <p class="text-lg font-bold tabular-nums sm:text-xl">{{ String(item.value).padStart(2, '0') }}</p>
                <p class="mt-0.5 text-[9px] font-semibold uppercase tracking-wider sm:text-[10px]" :class="labelClass">{{ item.label }}</p>
            </div>
        </div>
    </div>
</template>
