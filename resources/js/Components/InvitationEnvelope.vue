<script setup>
import { computed } from 'vue';
import { Diamond, Flower2, Gem, Heart, Leaf, Moon, Sparkles, Star } from 'lucide-vue-next';
import { translate } from '../i18n';
import { getEnvelopeStyle } from '../data/envelopeStyles';

const props = defineProps({
    invitation: { type: Object, required: true },
    view: { type: Object, required: true },
    lang: { type: String, default: 'ar' },
    opening: { type: Boolean, default: false },
});

const t = (key, params = {}) => translate(key, props.lang, params);
const envelope = computed(() => props.view.template?.envelope ?? { paper: '#f3e6cf', accent: '#b08d57', seal: '#7a2940', style: 'classic' });
const styleName = computed(() => props.view.design?.envelope_style || envelope.value.style);
const styleDef = computed(() => getEnvelopeStyle(styleName.value));
const groom = computed(() => props.view.couple.groom);
const bride = computed(() => props.view.couple.bride);
const isArabic = computed(() => (props.view.lang ?? props.lang) === 'ar');

const isMinimal = computed(() => styleName.value === 'minimal');
const isRibbon = computed(() => styleName.value === 'ribbon');
const isNight = computed(() => styleName.value === 'night');
const isArabesque = computed(() => styleName.value === 'arabesque');
const isDeco = computed(() => styleName.value === 'deco');
const isFloral = computed(() => styleName.value === 'floral');
const isMonogram = computed(() => styleName.value === 'monogram');

const cardMotif = computed(
    () =>
        ({
            wax: Heart,
            floral: Flower2,
            monogram: null,
            arabesque: Star,
            deco: Diamond,
            night: Moon,
        })[styleName.value] ?? Sparkles
);

const cardStyle = computed(() =>
    isNight.value
        ? { background: 'linear-gradient(160deg, #1b1813, #0f0d0a)', borderColor: envelope.value.accent + '55', color: '#f7f1e3' }
        : { background: '#fffdf8', borderColor: envelope.value.accent + '66' }
);

const cardNameClass = computed(() =>
    isArabic.value ? 'text-xl font-bold leading-tight' : 'text-lg font-semibold leading-tight'
);

const cardMutedClass = computed(() => (isNight.value ? 'text-white/40' : 'text-stone-400'));

const frontStyle = computed(() => ({
    background: `linear-gradient(160deg, ${envelope.value.paper}, ${envelope.value.paper} 55%, ${envelope.value.accent}18)`,
}));

const innerFlapPath = computed(
    () =>
        ({
            classic: 'M8 5 L50 44 L92 5',
            wax: 'M12 6 C28 18, 40 30, 50 44 C60 30, 72 18, 88 6',
            monogram: 'M12 7 L50 38 L88 7',
            floral: 'M12 6 C30 16, 40 28, 50 34 C60 28, 70 16, 88 6',
            minimal: '',
            arabesque: 'M14 8 C30 14, 38 22, 50 40 C62 22, 70 14, 86 8',
            deco: 'M12 8 L88 8',
            ribbon: 'M12 8 L88 8',
            night: 'M12 6 C28 18, 40 30, 50 46 C60 30, 72 18, 88 6',
        })[styleName.value] ?? 'M8 5 L50 44 L92 5'
);

const sealIcon = computed(
    () =>
        ({
            heart: Heart,
            flower: Flower2,
            star: Star,
            diamond: Gem,
            moon: Moon,
        })[styleDef.value.seal] ?? null
);

const starField = {
    backgroundImage: 'radial-gradient(circle, rgba(255,255,255,.9) 0.7px, transparent 1px)',
    backgroundSize: '18px 18px',
};

const arabesquePattern = {
    backgroundImage:
        'radial-gradient(circle at 100% 100%, transparent 38%, currentColor 39%, transparent 42%), radial-gradient(circle at 0 0, transparent 38%, currentColor 39%, transparent 42%)',
    backgroundSize: '30px 30px',
};
</script>

