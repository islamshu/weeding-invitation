<script setup>
import { Languages, Lightbulb, Sparkles, Wand2, X } from 'lucide-vue-next';
import { contentSuggestions } from '../../utils/invitation';
import { useI18n } from '../../i18n';
import BaseTextarea from '../BaseTextarea.vue';

defineProps({
    form: { type: Object, required: true },
    errors: { type: Function, default: () => '' },
});

const { t } = useI18n();

const fields = [
    { key: 'title', max: 160, rows: 2 },
    { key: 'invite_line', max: 300, rows: 2 },
    { key: 'intro', max: 700, rows: 3 },
    { key: 'message', max: 1500, rows: 5 },
    { key: 'religious', max: 700, rows: 3 },
    { key: 'closing', max: 700, rows: 3 },
    { key: 'additional', max: 700, rows: 3 },
];

function suggestionsFor(key, langKey) {
    return contentSuggestions[key]?.[langKey] ?? [];
}

function useSuggestion(form, fieldKey, langKey, value) {
    form.invitation_content[`${fieldKey}_${langKey}`] = value;
}

function clearField(form, fieldKey, langKey) {
    form.invitation_content[`${fieldKey}_${langKey}`] = '';
}
</script>

<template>
    <div class="space-y-5">
        <div class="rounded-2xl border border-champagne-200 bg-champagne-100/30 px-4 py-3">
            <p class="flex items-center gap-2 text-[11px] font-semibold leading-6 text-ink-700">
                <Sparkles class="size-4 shrink-0 text-champagne-600" />
                {{ t('wizard.stepDesc.content') }}
            </p>
            <p class="mt-1 ps-6 text-[10px] leading-5 text-ink-500">{{ t('content.tip') }}</p>
        </div>

        <div class="space-y-4">
            <div v-for="field in fields" :key="field.key" class="rounded-2xl border border-[#ece2d1] bg-white/55 p-3.5">
                <BaseTextarea
                    v-model="form.invitation_content[`${field.key}_ar`]"
                    :label="t(`content.${field.key}`)"
                    :placeholder="t(`content.${field.key}Placeholder`)"
                    :rows="field.rows"
                    :maxlength="field.max"
                    :error="errors(`invitation_content.${field.key}_ar`)"
                >
                    <template #meta>
                        <span class="shrink-0 text-[10px] tabular-nums text-ink-500">
                            {{ t('content.characters', { count: (form.invitation_content[`${field.key}_ar`] ?? '').length }) }}
                        </span>
                    </template>
                </BaseTextarea>

                <div class="mt-2 flex flex-wrap items-center gap-1.5">
                    <span class="inline-flex items-center gap-1 text-[9px] font-bold uppercase tracking-wider text-champagne-600">
                        <Lightbulb class="size-3" />
                        {{ t('content.suggestions') }}
                    </span>
                    <button
                        v-for="(suggestion, index) in suggestionsFor(field.key, 'ar').slice(0, 3)"
                        :key="`${field.key}-suggestion-${index}`"
                        type="button"
                        class="max-w-full truncate rounded-full border border-champagne-200 bg-white px-2.5 py-1 text-[10px] text-ink-600 transition hover:border-champagne-400 hover:text-ink-900"
                        :title="suggestion"
                        @click="useSuggestion(form, field.key, 'ar', suggestion)"
                    >
                        <Wand2 class="me-1 inline size-2.5 text-champagne-500" />
                        {{ suggestion.length > 46 ? `${suggestion.slice(0, 46)}…` : suggestion }}
                    </button>
                    <button
                        v-if="form.invitation_content[`${field.key}_ar`]"
                        type="button"
                        class="rounded-full p-1 text-ink-500 transition hover:bg-red-50 hover:text-red-600"
                        :aria-label="t('content.clearField')"
                        @click="clearField(form, field.key, 'ar')"
                    >
                        <X class="size-3" />
                    </button>
                </div>
            </div>
        </div>

        <div v-if="form.enable_english" class="rounded-2xl border border-dashed border-champagne-300 bg-white/50 p-4">
            <p class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-champagne-600">
                <Languages class="size-3.5" />
                {{ t('wizard.englishOptional') }}
            </p>

            <div class="mt-3 space-y-3.5">
                <div v-for="field in fields" :key="`en-${field.key}`" class="rounded-xl border border-champagne-100 bg-white/60 p-3">
                    <BaseTextarea
                        v-model="form.invitation_content[`${field.key}_en`]"
                        :label="`${t(`content.${field.key}`)} (EN)`"
                        :placeholder="t(`content.${field.key}Placeholder`)"
                        :rows="field.rows"
                        :maxlength="field.max"
                        dir="ltr"
                        optional
                        :error="errors(`invitation_content.${field.key}_en`)"
                    />
                    <div class="mt-2 flex flex-wrap items-center gap-1.5">
                        <button
                            v-for="(suggestion, index) in suggestionsFor(field.key, 'en').slice(0, 2)"
                            :key="`${field.key}-en-suggestion-${index}`"
                            type="button"
                            class="max-w-full truncate rounded-full border border-champagne-200 bg-white px-2.5 py-1 text-[10px] text-ink-600 transition hover:border-champagne-400 hover:text-ink-900"
                            :title="suggestion"
                            @click="useSuggestion(form, field.key, 'en', suggestion)"
                        >
                            <Wand2 class="me-1 inline size-2.5 text-champagne-500" />
                            {{ suggestion.length > 46 ? `${suggestion.slice(0, 46)}…` : suggestion }}
                        </button>
                    </div>
                </div>
            </div>
            <p class="mt-2 text-[10px] leading-5 text-ink-500">{{ t('wizard.englishOptionalNote') }}</p>
        </div>
    </div>
</template>
