<script setup>
import { computed } from 'vue';
import { Volume2, VolumeX } from 'lucide-vue-next';
import { translate } from '../i18n';
import { useInvitationMusic } from '../composables/useInvitationMusic';

const props = defineProps({
    lang: { type: String, default: 'ar' },
    variant: { type: String, default: 'glass' },
});

const { muted, playing, supported, toggleMute } = useInvitationMusic();
const t = (key) => translate(key, props.lang);

const label = computed(() => (muted.value ? t('public.music.unmute') : t('public.music.mute')));
const classes = computed(() =>
    props.variant === 'solid'
        ? 'border-transparent bg-ink-900 text-ivory-50 hover:bg-ink-700'
        : 'border-champagne-200 bg-white/80 text-ink-700 hover:border-champagne-400'
);
</script>

<template>
    <button
        v-if="supported"
        type="button"
        class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-[11px] font-bold transition"
        :class="classes"
        :aria-pressed="muted"
        :aria-label="label"
        :title="label"
        @click="toggleMute"
    >
        <VolumeX v-if="muted" class="size-3.5" />
        <Volume2 v-else class="size-3.5" />

        <span v-if="playing && !muted" class="relative flex size-1.5" aria-hidden="true">
            <span class="absolute inline-flex size-full animate-ping rounded-full bg-current opacity-50" />
            <span class="relative inline-flex size-1.5 rounded-full bg-current" />
        </span>
    </button>
</template>
