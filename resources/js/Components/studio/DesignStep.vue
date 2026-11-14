<script setup>
import { computed } from 'vue';
import { Info } from 'lucide-vue-next';
import { getTemplate, templateName } from '../../data/templates';
import { useI18n } from '../../i18n';
import TemplateSelector from './TemplateSelector.vue';
import DesignCustomizer from './DesignCustomizer.vue';

const props = defineProps({
    form: { type: Object, required: true },
    errors: { type: Function, default: () => '' },
    existing: { type: Object, default: () => ({}) },
});

const { t, locale } = useI18n();
const template = computed(() => getTemplate(props.form.template_key));

function chooseTemplate(next) {
    props.form.template_key = next.key;
    props.form.design_settings = {
        ...props.form.design_settings,
        primary_color: next.palette.primary,
        secondary_color: next.palette.secondary,
        background_color: next.palette.background,
        text_color: next.palette.text,
        decorative_color: next.palette.decorative,
        envelope_style: next.envelope.style,
        preset: 'template',
    };
}
</script>

<template>
    <div class="space-y-5">
        <div class="rounded-2xl border border-champagne-200 bg-champagne-100/30 px-4 py-3">
            <p class="flex items-center gap-2 text-[11px] font-semibold leading-6 text-ink-700">
                <Info class="size-4 shrink-0 text-champagne-600" />
                {{ t('wizard.stepDesc.design') }}
            </p>
            <p class="mt-1 ps-6 text-[10px] leading-5 text-ink-500">{{ t('design.templateChanged') }}</p>
        </div>

        <section class="rounded-2xl border border-[#ece2d1] bg-white/55 p-4">
            <TemplateSelector
                :model-value="form.template_key"
                :groom="form.groom_name_ar"
                :bride="form.bride_name_ar"
                @update:model-value="(key) => (form.template_key = key)"
                @selected="chooseTemplate"
            />
            <p v-if="errors('template_key')" class="mt-2 text-xs font-medium text-red-700">{{ errors('template_key') }}</p>

            <div class="mt-4 flex items-center gap-2 rounded-xl bg-champagne-100/40 px-3 py-2 text-[10px] text-ink-600">
                <Info class="size-3.5 shrink-0 text-champagne-600" />
                <span>
                    {{ t('design.template') }}:
                    <strong class="text-ink-900">{{ templateName(template, locale) }}</strong>
                </span>
            </div>
        </section>

        <DesignCustomizer
            :design="form.design_settings"
            :form="form"
            :english="form.enable_english"
            :existing="existing"
            :errors="errors"
        />
    </div>
</template>
