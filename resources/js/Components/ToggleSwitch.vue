<script setup>
defineProps({
    label: { type: String, default: '' },
    description: { type: String, default: '' },
    disabled: { type: Boolean, default: false },
});

const model = defineModel({ type: Boolean, default: false });
</script>

<template>
    <label
        class="flex cursor-pointer items-start justify-between gap-4 rounded-2xl border border-[#ece2d1] bg-white/60 px-4 py-3.5 transition hover:border-champagne-300"
        :class="{ 'opacity-60': disabled }"
    >
        <span class="min-w-0">
            <span class="block text-sm font-semibold text-ink-900">{{ label }}</span>
            <span v-if="description" class="mt-0.5 block text-xs leading-6 text-ink-500">{{ description }}</span>
            <slot />
        </span>

        <button
            type="button"
            role="switch"
            :aria-checked="model"
            :disabled="disabled"
            class="relative mt-0.5 h-6 w-11 shrink-0 rounded-full transition-colors duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-champagne-400 focus-visible:ring-offset-2"
            :class="model ? 'bg-burgundy-600' : 'bg-stone-300'"
            @click="model = !model"
        >
            <span
                class="absolute start-0.5 top-0.5 size-5 rounded-full bg-white shadow-sm transition-transform duration-300"
                :class="model ? 'translate-x-5 rtl:-translate-x-5' : 'translate-x-0'"
            />
        </button>
    </label>
</template>
