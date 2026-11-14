<script setup>
import { Heart, Info, Languages } from 'lucide-vue-next';
import { useI18n } from '../../i18n';
import BaseInput from '../BaseInput.vue';
import BaseTextarea from '../BaseTextarea.vue';
import ToggleSwitch from '../ToggleSwitch.vue';

defineProps({
    form: { type: Object, required: true },
    errors: { type: Function, default: () => '' },
});

const { t } = useI18n();
</script>

<template>
    <div class="space-y-5">
        <div class="rounded-2xl border border-champagne-200 bg-champagne-100/30 px-4 py-3">
            <p class="flex items-center gap-2 text-[11px] font-semibold leading-6 text-ink-700">
                <Info class="size-4 shrink-0 text-champagne-600" />
                {{ t('wizard.stepDesc.couple') }}
            </p>
            <p class="mt-1 ps-6 text-[10px] leading-5 text-ink-500">{{ t('wizard.requiredHint') }}</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl border border-burgundy-400/30 bg-burgundy-500/5 p-4">
                <p class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em] text-burgundy-600">
                    <Heart class="size-3.5" />
                    {{ t('wizard.groom') }}
                </p>
                <div class="mt-3">
                    <BaseInput
                        v-model="form.groom_name_ar"
                        :label="t('wizard.groomName')"
                        :placeholder="t('wizard.namePlaceholderGroom')"
                        required
                        :error="errors('groom_name_ar')"
                    />
                </div>
            </div>

            <div class="rounded-2xl border border-champagne-200 bg-champagne-100/25 p-4">
                <p class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em] text-champagne-600">
                    <Heart class="size-3.5" />
                    {{ t('wizard.bride') }}
                </p>
                <div class="mt-3">
                    <BaseInput
                        v-model="form.bride_name_ar"
                        :label="t('wizard.brideName')"
                        :placeholder="t('wizard.namePlaceholderBride')"
                        required
                        :error="errors('bride_name_ar')"
                    />
                </div>
            </div>
        </div>

        <BaseTextarea
            v-model="form.couple_note_ar"
            :label="t('wizard.note')"
            :placeholder="t('wizard.notePlaceholder')"
            :hint="t('wizard.noteHint')"
            :rows="2"
            optional
            :error="errors('couple_note_ar')"
        />

        <div class="rounded-2xl border border-dashed border-champagne-300 bg-white/50 p-4">
            <ToggleSwitch v-model="form.enable_english" :label="t('wizard.englishToggle')" :description="t('wizard.englishToggleDesc')" />

            <div v-if="form.enable_english" class="mt-4 space-y-3">
                <p class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-champagne-600">
                    <Languages class="size-3.5" />
                    {{ t('wizard.englishOptional') }}
                </p>
                <div class="grid gap-3 sm:grid-cols-2">
                    <BaseInput v-model="form.groom_name_en" :label="`${t('wizard.groomName')} (EN)`" dir="ltr" :placeholder="t('wizard.namePlaceholderGroom')" :error="errors('groom_name_en')" optional />
                    <BaseInput v-model="form.bride_name_en" :label="`${t('wizard.brideName')} (EN)`" dir="ltr" :placeholder="t('wizard.namePlaceholderBride')" :error="errors('bride_name_en')" optional />
                </div>
                <BaseTextarea v-model="form.couple_note_en" :label="`${t('wizard.note')} (EN)`" dir="ltr" :rows="2" :error="errors('couple_note_en')" optional />
                <p class="text-[10px] leading-5 text-ink-500">{{ t('wizard.englishOptionalNote') }}</p>
            </div>
        </div>
    </div>
</template>
