<script setup>
import { useId } from 'vue';

const model = defineModel({ type: String, default: '' });

defineProps({
    label: { type: String, default: '' },
    hint: { type: String, default: '' },
    error: { type: String, default: '' },
    placeholder: { type: String, default: '' },
    rows: { type: Number, default: 4 },
    required: { type: Boolean, default: false },
    optional: { type: Boolean, default: false },
    dir: { type: String, default: null },
    maxlength: { type: [String, Number], default: undefined },
});

const id = useId();
</script>

<template>
    <div class="w-full">
        <label v-if="label" :for="id" class="field-label">
            {{ label }}
            <span v-if="required" class="text-burgundy-500">*</span>
            <span v-else-if="optional" class="ms-1 text-[11px] font-normal text-ink-500">({{ $t?.('common.optional') ?? 'اختياري' }})</span>
        </label>

        <textarea
            :id="id"
            v-model="model"
            :rows="rows"
            :dir="dir"
            :placeholder="placeholder"
            :maxlength="maxlength"
            :aria-invalid="Boolean(error)"
            class="input-base resize-y leading-7"
        />

        <div class="mt-1.5 flex items-start justify-between gap-3">
            <p v-if="error" class="text-xs font-medium text-red-700">{{ error }}</p>
            <p v-else-if="hint" class="field-hint">{{ hint }}</p>
            <slot name="meta" />
        </div>
    </div>
</template>
