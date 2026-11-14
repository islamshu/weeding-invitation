<script setup>
import { computed } from 'vue';
import { Eye, Quote } from 'lucide-vue-next';
import { designationOptions, optionLabel, titleOptions } from '../../utils/invitation';
import { useI18n } from '../../i18n';
import BaseInput from '../BaseInput.vue';
import BaseSelect from '../BaseSelect.vue';
import ToggleSwitch from '../ToggleSwitch.vue';

const props = defineProps({
    wakil: { type: Object, required: true },
    side: { type: String, default: 'groom' },
    prefix: { type: String, required: true },
    errors: { type: Function, default: () => '' },
    english: { type: Boolean, default: false },
});

const { t } = useI18n();

const isGroom = computed(() => props.side === 'groom');
const title = computed(() => (isGroom.value ? t('wakil.groomTitle') : t('wakil.brideTitle')));
const description = computed(() => (isGroom.value ? t('wakil.groomDesc') : t('wakil.brideDesc')));

function toChoices(options, type) {
    return options.map((option) => ({
        value: option.key,
        label:
            option.key === 'none'
                ? t(`wakil.${type}.none`)
                : option.key === 'custom'
                  ? t(`wakil.${type}.custom`)
                  : [option.ar, option.en].filter(Boolean).join(' · '),
    }));
}

const titleChoices = computed(() => toChoices(titleOptions, 'title'));
const designationChoices = computed(() => toChoices(designationOptions, 'designation'));

const showCustomTitle = computed(() => props.wakil.title_key === 'custom');
const showCustomDesignation = computed(() => props.wakil.designation_key === 'custom');

const preview = computed(() => {
    const titleValue = props.wakil.show_title
        ? props.wakil.title_key === 'custom'
            ? props.wakil.title_custom_ar
            : optionLabel(titleOptions, props.wakil.title_key, 'ar')
        : '';
    const nameValue = props.wakil.show_name ? props.wakil.name_ar : '';
    const kunyaValue = props.wakil.show_kunya ? props.wakil.kunya_ar : '';
    const designationValue = props.wakil.show_designation
        ? props.wakil.designation_key === 'custom'
            ? props.wakil.designation_custom_ar
            : optionLabel(designationOptions, props.wakil.designation_key, 'ar')
        : '';

    return { title: titleValue, name: nameValue, kunya: kunyaValue, designation: designationValue };
});

const isEmpty = computed(() => !preview.value.name && !preview.value.title && !preview.value.designation);
</script>

