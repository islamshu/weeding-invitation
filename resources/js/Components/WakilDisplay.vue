<script setup>
import { computed } from 'vue';
import { translate } from '../i18n';

const props = defineProps({
    wakil: { type: Object, required: true },
    lang: { type: String, default: 'ar' },
    align: { type: String, default: 'center' },
    variant: { type: String, default: 'default' },
});

const t = (key, params = {}) => translate(key, props.lang, params);
const dir = computed(() => (props.lang === 'ar' ? 'rtl' : 'ltr'));
const alignment = computed(() => ({ start: 'text-start items-start', end: 'text-end items-end', center: 'text-center items-center' }[props.align] ?? 'text-center items-center'));

const wrap = computed(() => ({
    default: '',
    framed: 'rounded-2xl border border-[color:var(--inv-decor)]/40 px-5 py-5',
    minimal: 'border-s-2 border-[color:var(--inv-decor)]/60 ps-4',
    glass: 'rounded-3xl border border-white/20 bg-white/5 px-5 py-6 backdrop-blur-sm',
    plaque: 'rounded-[1.4rem] border border-[color:var(--inv-decor)]/50 bg-[color:var(--inv-decor)]/[0.06] px-5 py-6',
}[props.variant] ?? ''));
</script>

<template>
    <div v-if="!wakil.isEmpty" class="flex flex-col" :class="[alignment, wrap]" :dir="dir">
        <p v-if="wakil.intro" class="mb-2 text-[11px] leading-6 opacity-75">{{ wakil.intro }}</p>

        <p v-if="wakil.title" class="text-[13px] font-semibold tracking-wide opacity-85">{{ wakil.title }}</p>

        <p v-if="wakil.name" class="mt-0.5 text-lg font-bold leading-snug sm:text-xl" style="color: var(--inv-text)">{{ wakil.name }}</p>

        <p v-if="wakil.kunya" class="mt-1 text-[15px] font-medium opacity-80">«{{ wakil.kunya }}»</p>

        <p v-if="wakil.designation" class="mt-1.5 text-[11px] font-medium tracking-wide opacity-70">{{ wakil.designation }}</p>

        <span class="mt-3 inline-block h-px w-10" :style="{ background: 'var(--inv-decor)' }" />
    </div>
</template>
