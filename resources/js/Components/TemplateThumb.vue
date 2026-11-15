<script setup>
import { computed } from 'vue';
import { Crown, Flower2, Leaf, Sparkles, Heart, LayoutGrid, Star, Gem, Diamond, Shield, Moon, Sun } from 'lucide-vue-next';
import { monogram } from '../utils/invitation';

const props = defineProps({
    template: { type: Object, required: true },
    groom: { type: String, default: 'أحمد' },
    bride: { type: String, default: 'سارة' },
    groomWakil: { type: String, default: '' },
    brideWakil: { type: String, default: '' },
    lang: { type: String, default: 'ar' },
    rounded: { type: String, default: 'rounded-2xl' },
    showName: { type: Boolean, default: true },
});

const icons = {
    crown: Crown,
    flower: Flower2,
    leaf: Leaf,
    sparkle: Sparkles,
    heart: Heart,
    grid: LayoutGrid,
    deco: Diamond,
    crest: Shield,
    arch: Moon,
    line: Sun,
    ring: Star,
    tatreez: Gem,
};

const ornament = computed(() => icons[props.template?.ornament] ?? Crown);
const initials = computed(() => monogram(props.groomWakil || props.groom, props.brideWakil || props.bride, props.lang));
const fontFamily = computed(() => (props.template?.fonts?.ar === 'naskh' ? "'Noto Naskh Arabic', serif" : "'Cairo', sans-serif"));
const dark = computed(() => {
    const hex = (props.template?.palette?.background ?? '#fff').replace('#', '');
    if (hex.length !== 6) return false;
    const [r, g, b] = [0, 2, 4].map((i) => parseInt(hex.slice(i, i + 2), 16));
    return (r * 299 + g * 587 + b * 114) / 1000 < 110;
});

const style = computed(() => ({
    '--t-bg': props.template?.palette?.background,
    '--t-primary': props.template?.palette?.primary,
    '--t-secondary': props.template?.palette?.secondary,
    '--t-text': props.template?.palette?.text,
    '--t-decor': props.template?.palette?.decorative,
}));
</script>

<template>
    <div class="relative isolate h-full w-full overflow-hidden" :class="rounded" :style="style">
        <div
            class="absolute inset-0"
            :style="{
                background: `radial-gradient(120% 80% at 50% -20%, ${template.palette.secondary}55, transparent 60%), ${template.palette.background}`,
            }"
        />

        <!-- heritage pattern -->
        <div v-if="template.ornament === 'tatreez'" class="absolute inset-0 opacity-[0.13]" :style="{ color: template.palette.primary, backgroundImage: 'repeating-linear-gradient(45deg, currentColor 0 1.5px, transparent 1.5px 9px), repeating-linear-gradient(-45deg, currentColor 0 1.5px, transparent 1.5px 9px)' }" />
        <div v-else-if="template.ornament === 'deco'" class="absolute inset-0 opacity-25" :style="{ backgroundImage: `linear-gradient(135deg, ${template.palette.primary}22 25%, transparent 25%, transparent 50%, ${template.palette.primary}22 50%, ${template.palette.primary}22 75%, transparent 75%)`, backgroundSize: '26px 26px' }" />
        <div v-else class="absolute inset-0 opacity-40" :style="{ backgroundImage: `radial-gradient(${template.palette.secondary}66 1px, transparent 1px)`, backgroundSize: '14px 14px' }" />

        <!-- frame -->
        <div class="absolute inset-2.5 border sm:inset-3" :style="{ borderColor: template.palette.decorative + '99', borderRadius: template.ornament === 'arch' ? '45% 45% 12px 12px' : '10px' }" />
        <div class="absolute inset-[15px] border opacity-50" :style="{ borderColor: template.palette.decorative + '66', borderRadius: template.ornament === 'arch' ? '45% 45% 8px 8px' : '8px' }" />

        <div class="relative flex h-full flex-col items-center justify-center gap-2 px-5 text-center" :style="{ color: template.palette.text }">
            <component :is="ornament" class="size-5 opacity-80" :style="{ color: template.palette.decorative }" />
            <p class="text-[8px] font-semibold uppercase tracking-[0.3em] opacity-60">
                {{ lang === 'ar' ? 'دعوة زفاف' : 'WEDDING' }}
            </p>

            <div class="my-0.5 h-px w-8" :style="{ background: template.palette.decorative }" />

            <p
                class="text-xs font-semibold leading-tight"
                :style="{ fontFamily }"
            >
                {{ groom }}
                <span class="mx-1 opacity-60">&</span>
                {{ bride }}
            </p>

            <span
                class="mt-1 inline-flex size-9 items-center justify-center rounded-full border text-[11px] font-bold"
                :style="{ borderColor: template.palette.decorative, color: template.palette.primary }"
            >
                {{ initials }}
            </span>

            <p v-if="showName" class="mt-0.5 text-[8px] opacity-60">{{ lang === 'ar' ? template.name_ar : template.name_en }}</p>
        </div>

        <div class="absolute inset-x-6 bottom-2.5 flex items-center justify-center">
            <div class="h-px flex-1" :style="{ background: template.palette.decorative + '66' }" />
            <span class="px-2 text-[7px]" :style="{ color: template.palette.decorative }">✦</span>
            <div class="h-px flex-1" :style="{ background: template.palette.decorative + '66' }" />
        </div>
    </div>
</template>
