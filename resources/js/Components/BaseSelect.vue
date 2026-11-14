<script setup>
import { computed, useId } from 'vue';

const model = defineModel({ type: [String, Number, Boolean], default: '' });

const props = defineProps({
    label: { type: String, default: '' },
    hint: { type: String, default: '' },
    error: { type: String, default: '' },
    options: { type: Array, default: () => [] },
    placeholder: { type: String, default: '' },
    required: { type: Boolean, default: false },
    optional: { type: Boolean, default: false },
});

const id = useId();

const normalized = computed(() =>
    props.options.map((option) =>
        typeof option === 'object'
            ? { value: option.value ?? option.key, label: option.label ?? option.name }
            : { value: option, label: option }
    )
);
</script>

<template>
    <div class="w-full">
        <label v-if="label" :for="id" class="field-label">
            {{ label }}
            <span v-if="required" class="text-burgundy-500">*</span>
            <span v-else-if="optional" class="ms-1 text-[11px] font-normal text-ink-500">({{ $t?.('common.optional') ?? 'اختياري' }})</span>
        </label>

        <select :id="id" v-model="model" :aria-invalid="Boolean(error)" class="input-base appearance-none bg-[length:16px] bg-[left_0.9rem_center] bg-no-repeat pe-4" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%238a6a3b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E&quot;);">
            <option v-if="placeholder" value="" disabled>{{ placeholder }}</option>
            <option v-for="option in normalized" :key="option.value" :value="option.value">{{ option.label }}</option>
        </select>

        <p v-if="hint && !error" class="field-hint mt-1.5">{{ hint }}</p>
        <p v-if="error" class="mt-1.5 text-xs font-medium text-red-700">{{ error }}</p>
    </div>
</template>
