<script setup>
import { computed } from 'vue';
import { designStyle } from '../utils/invitation';

const props = defineProps({
    view: { type: Object, required: true },
    preview: { type: Boolean, default: false },
});

const style = computed(() => {
    const base = designStyle(props.view.design, props.view.fonts);
    const imageStyle = {};
    const styleName = props.view.design.background_style;

    if (styleName === 'image' && props.view.images.background) {
        imageStyle.backgroundImage = `linear-gradient(rgba(255,255,255,.22), rgba(255,255,255,.22)), url("${props.view.images.background}")`;
        imageStyle.backgroundSize = 'cover';
        imageStyle.backgroundPosition = 'center';
    }

    return { ...base, ...imageStyle };
});

const templateComponent = computed(() => props.view.template?.component);
</script>

<template>
    <div class="relative isolate overflow-hidden" :class="{ 'paper': view.design.background_style === 'paper' }" :style="style">
        <!-- decorative background texture -->
        <div
            v-if="view.design.background_style === 'texture'"
            class="pointer-events-none absolute inset-0 opacity-[0.05] arabesque"
            :style="{ color: view.design.primary_color }"
        />
        <div
            v-else-if="view.design.background_style === 'paper'"
            class="pointer-events-none absolute inset-0 opacity-[0.35]"
            :style="{ backgroundImage: `radial-gradient(${view.design.decorative_color}22 1px, transparent 1px)`, backgroundSize: '12px 12px' }"
        />

        <!-- uploaded decorative element -->
        <img
            v-if="view.images.decorative && view.design.show_florals"
            :src="view.images.decorative"
            alt=""
            class="pointer-events-none absolute -end-6 -top-6 z-10 w-28 rotate-6 opacity-80 sm:w-36"
            loading="lazy"
        />

        <component :is="templateComponent" :view="view" />

        <!-- central floral decoration fallback, kept behind content -->
        <div v-if="view.preview" class="pointer-events-none absolute inset-x-0 bottom-3 text-center">
            <span class="rounded-full bg-white/80 px-3 py-1 text-[9px] font-bold uppercase tracking-widest text-ink-500 shadow-sm">معاينة</span>
        </div>
    </div>
</template>
