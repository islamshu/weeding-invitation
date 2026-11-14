<script setup>
import { computed, ref } from 'vue';
import { Check, Sparkles } from 'lucide-vue-next';
import { templates, templateCategories, templateName } from '../../data/templates';
import { useI18n } from '../../i18n';
import TemplateThumb from '../TemplateThumb.vue';

const props = defineProps({
    modelValue: { type: String, default: 'classic_royal' },
    groom: { type: String, default: '' },
    bride: { type: String, default: '' },
});

const emit = defineEmits(['update:modelValue', 'selected']);

const { t, locale } = useI18n();
const category = ref('all');

const filtered = computed(() =>
    category.value === 'all'
        ? templates
        : templates.filter((template) => template.category === category.value)
);

function select(template) {
    emit('update:modelValue', template.key);
    emit('selected', template);
}
</script>

<template>
    <div>
        <div class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-ink-900">{{ t('design.chooseTemplate') }}</h3>
                <p class="mt-1 text-xs text-ink-500">{{ t('design.categories.all') }} · {{ templates.length }}</p>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-champagne-100/60 px-3 py-1.5 text-[10px] font-bold text-champagne-600">
                <Sparkles class="size-3" />
                {{ templateName(templates.find((item) => item.key === modelValue), locale) }}
            </span>
        </div>

        <div class="no-scrollbar mt-4 flex gap-1.5 overflow-x-auto pb-1">
            <button
                v-for="item in templateCategories"
                :key="item.key"
                type="button"
                class="shrink-0 rounded-full border px-3.5 py-2 text-[11px] font-semibold transition"
                :class="category === item.key
                    ? 'border-burgundy-600 bg-burgundy-600 text-ivory-50'
                    : 'border-champagne-200 bg-white/70 text-ink-600 hover:border-champagne-400'"
                @click="category = item.key"
            >
                {{ locale === 'ar' ? item.name_ar : item.name_en }}
            </button>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
            <button
                v-for="template in filtered"
                :key="template.key"
                type="button"
                class="group relative overflow-hidden rounded-2xl border-2 bg-white p-1.5 text-start transition duration-200 hover:-translate-y-0.5 hover:shadow-lg"
                :class="modelValue === template.key ? 'border-burgundy-600 ring-4 ring-burgundy-600/10' : 'border-transparent hover:border-champagne-300'"
                @click="select(template)"
            >
                <div class="aspect-[4/3] overflow-hidden rounded-xl">
                    <TemplateThumb
                        :template="template"
                        :groom="groom || 'أحمد'"
                        :bride="bride || 'سارة'"
                        :lang="locale"
                        rounded="rounded-xl"
                        :show-name="false"
                    />
                </div>
                <div class="flex items-center justify-between gap-2 px-1.5 pb-1 pt-2">
                    <span class="min-w-0">
                        <span class="block truncate text-[11px] font-bold text-ink-900">{{ templateName(template, locale) }}</span>
                        <span class="mt-0.5 block text-[9px] uppercase tracking-wider text-ink-500">
                            {{ templateCategories.find((item) => item.key === template.category)?.[locale === 'ar' ? 'name_ar' : 'name_en'] }}
                        </span>
                    </span>
                    <span
                        class="flex size-5 shrink-0 items-center justify-center rounded-full border transition"
                        :class="modelValue === template.key ? 'border-burgundy-600 bg-burgundy-600 text-ivory-50' : 'border-champagne-200 text-transparent group-hover:border-champagne-400'"
                    >
                        <Check class="size-3" />
                    </span>
                </div>
            </button>
        </div>
    </div>
</template>
