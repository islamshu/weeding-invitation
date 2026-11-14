<script setup>
import { computed } from 'vue';
import { envelopeStyles } from '../../data/envelopeStyles';
import { useI18n } from '../../i18n';

const props = defineProps({
    modelValue: { type: String, default: 'classic' },
    paper: { type: String, default: '#f3e6cf' },
    accent: { type: String, default: '#b08d57' },
});

defineEmits(['update:modelValue']);

const { t, locale } = useI18n();

const selected = computed(() => props.modelValue || 'classic');
</script>

<template>
    <div>
        <p class="field-label">{{ t('design.envelope') }}</p>

        <div class="grid grid-cols-3 gap-2">
            <button
                v-for="style in envelopeStyles"
                :key="style.key"
                type="button"
                class="group rounded-xl border bg-white/70 p-1.5 text-start transition hover:-translate-y-0.5 hover:shadow-md"
                :class="selected === style.key ? 'border-burgundy-600 ring-2 ring-burgundy-600/10' : 'border-champagne-200'"
                :title="locale === 'ar' ? style.description_ar : style.description_en"
                :aria-pressed="selected === style.key"
                @click="$emit('update:modelValue', style.key)"
            >
                <span class="relative block aspect-[1.5/1] overflow-hidden rounded-lg border border-black/5">
                    <span class="absolute inset-0" :style="{ background: `linear-gradient(150deg, ${paper}, ${paper} 55%, ${accent}22)` }" />
                    <svg viewBox="0 0 100 60" preserveAspectRatio="none" class="absolute inset-0 size-full">
                        <path :d="style.flap" :fill="paper" :stroke="accent" stroke-width="1.2" stroke-linejoin="round" />
                        <path d="M8 46 L92 46" :stroke="accent" stroke-width="0.5" opacity="0.35" />
                    </svg>
                    <span
                        class="absolute start-1/2 top-[52%] flex size-4 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full text-[6px] font-bold text-white shadow-sm"
                        :style="{ background: accent }"
                    >
                        {{ style.seal === 'monogram' ? '♥' : '' }}
                    </span>
                </span>

                <span class="mt-1 block truncate text-center text-[9px] font-bold text-ink-700">
                    {{ locale === 'ar' ? style.name_ar : style.name_en }}
                </span>
            </button>
        </div>
    </div>
</template>
