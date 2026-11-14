<script setup>
import { computed } from 'vue';
import { Circle, Crown, Diamond, Flower2, Gem, Heart, Landmark, Leaf, Minus, Moon, Sparkles, Star } from 'lucide-vue-next';

const props = defineProps({
    name: { type: String, default: '' },
    lang: { type: String, default: 'ar' },
    size: { type: String, default: 'md' },
    color: { type: String, default: 'var(--inv-primary)' },
    ornament: { type: String, default: 'var(--inv-decor)' },
    motif: { type: String, default: 'sparkle' },
    gold: { type: Boolean, default: false },
    compact: { type: Boolean, default: false },
});

const isArabic = computed(() => props.lang === 'ar');

const motifs = {
    crown: Crown,
    flower: Flower2,
    heart: Heart,
    leaf: Leaf,
    deco: Gem,
    diamond: Diamond,
    gem: Gem,
    crest: Crown,
    ring: Circle,
    sparkle: Sparkles,
    tatreez: Landmark,
    grid: Minus,
    arch: Star,
    star: Star,
    moon: Moon,
    line: Minus,
};

const motifComponent = computed(() => motifs[props.motif] ?? Sparkles);

const sizeClass = computed(
    () =>
        ({
            sm: 'text-xl sm:text-2xl',
            md: 'text-2xl sm:text-3xl',
            lg: 'text-3xl sm:text-4xl',
            xl: 'text-4xl sm:text-5xl',
        })[props.size] ?? 'text-2xl sm:text-3xl'
);

const fontFamily = computed(() => "var(--inv-font)");
const nameStyle = computed(() => ({
    fontFamily: fontFamily.value,
    ...(props.gold ? {} : { color: props.color }),
    textShadow: '0 1px 0 rgba(255,255,255,.18), 0 12px 26px rgba(0,0,0,.14)',
}));
</script>

<template>
    <span v-if="name" class="name-ornament relative block max-w-full text-center" :dir="isArabic ? 'rtl' : 'ltr'">
        <!-- upper arabesque medallion -->
        <span class="flex items-center justify-center gap-2" :style="{ color: ornament }" aria-hidden="true">
            <svg class="h-3 w-14 shrink opacity-75 sm:w-16" viewBox="0 0 64 16" fill="none">
                <path
                    d="M1 13c7.5 0 11.5-2.8 11.5-6.6 0-2.3-1.6-3.9-3.7-3.9-2 0-3.5 1.5-3.5 3.4 0 3.9 5.2 6.2 10 6.2 4 0 7.5-1.7 10.5-4.6"
                    stroke="currentColor"
                    stroke-width="1"
                    stroke-linecap="round"
                />
                <path d="M28 8.5c2.2-1.2 3.6-2.7 4.2-4.4" stroke="currentColor" stroke-width="1" stroke-linecap="round" />
                <circle cx="31.5" cy="7.6" r="1.1" fill="currentColor" />
            </svg>

            <span class="relative flex size-6 shrink-0 rotate-45 items-center justify-center rounded-[4px] border border-current/60 bg-current/[0.06]">
                <component :is="motifComponent" class="size-3 -rotate-45 opacity-90" :stroke-width="1.6" />
            </span>

            <svg class="h-3 w-14 shrink scale-x-[-1] opacity-75 sm:w-16" viewBox="0 0 64 16" fill="none">
                <path
                    d="M1 13c7.5 0 11.5-2.8 11.5-6.6 0-2.3-1.6-3.9-3.7-3.9-2 0-3.5 1.5-3.5 3.4 0 3.9 5.2 6.2 10 6.2 4 0 7.5-1.7 10.5-4.6"
                    stroke="currentColor"
                    stroke-width="1"
                    stroke-linecap="round"
                />
                <path d="M28 8.5c2.2-1.2 3.6-2.7 4.2-4.4" stroke="currentColor" stroke-width="1" stroke-linecap="round" />
                <circle cx="31.5" cy="7.6" r="1.1" fill="currentColor" />
            </svg>
        </span>

        <!-- calligraphic name with a soft halo -->
        <span class="relative mt-1.5 flex items-center justify-center">
            <span
                class="pointer-events-none absolute inset-x-4 inset-y-1 rounded-full opacity-[0.13] blur-xl"
                :style="{ background: color }"
                aria-hidden="true"
            />
            <span
                class="text-balance relative z-10 inline-block max-w-full px-2 leading-[1.45]"
                :class="[sizeClass, isArabic ? 'font-bold' : 'font-semibold', gold ? 'gold-text' : '']"
                :style="nameStyle"
            >
                {{ name }}
            </span>
        </span>

        <!-- lower diamond rule -->
        <span v-if="!compact" class="mt-1 flex items-center justify-center gap-1.5" :style="{ color: ornament }" aria-hidden="true">
            <span class="h-px w-7 bg-current opacity-40" />
            <span class="size-1 rotate-45 border border-current opacity-70" />
            <span class="h-px w-7 bg-current opacity-40" />
        </span>
    </span>
</template>