<template>
    <section class="rounded-[1.3rem] border border-champagne-200 bg-white/55 p-4 sm:p-5">
        <div class="flex items-start gap-3">
            <span
                class="flex size-9 shrink-0 items-center justify-center rounded-full text-xs font-bold"
                :class="isGroom ? 'bg-burgundy-600 text-ivory-50' : 'bg-champagne-400 text-ink-900'"
            >
                {{ isGroom ? '١' : '٢' }}
            </span>
            <div class="min-w-0 flex-1">
                <h3 class="text-sm font-bold text-ink-900">{{ title }}</h3>
                <p class="mt-0.5 text-[11px] leading-5 text-ink-500">{{ description }}</p>
            </div>
            <span class="hidden rounded-full border border-champagne-200 bg-white px-2.5 py-1 text-[9px] font-bold text-champagne-600 sm:inline">
                {{ t('wakil.optionalSection') }}
            </span>
        </div>

        <div class="mt-4 grid gap-3.5 sm:grid-cols-2">
            <BaseSelect v-model="wakil.title_key" :label="t('wakil.title')" :options="titleChoices" :hint="t('wakil.titleHint')" />
            <BaseInput v-model="wakil.name_ar" :label="t('wakil.fullName')" :placeholder="t('wakil.namePlaceholder')" :error="errors(`${prefix}.name_ar`)" required />
            <BaseInput v-if="wakil.title_key === 'custom'" v-model="wakil.title_custom_ar" :label="t('wakil.customTitle')" :error="errors(`${prefix}.title_custom_ar`)" />
            <BaseInput v-else v-model="wakil.kunya_ar" :label="t('wakil.kunya')" :placeholder="t('wakil.kunyaPlaceholder')" :hint="t('wakil.kunyaHint')" :error="errors(`${prefix}.kunya_ar`)" />
            <BaseInput v-if="wakil.title_key === 'custom'" v-model="wakil.kunya_ar" :label="t('wakil.kunya')" :placeholder="t('wakil.kunyaPlaceholder')" :hint="t('wakil.kunyaHint')" :error="errors(`${prefix}.kunya_ar`)" />
            <BaseSelect v-model="wakil.designation_key" :label="t('wakil.designation')" :options="designationChoices" :hint="t('wakil.designationHint')" />
            <BaseInput
                v-if="showCustomDesignation"
                v-model="wakil.designation_custom_ar"
                :label="t('wakil.customDesignation')"
                :error="errors(`${prefix}.designation_custom_ar`)"
            />
            <BaseInput v-model="wakil.intro_ar" :label="t('wakil.intro')" :placeholder="t('wakil.introPlaceholder')" :error="errors(`${prefix}.intro_ar`)" />
        </div>

        <div v-if="english" class="mt-4 rounded-xl border border-dashed border-champagne-300 bg-white/50 p-3">
            <p class="text-[10px] font-bold uppercase tracking-wider text-champagne-600">{{ t('wizard.englishOptional') }}</p>
            <div class="mt-2.5 grid gap-3 sm:grid-cols-2">
                <BaseInput v-model="wakil.name_en" :label="`${t('wakil.fullName')} (EN)`" dir="ltr" :error="errors(`${prefix}.name_en`)" />
                <BaseInput v-model="wakil.kunya_en" :label="`${t('wakil.kunya')} (EN)`" dir="ltr" :error="errors(`${prefix}.kunya_en`)" />
                <BaseInput v-if="showCustomTitle" v-model="wakil.title_custom_en" :label="`${t('wakil.customTitle')} (EN)`" dir="ltr" :error="errors(`${prefix}.title_custom_en`)" />
                <BaseInput
                    v-if="showCustomDesignation"
                    v-model="wakil.designation_custom_en"
                    :label="`${t('wakil.customDesignation')} (EN)`"
                    dir="ltr"
                    :error="errors(`${prefix}.designation_custom_en`)" class="sm:col-span-2"
                />
                <BaseInput v-model="wakil.intro_en" :label="`${t('wakil.intro')} (EN)`" dir="ltr" :error="errors(`${prefix}.intro_en`)" class="sm:col-span-2" />
            </div>
        </div>

        <div class="mt-4">
            <p class="mb-2 flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-ink-500">
                <Eye class="size-3.5" />
                {{ t('wakil.display') }}
            </p>
            <div class="grid gap-2 sm:grid-cols-2">
                <ToggleSwitch v-model="wakil.show_title" :label="t('wakil.showTitle')" />
                <ToggleSwitch v-model="wakil.show_name" :label="t('wakil.showName')" />
                <ToggleSwitch v-model="wakil.show_kunya" :label="t('wakil.showKunya')" />
                <ToggleSwitch v-model="wakil.show_designation" :label="t('wakil.showDesignation')" />
            </div>
        </div>

        <div class="mt-4 rounded-xl border border-champagne-200 bg-gradient-to-br from-white to-champagne-100/30 p-4 text-center">
            <p class="flex items-center justify-center gap-1.5 text-[9px] font-bold uppercase tracking-[0.2em] text-champagne-600">
                <Quote class="size-3" />
                {{ t('wakil.previewTitle') }}
            </p>
            <p v-if="isEmpty" class="mt-2 text-[11px] text-ink-500">{{ t('wakil.emptyPreview') }}</p>
            <div v-else class="mt-2 space-y-0.5">
                <p v-if="preview.title" class="text-[11px] font-semibold text-ink-500">{{ preview.title }}</p>
                <p v-if="preview.name" class="text-base font-bold text-ink-900">{{ preview.name }}</p>
                <p v-if="preview.kunya" class="text-xs text-ink-500">«{{ preview.kunya }}»</p>
                <p v-if="preview.designation" class="text-[10px] font-medium text-ink-500">{{ preview.designation }}</p>
            </div>
        </div>
    </section>
</template>
