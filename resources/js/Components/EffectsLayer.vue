<script setup>
import { computed } from 'vue';

const props = defineProps({
    effects: {
        type: Object,
        default: () => ({ petals: false, sparkles: false, confetti: false }),
    },
});

function seeded(count, seed) {
    return Array.from({ length: count }, (_, index) => {
        const n = Math.sin((index + 1) * seed) * 10000;
        return n - Math.floor(n);
    });
}

const petals = seeded(16, 12.9898);
const sparkles = seeded(18, 78.233);
const confetti = seeded(26, 37.719);

const active = computed(() => props.effects?.petals || props.effects?.sparkles || props.effects?.confetti);
</script>

<template>
    <div v-if="active" class="pointer-events-none fixed inset-0 z-[60] overflow-hidden" aria-hidden="true">
        <template v-if="effects.petals">
            <span
                v-for="(value, index) in petals"
                :key="`petal-${index}`"
                class="absolute top-0 block rounded-[100%_0_100%_0] opacity-0"
                :style="{
                    left: `${(value * 100).toFixed(2)}%`,
                    width: `${7 + value * 9}px`,
                    height: `${9 + value * 11}px`,
                    background: `linear-gradient(135deg, #f3c5cf, #d98ba1)`,
                    animation: `petalFall ${9 + value * 7}s linear ${value * 8}s infinite`,
                    '--drift': `${(value - 0.5) * 160}px`,
                }"
            />
        </template>

        <template v-if="effects.sparkles">
            <span
                v-for="(value, index) in sparkles"
                :key="`sparkle-${index}`"
                class="absolute size-1 rounded-full bg-[#e8cf8f] shadow-[0_0_8px_2px_rgba(232,207,143,.5)]"
                :style="{
                    left: `${(value * 100).toFixed(2)}%`,
                    top: `${(seeded(18, 5.1)[index] * 100).toFixed(2)}%`,
                    animation: `sparkle ${2.8 + value * 3}s ease-in-out ${value * 3}s infinite`,
                }"
            />
        </template>

        <template v-if="effects.confetti">
            <span
                v-for="(value, index) in confetti"
                :key="`confetti-${index}`"
                class="absolute top-0 block opacity-0"
                :style="{
                    left: `${(value * 100).toFixed(2)}%`,
                    width: `${4 + value * 5}px`,
                    height: `${7 + value * 6}px`,
                    background: ['#c9a86a', '#7a2940', '#f3c5cf', '#1f6b4a', '#e8cf8f'][index % 5],
                    borderRadius: value > 0.6 ? '50%' : '1px',
                    animation: `petalFall ${7 + value * 6}s linear ${value * 6}s infinite`,
                    '--drift': `${(value - 0.5) * 240}px`,
                }"
            />
        </template>
    </div>
</template>
