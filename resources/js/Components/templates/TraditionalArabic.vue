<script setup>
import { Heart, Sparkles, Landmark } from 'lucide-vue-next';
import { translate } from '../../i18n';
import WakilDisplay from '../WakilDisplay.vue';
import InvitationLead from '../InvitationLead.vue';
import NameOrnament from '../NameOrnament.vue';
import EventDetails from '../EventDetails.vue';
import CountdownTimer from '../CountdownTimer.vue';

const props = defineProps({ view: { type: Object, required: true } });
const t = (key) => translate(key, props.view.lang);

const tatreez = {
    backgroundImage:
        'repeating-linear-gradient(45deg, currentColor 0 2px, transparent 2px 11px), repeating-linear-gradient(-45deg, currentColor 0 2px, transparent 2px 11px)',
};
</script>

<template>
    <div class="invitation-surface" :dir="view.dir" :style="{ fontFamily: view.fontFamily }">
        <!-- woven top band -->
        <div class="h-7 opacity-60" :style="{ ...tatreez, color: view.design.primary_color }" />
        <div class="h-[3px]" :style="{ background: view.design.decorative_color }" />

        <div class="px-4 py-9 sm:px-8 sm:py-12">
            <div class="relative mx-auto max-w-3xl border-2 p-2" :style="{ borderColor: view.design.primary_color }">
                <div class="relative border px-4 py-8 sm:px-10 sm:py-11" :style="{ borderColor: view.design.decorative_color + '88' }">
                    <div class="pointer-events-none absolute inset-0 opacity-[0.045]" :style="{ ...tatreez, color: view.design.primary_color }" />

                    <div class="relative text-center">
                        <p class="text-[13px] leading-8" :style="{ color: view.design.primary_color }">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>

                        <div class="mx-auto mt-4 flex w-32 items-center gap-2" :style="{ color: view.design.decorative_color }">
                            <span class="h-px flex-1 bg-current" />
                            <Landmark class="size-4" />
                            <span class="h-px flex-1 bg-current" />
                        </div>

                        <p class="mt-4 text-[12px] font-bold uppercase tracking-[0.35em]" :style="{ color: view.design.primary_color }">{{ view.content.title }}</p>

                        <p v-if="view.content.religious" class="mx-auto mt-4 max-w-lg text-[15px] leading-8 opacity-75">{{ view.content.religious }}</p>
                        <p v-if="view.content.intro" class="mx-auto mt-4 max-w-lg text-[12px] leading-7 opacity-70">{{ view.content.intro }}</p>

                        <!-- WAKIL SECTIONS: primary family blocks -->
                        <div v-if="view.wakils.hasAny" class="relative mt-8 grid grid-cols-2 gap-3 sm:gap-6" dir="ltr">
                            <div
                                class="absolute inset-y-0 start-1/2 hidden w-px -translate-x-1/2 sm:block"
                                :style="{ background: `linear-gradient(to bottom, transparent, ${view.design.decorative_color}, transparent)` }"
                            />
                            <div :class="view.couple.groomRight ? 'order-2' : 'order-1'">
                                <WakilDisplay :wakil="view.wakils.groom" :lang="view.lang" variant="plaque" />
                            </div>

                            <div :class="view.couple.groomRight ? 'order-1' : 'order-2'">
                                <WakilDisplay :wakil="view.wakils.bride" :lang="view.lang" variant="plaque" />
                            </div>
                        </div>

                        <InvitationLead
                            v-if="view.content.inviteLine"
                            class="mt-7"
                            :text="view.content.inviteLine"
                            :lang="view.lang"
                            :color="view.design.primary_color"
                            :ornament="view.design.decorative_color"
                        />

                        <!-- tatreez divider -->
                        <div class="my-6 flex items-center justify-center gap-4">
                            <span class="h-4 w-16 opacity-50" :style="{ ...tatreez, color: view.design.primary_color }" />
                            <Sparkles class="size-4" :style="{ color: view.design.decorative_color }" />
                            <span class="h-4 w-16 opacity-50" :style="{ ...tatreez, color: view.design.primary_color }" />
                        </div>

                        <!-- couple -->
                        <div class="relative grid grid-cols-[1fr_auto_1fr] items-center gap-2 sm:gap-5" dir="ltr">
                            <div
                                :dir="view.dir"
                                :class="view.couple.groomRight ? 'order-3' : 'order-1'"
                                class="rounded-2xl border px-2 py-4"
                                :style="{ borderColor: view.design.decorative_color + '55', background: view.design.decorative_color + '0d' }"
                            >
                                <p class="text-[8px] font-bold uppercase tracking-[0.28em] opacity-50">{{ t('public.groom') }}</p>
                                <NameOrnament
                                    class="mt-1.5"
                                    :name="view.couple.groom"
                                    :lang="view.lang"
                                    size="md"
                                    :color="view.design.primary_color"
                                    :ornament="view.design.decorative_color"
                                    motif="tatreez"
                                />
                            </div>

                            <div class="order-2 flex flex-col items-center gap-1.5 px-1">
                                <Heart class="size-5" :style="{ color: view.design.primary_color }" />
                                <span class="text-xs opacity-50">و</span>
                            </div>

                            <div
                                :dir="view.dir"
                                :class="view.couple.groomRight ? 'order-1' : 'order-3'"
                                class="rounded-2xl border px-2 py-4"
                                :style="{ borderColor: view.design.decorative_color + '55', background: view.design.decorative_color + '0d' }"
                            >
                                <p class="text-[8px] font-bold uppercase tracking-[0.28em] opacity-50">{{ t('public.bride') }}</p>
                                <NameOrnament
                                    class="mt-1.5"
                                    :name="view.couple.bride"
                                    :lang="view.lang"
                                    size="md"
                                    :color="view.design.primary_color"
                                    :ornament="view.design.decorative_color"
                                    motif="tatreez"
                                />
                            </div>
                        </div>

                        <p v-if="view.couple.note" class="mt-3 text-[10px] leading-6 opacity-60">{{ view.couple.note }}</p>

                        <div v-if="view.images.cover" class="mx-auto mt-6 max-w-md border-4 border-white p-1 shadow-md" :style="{ outline: `1px solid ${view.design.decorative_color}` }">
                            <img :src="view.images.cover" alt="" class="h-44 w-full object-cover sm:h-52" loading="lazy" />
                        </div>

                        <p v-if="view.content.message" class="mx-auto mt-6 max-w-xl text-[13px] leading-8 opacity-75">{{ view.content.message }}</p>

                        <div class="mt-7 rounded-2xl border-2 px-4 py-5" :style="{ borderColor: view.design.decorative_color + '44', background: 'rgba(255,255,255,.35)' }">
                            <EventDetails :view="view" :lang="view.lang" variant="light" />
                        </div>

                        <CountdownTimer v-if="view.event.startIso" class="mt-7" :target="view.event.startIso" :lang="view.lang" variant="light" />

                        <div v-if="view.content.additional" class="mx-auto mt-7 max-w-md border-y px-4 py-3 text-[11px] leading-7" :style="{ borderColor: view.design.decorative_color + '55' }">
                            {{ view.content.additional }}
                        </div>

                        <div class="mt-7">
                            <p v-if="view.content.closing" class="mx-auto max-w-md text-sm leading-7 opacity-75">{{ view.content.closing }}</p>
                            <p v-if="view.design.show_monogram" class="mt-4 text-lg tracking-[0.3em]" :style="{ color: view.design.primary_color }">{{ view.couple.monogram }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="h-[3px]" :style="{ background: view.design.decorative_color }" />
        <div class="h-7 opacity-60" :style="{ ...tatreez, color: view.design.primary_color }" />
    </div>
</template>
