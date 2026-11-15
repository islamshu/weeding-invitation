<script setup>
import { computed, ref, watch } from 'vue';
import { ImagePlus, Mail, Palette, Paintbrush, Sparkles, Trash2, Upload } from 'lucide-vue-next';
import { designPresets } from '../../utils/invitation';
import { useI18n } from '../../i18n';
import { toast } from '../../utils/toast';
import BaseSelect from '../BaseSelect.vue';
import ToggleSwitch from '../ToggleSwitch.vue';
import EnvelopeStylePicker from './EnvelopeStylePicker.vue';
import FontPicker from './FontPicker.vue';

const props = defineProps({
    design: { type: Object, required: true },
    form: { type: Object, required: true },
    english: { type: Boolean, default: false },
    existing: { type: Object, default: () => ({}) },
    errors: { type: Function, default: () => '' },
});

const { t, locale } = useI18n();

const previews = ref({
    cover_image: props.existing.cover ?? null,
    background_image: props.existing.background ?? null,
    decorative_image: props.existing.decorative ?? null,
});

watch(
    () => props.existing,
    (value) => {
        previews.value.cover_image = previews.value.cover_image ?? value.cover ?? null;
        previews.value.background_image = previews.value.background_image ?? value.background ?? null;
        previews.value.decorative_image = previews.value.decorative_image ?? value.decorative ?? null;
    },
    { deep: true }
);

const colors = computed(() => [
    { key: 'primary_color', label: t('design.primary') },
    { key: 'secondary_color', label: t('design.secondary') },
    { key: 'background_color', label: t('design.background') },
    { key: 'text_color', label: t('design.text') },
    { key: 'decorative_color', label: t('design.decorative') },
]);

const backgroundOptions = computed(() => [
    { value: 'soft', label: t('design.bg.soft') },
    { value: 'plain', label: t('design.bg.plain') },
    { value: 'paper', label: t('design.bg.paper') },
    { value: 'texture', label: t('design.bg.texture') },
    { value: 'image', label: t('design.bg.image') },
]);

const borderOptions = computed(() => [
    { value: 'ornate', label: t('design.border.ornate') },
    { value: 'thin', label: t('design.border.thin') },
    { value: 'double', label: t('design.border.double') },
    { value: 'none', label: t('design.border.none') },
]);

const layoutOptions = computed(() => [
    { value: 'groom_right', label: t('design.groomRight') },
    { value: 'groom_left', label: t('design.groomLeft') },
]);

const uploads = computed(() => [
    {
        key: 'cover_image',
        label: t('design.coverImage'),
        hint: t('design.coverImageHint'),
    },
    {
        key: 'background_image',
        label: t('design.backgroundImage'),
        hint: t('design.backgroundImageHint'),
    },
    {
        key: 'decorative_image',
        label: t('design.decorativeImage'),
        hint: t('design.decorativeImageHint'),
    },
]);

function applyPreset(preset) {
    Object.assign(props.design, preset.colors, { preset: preset.key });
    toast.success(t('design.presetApplied'));
}

function onFile(field, event) {
    const file = event.target.files?.[0];
    if (!file) return;

    if (file.size > 4 * 1024 * 1024) {
        toast.error(t('design.uploadsHint'));
        event.target.value = '';
        return;
    }

    if (previews.value[field]?.startsWith('blob:')) {
        URL.revokeObjectURL(previews.value[field]);
    }

    props.form[field] = file;
    props.form[`remove_${field}`] = false;
    previews.value[field] = URL.createObjectURL(file);

    const base = field.replace('_image', '');
    props.form[`${base}_preview_url`] = previews.value[field];
}

function removeImage(field) {
    if (previews.value[field]?.startsWith('blob:')) {
        URL.revokeObjectURL(previews.value[field]);
    }

    props.form[field] = null;
    props.form[`remove_${field}`] = true;
    previews.value[field] = null;

    const base = field.replace('_image', '');
    props.form[`${base}_preview_url`] = null;
}
</script>