<template>
    <div class="relative flex w-full flex-col items-center">
        <div class="relative w-full max-w-[430px]">
            <!-- glow -->
            <div class="absolute -inset-8 rounded-[3rem] opacity-30 blur-3xl" :style="{ background: envelope.accent }" />

            <div class="envelope relative mx-auto aspect-[1.5/1] w-full" :class="[`is-${styleName}`, { 'is-opening': opening }]">
                <!-- envelope back -->
                <div
                    class="absolute inset-0 rounded-[1.2rem] shadow-[0_35px_80px_-30px_rgba(0,0,0,.45)]"
                    :style="{ background: `linear-gradient(150deg, ${envelope.paper}, ${envelope.accent}22)` }"
                />
                <div v-if="isNight" class="absolute inset-0 rounded-[1.2rem] opacity-40" :style="starField" />

                <!-- card peeking from envelope -->
                <div
                    class="card-peek absolute inset-x-[8%] top-[6%] bottom-[18%] z-10 overflow-hidden rounded-lg border px-5 py-4 text-center shadow-xl"
                    :style="cardStyle"
                >
                    <div class="flex h-full flex-col items-center justify-center">
                        <component :is="cardMotif" v-if="cardMotif" class="size-4" :style="{ color: envelope.accent }" />
                        <span v-else class="text-sm font-semibold tracking-[0.2em]" :style="{ color: envelope.accent }">
                            {{ view.couple.monogram }}
                        </span>

                        <p v-if="!isMinimal" class="mt-2 text-[8px] font-bold uppercase tracking-[0.35em]" :class="cardMutedClass">
                            {{ t('public.envelope.invitation') }}
                        </p>
                        <div class="my-2 h-px w-10" :style="{ background: envelope.accent }" />

                        <p :class="cardNameClass" :style="{ color: envelope.seal }">{{ groom }}</p>
                        <span class="my-1 text-xs" :class="cardMutedClass">&</span>
                        <p :class="cardNameClass" :style="{ color: envelope.seal }">{{ bride }}</p>

                        <p v-if="!isMinimal" class="mt-2 text-[8px] tracking-[0.3em]" :class="cardMutedClass">
                            {{ t('public.envelope.sealed') }}
                        </p>
                    </div>
                </div>

                <!-- envelope front pockets -->
                <div class="absolute inset-0 z-20 overflow-hidden rounded-[1.2rem]">
                    <div class="absolute inset-0" :style="frontStyle" />
                    <div v-if="isNight" class="absolute inset-0 opacity-30" :style="starField" />
                    <div v-if="isArabesque" class="absolute inset-0 opacity-[0.18]" :style="{ ...arabesquePattern, color: envelope.accent }" />

                    <template v-if="!isMinimal">
                        <div class="absolute -start-[12%] bottom-0 top-[28%] w-[72%] origin-bottom-right rotate-[28deg] border-t" :style="{ background: envelope.paper, borderColor: envelope.accent + '44' }" />
                        <div class="absolute -end-[12%] bottom-0 top-[28%] w-[72%] origin-bottom-left -rotate-[28deg] border-t" :style="{ background: envelope.paper, borderColor: envelope.accent + '44' }" />
                        <div class="absolute inset-x-0 bottom-0 top-[52%]" :style="{ background: `linear-gradient(180deg, ${envelope.paper}, ${envelope.accent}12)` }" />
                    </template>

                    <template v-else>
                        <div class="absolute inset-x-6 bottom-4 h-px" :style="{ background: envelope.accent + '66' }" />
                        <div class="absolute inset-x-10 bottom-6 h-px opacity-50" :style="{ background: envelope.accent + '55' }" />
                    </template>

                    <div v-if="isMonogram" class="pointer-events-none absolute inset-x-0 bottom-4 flex justify-center">
                        <span class="text-5xl tracking-[0.32em] opacity-[0.09]" :style="{ color: envelope.accent }">{{ view.couple.monogram }}</span>
                    </div>

                    <!-- fine border -->
                    <template v-if="!isMinimal">
                        <div class="absolute inset-2 rounded-xl border" :style="{ borderColor: envelope.accent + '40' }" />
                        <div class="absolute inset-3 rounded-lg border opacity-50" :style="{ borderColor: envelope.accent + '22' }" />
                    </template>

                    <!-- corner ornaments -->
                    <template v-if="isFloral">
                        <Flower2 class="absolute start-3 top-3 size-5 opacity-45" :style="{ color: envelope.accent }" />
                        <Flower2 class="absolute end-3 top-3 size-5 opacity-45" :style="{ color: envelope.accent }" />
                        <Leaf class="absolute bottom-4 start-4 size-4 -rotate-12 opacity-30" :style="{ color: envelope.accent }" />
                        <Leaf class="absolute bottom-4 end-4 size-4 rotate-12 opacity-30" :style="{ color: envelope.accent }" />
                    </template>
                    <template v-else-if="isDeco">
                        <span class="absolute start-3 top-3 h-7 w-7 border-s-2 border-t-2" :style="{ borderColor: envelope.accent }" />
                        <span class="absolute end-3 top-3 h-7 w-7 border-e-2 border-t-2" :style="{ borderColor: envelope.accent }" />
                        <span class="absolute bottom-3 start-3 h-7 w-7 border-b-2 border-s-2" :style="{ borderColor: envelope.accent }" />
                        <span class="absolute bottom-3 end-3 h-7 w-7 border-b-2 border-e-2" :style="{ borderColor: envelope.accent }" />
                    </template>
                    <template v-else-if="isArabesque">
                        <Star class="absolute start-4 top-3 size-4 opacity-55" :style="{ color: envelope.accent }" />
                        <Star class="absolute end-4 top-3 size-4 opacity-55" :style="{ color: envelope.accent }" />
                        <Diamond class="absolute bottom-4 start-5 size-3 rotate-45 opacity-40" :style="{ color: envelope.accent }" />
                        <Diamond class="absolute bottom-4 end-5 size-3 rotate-45 opacity-40" :style="{ color: envelope.accent }" />
                    </template>
                    <template v-else-if="isNight">
                        <Moon class="absolute start-4 top-3 size-4 opacity-70" :style="{ color: envelope.accent }" />
                        <Star class="absolute end-4 top-3 size-3 opacity-70" :style="{ color: envelope.accent }" />
                        <Star class="absolute bottom-5 end-8 size-2.5 opacity-50" :style="{ color: envelope.accent }" />
                    </template>
                    <template v-else-if="!isMinimal">
                        <Sparkles class="absolute start-4 top-4 size-3.5 opacity-60" :style="{ color: envelope.accent }" />
                        <Sparkles class="absolute end-4 top-4 size-3.5 opacity-60" :style="{ color: envelope.accent }" />
                    </template>
                </div>

                <!-- silk ribbon -->
                <div v-if="isRibbon" class="pointer-events-none absolute inset-y-0 start-1/2 z-[25] w-9 -translate-x-1/2" :style="{ background: `linear-gradient(90deg, ${envelope.accent}bb, ${envelope.accent}, ${envelope.accent}bb)` }">
                    <span class="absolute inset-y-0 start-0 w-px bg-white/30" />
                    <span class="absolute inset-y-0 end-0 w-px bg-black/10" />
                </div>

                <!-- flap -->
                <div class="flap absolute inset-x-0 top-0 z-30 h-[62%] origin-top" :style="{ transformStyle: 'preserve-3d' }">
                    <svg viewBox="0 0 100 60" preserveAspectRatio="none" class="h-full w-full drop-shadow-sm">
                        <path :d="styleDef.flap" :fill="envelope.paper" :stroke="envelope.accent + '66'" stroke-width="0.7" stroke-linejoin="round" />
                        <path v-if="!isMinimal" :d="innerFlapPath" fill="none" :stroke="envelope.accent + '44'" stroke-width="0.5" />

                        <template v-if="isDeco">
                            <path d="M14 10 L34 10 M66 10 L86 10" :stroke="envelope.accent + '66'" stroke-width="0.6" />
                            <path d="M50 13 L50 30" :stroke="envelope.accent + '55'" stroke-width="0.5" />
                        </template>
                        <template v-if="isArabesque">
                            <path d="M16 8 C30 14, 39 21, 50 33 C61 21, 70 14, 84 8" fill="none" :stroke="envelope.accent + '55'" stroke-width="0.5" />
                            <circle cx="50" cy="35" r="1.1" :fill="envelope.accent" opacity="0.55" />
                        </template>
                        <template v-if="isNight">
                            <circle cx="20" cy="12" r="0.8" fill="#fff" opacity="0.7" />
                            <circle cx="70" cy="9" r="0.6" fill="#fff" opacity="0.6" />
                            <circle cx="82" cy="16" r="0.9" fill="#fff" opacity="0.5" />
                        </template>
                    </svg>
                </div>

                <!-- ribbon tails -->
                <div v-if="isRibbon" class="pointer-events-none absolute left-1/2 top-[52%] z-[35] flex -translate-x-1/2 -translate-y-1/2 gap-1" aria-hidden="true">
                    <span class="h-9 w-4 -rotate-[16deg] rounded-b-full opacity-90" :style="{ background: envelope.accent }" />
                    <span class="h-9 w-4 rotate-[16deg] rounded-b-full opacity-90" :style="{ background: envelope.accent }" />
                </div>

                <!-- seal -->
                <div
                    class="seal absolute left-1/2 top-[52%] z-40 flex size-16 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full shadow-[0_8px_20px_-8px_rgba(0,0,0,.55)] sm:size-[74px]"
                    :style="{ background: `radial-gradient(circle at 35% 30%, ${envelope.seal}dd, ${envelope.seal})` }"
                    :class="{ 'ring-4 ring-white/20': isRibbon }"
                >
                    <div class="flex size-[82%] flex-col items-center justify-center rounded-full border border-white/25">
                        <component :is="sealIcon" v-if="sealIcon" class="size-4 text-white/85" />
                        <span v-else class="text-sm font-semibold tracking-wider text-white/90">{{ view.couple.monogram }}</span>
                        <span class="mt-0.5 text-[6px] uppercase tracking-widest text-white/60">{{ t('brand.latin') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.envelope {
    perspective: 1200px;
}

.envelope.is-opening .flap {
    animation: flap-open 0.95s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

.envelope.is-opening .seal {
    animation: seal-pop 0.55s ease forwards;
}

.envelope.is-opening .card-peek {
    animation: card-rise 1.15s cubic-bezier(0.22, 1, 0.36, 1) 0.3s forwards;
}

.envelope.is-opening {
    animation: envelope-sink 0.6s ease 0.9s forwards;
}

@keyframes flap-open {
    0% { transform: rotateX(0deg); }
    100% { transform: rotateX(-172deg); }
}

@keyframes seal-pop {
    0% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
    45% { transform: translate(-50%, -50%) scale(1.18) rotate(8deg); opacity: 1; }
    100% { transform: translate(-50%, -50%) scale(0.5) rotate(18deg); opacity: 0; }
}

@keyframes card-rise {
    0% { transform: translateY(0); opacity: 0.2; }
    45% { opacity: 1; }
    100% { transform: translateY(-46%); }
}

@keyframes envelope-sink {
    to { transform: translateY(20px) scale(0.98); opacity: 0.9; }
}
</style>
