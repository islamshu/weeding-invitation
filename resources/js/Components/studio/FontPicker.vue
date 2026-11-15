<script setup>
import { computed } from 'vue';
import { Check, Sparkles } from 'lucide-vue-next';
import { FONT_CATEGORIES, FONT_LIBRARY, fontName } from '../../data/fonts';
import { useI18n } from '../../i18n';

const props = defineProps({
    modelValue: { type: String, default: 'auto' },
    sample: { type: String, default: '' },
});

defineEmits(['update:modelValue']);

const { t, locale } = useI18n();

const selected = computed(() => props.modelValue || 'auto');

const groups = computed(() =>
    FONT_CATEGORIES.map((category) => ({
        ...category,
        fonts: FONT_LIBRARY.filter((font) => font.category === category.key),
    })).filter((group) => group.fonts.length)
);

const sampleText = computed(
    () => props.sample || (locale.value === 'ar' ? 'دعوة زفاف · أحمد و سارة' : 'Wedding Invitation')
);
</script>

<template>
    <div>
        <div class="flex items-center justify-between gap-2">
            <p class="field-label mb-0">{{ t('design.font') }}</p>
            <span class="flex items-center gap-1 rounded-full bg-champagne-100/70 px-2 py-0.5 text-[9px] font-semibold text-champagne-600">
                <Sparkles class="size-3" />
                {{ FONT_LIBRARY.length }}+
            </span>
        </div>

        <!-- Template default -->
        <button
            type="button"
            class="mt-2 flex w-full items-center justify-between gap-3 rounded-xl border bg-white/70 px-3 py-2.5 text-start transition hover:-translate-y-0.5 hover:shadow-md"
            :class="selected === 'auto' ? 'border-burgundy-600 ring-2 ring-burgundy-600/10' : 'border-champagne-200'"
            :aria-pressed="selected === 'auto'"
            @click="$emit('update:modelValue', 'auto')"
        >
            <span>
                <span class="block text-[11px] font-bold text-ink-900">{{ t('design.font.auto') }}</span>
                <span class="block text-[9px] leading-4 text-ink-500">{{ t('design.font.autoHint') }}</span>
            </span>
            <Check v-if="selected === 'auto'" class="size-4 shrink-0 text-burgundy-600" />
        </button>

        <!-- Grouped fonts -->
        <div v-for="group in groups" :key="group.key" class="mt-4">
            <p class="mb-1.5 flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.18em] text-ink-500">
                <span class="h-px flex-1 bg-champagne-200" />
                {{ locale === 'ar' ? group.name_ar : group.name_en }}
                <span class="h-px flex-1 bg-champagne-200" />
            </p>

            <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                <button
                    v-for="font in group.fonts"
                    :key="font.key"
                    type="button"
                    class="group relative overflow-hidden rounded-xl border bg-white/70 px-2.5 py-2 text-start transition hover:-translate-y-0.5 hover:shadow-md"
                    :class="selected === font.key ? 'border-burgundy-600 ring-2 ring-burgundy-600/10' : 'border-champagne-200'"
                    :aria-pressed="selected === font.key"
                    @click="$emit('update:modelValue', font.key)"
                >
                    <span class="flex items-center justify-between gap-1">
                        <span class="truncate text-[10px] font-bold text-ink-900">{{ fontName(font, locale) }}</span>
                        <Check v-if="selected === font.key" class="size-3.5 shrink-0 text-burgundy-600" />
                    </span>
                    <span
                        class="mt-1 block truncate text-[15px] leading-7 text-ink-700"
                        :dir="font.category === 'latin' ? 'ltr' : 'rtl'"
                        :style="{ fontFamily: font.category === 'latin' ? (font.en_family ?? font.family) : font.family }"
                    >
                        {{ font.category === 'latin' || locale !== 'ar' ? font.sample_ar : sampleText }}
                    </span>
                </button>
            </div>
        </div>

        <p class="field-hint mt-2">{{ t('design.fontHint') }}</p>
    </div>
</template>
