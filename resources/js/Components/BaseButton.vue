<script setup>
import { computed } from 'vue';
import { Loader2 } from 'lucide-vue-next';

const props = defineProps({
    variant: { type: String, default: 'primary' },
    size: { type: String, default: 'md' },
    type: { type: String, default: 'button' },
    href: { type: String, default: null },
    disabled: { type: Boolean, default: false },
    loading: { type: Boolean, default: false },
    block: { type: Boolean, default: false },
});

const variants = {
    primary: 'bg-burgundy-600 text-ivory-50 hover:bg-burgundy-700 shadow-[0_12px_30px_-12px_rgba(109,31,51,.65)]',
    gold: 'bg-champagne-400 text-ink-900 hover:bg-champagne-300 shadow-[0_12px_30px_-14px_rgba(176,141,87,.8)]',
    secondary: 'border border-champagne-300 bg-white/70 text-ink-700 hover:bg-champagne-100/60',
    ghost: 'text-ink-700 hover:bg-champagne-100/60',
    danger: 'bg-red-700 text-white hover:bg-red-800',
    dark: 'bg-ink-900 text-ivory-50 hover:bg-ink-700',
};

const sizes = {
    sm: 'px-3.5 py-2 text-xs',
    md: 'px-5 py-2.5 text-sm',
    lg: 'px-7 py-3.5 text-base',
};

const classes = computed(() => [
    'inline-flex items-center justify-center gap-2 rounded-full font-semibold tracking-[0.01em] transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-champagne-400 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-55 active:scale-[.985]',
    variants[props.variant] ?? variants.primary,
    sizes[props.size] ?? sizes.md,
    props.block ? 'w-full' : '',
]);
</script>

<template>
    <component
        :is="href ? 'a' : 'button'"
        :href="href"
        :type="href ? undefined : type"
        :disabled="href ? undefined : disabled || loading"
        :class="classes"
    >
        <Loader2 v-if="loading" class="size-4 animate-spin" />
        <slot />
    </component>
</template>
