<script setup>
import { computed } from 'vue';
import { CalendarPlus } from 'lucide-vue-next';
import { translate } from '../i18n';

const props = defineProps({
    url: { type: String, required: true },
    lang: { type: String, default: 'ar' },
    variant: { type: String, default: 'primary' },
    label: { type: String, default: '' },
});

const t = (key) => translate(key, props.lang);

const classes = computed(() => ({
    primary: 'bg-burgundy-600 text-ivory-50 hover:bg-burgundy-700 shadow-[0_14px_30px_-16px_rgba(109,31,51,.7)]',
    gold: 'bg-champagne-400 text-ink-900 hover:bg-champagne-300 shadow-[0_14px_30px_-16px_rgba(176,141,87,.8)]',
    outline: 'border border-[color:var(--inv-decor)]/60 text-[color:var(--inv-decor)] hover:bg-[color:var(--inv-decor)]/10',
}[props.variant] ?? 'bg-burgundy-600 text-ivory-50 hover:bg-burgundy-700'));
</script>

<template>
    <a
        :href="url"
        download
        class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-3 text-xs font-bold transition"
        :class="classes"
    >
        <CalendarPlus class="size-4" />
        {{ label || t('public.addToCalendar') }}
    </a>
</template>
