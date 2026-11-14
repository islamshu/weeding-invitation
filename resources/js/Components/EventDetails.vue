<script setup>
import { computed } from 'vue';
import { CalendarDays, Clock3, MapPin, ExternalLink, Sparkles } from 'lucide-vue-next';
import { translate } from '../i18n';

const props = defineProps({
    view: { type: Object, required: true },
    lang: { type: String, default: 'ar' },
    variant: { type: String, default: 'light' },
    showAdditional: { type: Boolean, default: true },
    showMaps: { type: Boolean, default: true },
});

const t = (key, params = {}) => translate(key, props.lang, params);

const dark = computed(() => ['dark', 'royal', 'emerald'].includes(props.variant));
const card = computed(() => {
    if (dark.value) return 'border-white/15 bg-white/[0.06] text-white/90';
    if (props.variant === 'minimal') return 'border-black/10 bg-transparent text-[color:var(--inv-text)]';
    return 'border-[color:var(--inv-decor)]/30 bg-white/45 text-[color:var(--inv-text)]';
});
const muted = computed(() => (dark.value ? 'text-white/65' : 'text-[color:var(--inv-text)]/65'));
const mapButton = computed(() =>
    dark.value
        ? 'border-[color:var(--inv-decor)]/60 text-[color:var(--inv-decor)] hover:bg-[color:var(--inv-decor)]/10'
        : 'bg-[color:var(--inv-primary)] text-[color:var(--inv-bg)] hover:opacity-90'
);
</script>

<template>
    <div class="w-full">
        <div class="grid gap-3 sm:grid-cols-2">
            <div class="rounded-2xl border px-4 py-4" :class="card">
                <p class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em]" :class="muted">
                    <CalendarDays class="size-3.5" />
                    {{ t('public.date') }}
                </p>
                <p class="mt-2 text-sm font-bold leading-6">{{ view.event.dateFormatted || '—' }}</p>
                <p v-if="view.event.timeFormatted" class="mt-1 flex items-center gap-1.5 text-xs" :class="muted">
                    <Clock3 class="size-3.5" />
                    {{ t('public.time') }}: {{ view.event.timeFormatted }}
                </p>
            </div>

            <div class="rounded-2xl border px-4 py-4" :class="card">
                <p class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em]" :class="muted">
                    <MapPin class="size-3.5" />
                    {{ t('public.venue') }}
                </p>
                <p class="mt-2 text-sm font-bold leading-6">{{ view.event.venueName || '—' }}</p>
                <p v-if="view.event.venueAddress" class="mt-1 text-xs leading-5" :class="muted">{{ view.event.venueAddress }}</p>
                <a
                    v-if="showMaps && view.event.mapsUrl"
                    :href="view.event.mapsUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-3 inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-[11px] font-bold transition"
                    :class="mapButton"
                >
                    <ExternalLink class="size-3" />
                    {{ t('public.openMaps') }}
                </a>
            </div>
        </div>

        <div v-if="showAdditional && (view.event.henna.enabled || view.event.reception.enabled)" class="mt-3 grid gap-3 sm:grid-cols-2">
            <div v-if="view.event.henna.enabled" class="rounded-2xl border px-4 py-4" :class="card">
                <p class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em]" :class="muted">
                    <Sparkles class="size-3.5" />
                    {{ t('public.henna') }}
                </p>
                <p class="mt-2 text-sm font-bold">{{ view.event.henna.dateFormatted }}</p>
                <p v-if="view.event.henna.timeFormatted" class="mt-0.5 text-xs" :class="muted">{{ view.event.henna.timeFormatted }}</p>
                <p v-if="view.event.henna.location" class="mt-1 text-xs" :class="muted">{{ view.event.henna.location }}</p>
            </div>

            <div v-if="view.event.reception.enabled" class="rounded-2xl border px-4 py-4" :class="card">
                <p class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em]" :class="muted">
                    <Sparkles class="size-3.5" />
                    {{ t('public.reception') }}
                </p>
                <p class="mt-2 text-sm font-bold">{{ view.event.reception.dateFormatted }}</p>
                <p v-if="view.event.reception.timeFormatted" class="mt-0.5 text-xs" :class="muted">{{ view.event.reception.timeFormatted }}</p>
                <p v-if="view.event.reception.location" class="mt-1 text-xs" :class="muted">{{ view.event.reception.location }}</p>
            </div>
        </div>
    </div>
</template>
