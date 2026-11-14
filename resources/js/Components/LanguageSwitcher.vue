<script setup>
import { Languages } from 'lucide-vue-next';
import { useI18n } from '../i18n';

defineProps({
    compact: { type: Boolean, default: false },
});

const { locale, t, toggle } = useI18n();
</script>

<template>
    <button
        type="button"
        class="inline-flex items-center gap-2 rounded-full border border-champagne-200/90 bg-white/70 px-3.5 py-2 text-xs font-semibold text-ink-700 backdrop-blur transition hover:border-champagne-400 hover:bg-white"
        :aria-label="t('common.switchLanguage')"
        @click="toggle"
    >
        <Languages class="size-4 text-champagne-600" />
        <span v-if="!compact">{{ locale === 'ar' ? 'English' : 'العربية' }}</span>
        <span v-else class="uppercase tracking-wider">{{ locale === 'ar' ? 'EN' : 'ع' }}</span>
    </button>
</template>