<template>
    <div class="space-y-6">
        <!-- Palettes -->
        <section class="rounded-2xl border border-champagne-200 bg-white/60 p-4">
            <div class="flex items-center gap-2">
                <Palette class="size-4 text-champagne-600" />
                <h3 class="text-sm font-bold text-ink-900">{{ t('design.presets') }}</h3>
            </div>
            <div class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-3">
                <button
                    v-for="preset in designPresets"
                    :key="preset.key"
                    type="button"
                    class="group rounded-xl border p-2 transition hover:-translate-y-0.5 hover:shadow-md"
                    :class="design.preset === preset.key ? 'border-burgundy-600 ring-2 ring-burgundy-600/10' : 'border-champagne-200'"
                    @click="applyPreset(preset)"
                >
                    <span class="flex h-7 overflow-hidden rounded-lg border border-black/5">
                        <span class="flex-1" :style="{ background: preset.colors.primary }" />
                        <span class="flex-1" :style="{ background: preset.colors.secondary }" />
                        <span class="flex-1" :style="{ background: preset.colors.background }" />
                        <span class="flex-1" :style="{ background: preset.colors.decorative }" />
                    </span>
                    <span class="mt-2 block truncate text-[10px] font-bold text-ink-700">
                        {{ locale === 'ar' ? preset.name_ar : preset.name_en }}
                    </span>
                </button>
            </div>
        </section>

        <!-- Colors -->
        <section class="rounded-2xl border border-champagne-200 bg-white/60 p-4">
            <div class="flex items-center gap-2">
                <Paintbrush class="size-4 text-champagne-600" />
                <h3 class="text-sm font-bold text-ink-900">{{ t('design.colorCustom') }}</h3>
            </div>
            <div class="mt-3 grid gap-2.5 sm:grid-cols-2">
                <label
                    v-for="color in colors"
                    :key="color.key"
                    class="flex items-center gap-3 rounded-xl border border-[#ece2d1] bg-white/70 px-2.5 py-2"
                >
                    <span class="relative size-8 shrink-0 overflow-hidden rounded-lg border border-black/10">
                        <input v-model="design[color.key]" type="color" class="absolute -inset-2 size-12 cursor-pointer border-0 bg-transparent p-0" :aria-label="color.label" />
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-[10px] font-bold text-ink-700">{{ color.label }}</span>
                        <input
                            v-model="design[color.key]"
                            type="text"
                            dir="ltr"
                            maxlength="7"
                            class="w-full bg-transparent p-0 text-[10px] font-medium uppercase tracking-wider text-ink-500 outline-none"
                        />
                    </span>
                </label>
            </div>
        </section>

        <!-- Typography & composition -->
        <section class="rounded-2xl border border-champagne-200 bg-white/60 p-4">
            <div class="grid gap-3.5 sm:grid-cols-2">
                <FontPicker
                    v-model="design.font_family"
                    class="sm:col-span-2"
                    :sample="[form.groom_name_ar, form.bride_name_ar].filter(Boolean).join(' و ')"
                />
                <BaseSelect v-model="design.background_style" :label="t('design.backgroundStyle')" :options="backgroundOptions" />
                <BaseSelect v-model="design.border_style" :label="t('design.border')" :options="borderOptions" />
                <BaseSelect v-model="design.couple_layout" :label="t('design.coupleLayout')" :options="layoutOptions" :hint="t('design.layoutHint')" />
            </div>
        </section>

        <!-- Envelope / cover -->
        <section class="rounded-2xl border border-champagne-200 bg-white/60 p-4">
            <div class="flex items-center gap-2">
                <Mail class="size-4 text-champagne-600" />
                <h3 class="text-sm font-bold text-ink-900">{{ t('design.envelope') }}</h3>
            </div>
            <p class="mt-1 text-[11px] leading-5 text-ink-500">{{ t('design.envelopeHint') }}</p>
            <div class="mt-3">
                <EnvelopeStylePicker
                    v-model="design.envelope_style"
                    :paper="design.background_color"
                    :accent="design.decorative_color"
                />
            </div>
        </section>

        <!-- Elements & effects -->
        <section class="space-y-3">
            <div>
                <h3 class="text-sm font-bold text-ink-900">{{ t('design.elements') }}</h3>
                <div class="mt-2 grid gap-2 sm:grid-cols-2">
                    <ToggleSwitch v-model="design.show_centerpiece" :label="t('design.centerpiece')" />
                    <ToggleSwitch v-model="design.show_florals" :label="t('design.florals')" />
                    <ToggleSwitch v-model="design.show_monogram" :label="t('design.monogram')" />
                    <ToggleSwitch v-model="design.show_hearts" :label="t('design.hearts')" />
                </div>
            </div>

            <div>
                <div class="flex items-center gap-2">
                    <Sparkles class="size-4 text-champagne-600" />
                    <h3 class="text-sm font-bold text-ink-900">{{ t('design.effects') }}</h3>
                </div>
                <p class="mt-1 text-[11px] leading-5 text-ink-500">{{ t('design.effectsHint') }}</p>
                <div class="mt-2 grid gap-2 sm:grid-cols-3">
                    <ToggleSwitch v-model="design.effects.petals" :label="t('design.petals')" />
                    <ToggleSwitch v-model="design.effects.sparkles" :label="t('design.sparkles')" />
                    <ToggleSwitch v-model="design.effects.confetti" :label="t('design.confetti')" />
                </div>
            </div>
        </section>

        <!-- Images -->
        <section class="rounded-2xl border border-champagne-200 bg-white/60 p-4">
            <div class="flex items-center gap-2">
                <ImagePlus class="size-4 text-champagne-600" />
                <h3 class="text-sm font-bold text-ink-900">{{ t('design.uploads') }}</h3>
            </div>
            <p class="mt-1 text-[11px] leading-5 text-ink-500">{{ t('design.uploadsHint') }}</p>

            <div class="mt-3 grid gap-3 sm:grid-cols-3">
                <div v-for="item in uploads" :key="item.key" class="rounded-xl border border-[#ece2d1] bg-white/70 p-2.5">
                    <p class="text-[10px] font-bold text-ink-700">{{ item.label }}</p>

                    <div class="relative mt-2 aspect-[4/3] overflow-hidden rounded-lg border border-dashed border-champagne-300 bg-champagne-100/20">
                        <img v-if="previews[item.key]" :src="previews[item.key]" alt="" class="size-full object-cover" />
                        <div v-else class="flex size-full flex-col items-center justify-center gap-1 text-champagne-500">
                            <ImagePlus class="size-5" />
                            <span class="text-[9px] font-medium">{{ t('design.noImage') }}</span>
                        </div>
                    </div>

                    <div class="mt-2 flex items-center gap-1.5">
                        <label class="inline-flex flex-1 cursor-pointer items-center justify-center gap-1.5 rounded-lg bg-champagne-100/70 px-2 py-1.5 text-[10px] font-bold text-ink-700 transition hover:bg-champagne-100">
                            <Upload class="size-3" />
                            {{ t('design.chooseImage') }}
                            <input type="file" accept="image/jpeg,image/png,image/webp" class="sr-only" @change="onFile(item.key, $event)" />
                        </label>
                        <button
                            v-if="previews[item.key]"
                            type="button"
                            class="inline-flex size-7 items-center justify-center rounded-lg border border-red-200 text-red-600 transition hover:bg-red-50"
                            :aria-label="t('design.removeImage')"
                            @click="removeImage(item.key)"
                        >
                            <Trash2 class="size-3" />
                        </button>
                    </div>

                    <p class="mt-1.5 text-[9px] leading-4 text-ink-500">{{ item.hint }}</p>
                    <p v-if="errors(`design_settings.${item.key}`)" class="mt-1 text-[9px] font-medium text-red-700">
                        {{ errors(`design_settings.${item.key}`) }}
                    </p>
                </div>
            </div>
        </section>
    </div>
</template>
