<script setup>
import { computed, useId } from 'vue';

const model = defineModel({ type: [String, Number], default: '' });

const props = defineProps({
    label: { type: String, default: '' },
    hint: { type: String, default: '' },
    error: { type: String, default: '' },
    type: { type: String, default: 'text' },
    placeholder: { type: String, default: '' },
    required: { type: Boolean, default: false },
    optional: { type: Boolean, default: false },
    dir: { type: String, default: null },
    autocomplete: { type: String, default: 'off' },
    min: { type: String, default: undefined },
    max: { type: String, default: undefined },
    step: { type: String, default: undefined },
    inputClass: { type: String, default: '' },
});

const id = useId();
const describedBy = computed(() => {
    const ids = [];
    if (props.hint) ids.push(`${id}-hint`);
    if (props.error) ids.push(`${id}-error`);
    return ids.length ? ids.join(' ') : undefined;
});
</script>

<template>
    <div class="w-full">
        <label v-if="label" :for="id" class="field-label">
            {{ label }}
            <span v-if="required" class="text-burgundy-500">*</span>
            <span v-else-if="optional" class="ms-1 text-[11px] font-normal text-ink-500">({{ $t?.('common.optional') ?? 'اختياري' }})</span>
        </label>

        <input
            :id="id"
            v-model="model"
            :type="type"
            :dir="dir"
            :placeholder="placeholder"
            :autocomplete="autocomplete"
            :min="min"
            :max="max"
            :step="step"
            :aria-invalid="Boolean(error)"
            :aria-describedby="describedBy"
            :class="['input-base', inputClass]"
        />

        <p v-if="hint && !error" :id="`${id}-hint`" class="field-hint mt-1.5">{{ hint }}</p>
        <p v-if="error" :id="`${id}-error`" class="mt-1.5 text-xs font-medium text-red-700">{{ error }}</p>
    </div>
</template>
