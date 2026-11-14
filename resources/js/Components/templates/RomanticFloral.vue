<script setup>
import { Flower2, Heart, Sparkles, Leaf } from 'lucide-vue-next';
import { translate } from '../../i18n';
import WakilDisplay from '../WakilDisplay.vue';
import InvitationLead from '../InvitationLead.vue';
import NameOrnament from '../NameOrnament.vue';
import EventDetails from '../EventDetails.vue';
import CountdownTimer from '../CountdownTimer.vue';

const props = defineProps({ view: { type: Object, required: true } });
const t = (key) => translate(key, props.view.lang);
</script>

<template>
    <div class="invitation-surface relative px-4 py-10 sm:px-8 sm:py-14" :dir="view.dir" :style="{ fontFamily: view.fontFamily }">
        <div class="pointer-events-none absolute -start-16 -top-20 size-56 rounded-full opacity-30 blur-3xl" :style="{ background: view.design.secondary_color }" />
        <div class="pointer-events-none absolute -bottom-20 -end-16 size-64 rounded-full opacity-20 blur-3xl" :style="{ background: view.design.primary_color }" />

        <div v-if="view.design.show_florals" class="pointer-events-none absolute start-3 top-5 opacity-50" :style="{ color: view.design.decorative_color }">
            <Flower2 class="size-20 -rotate-12" stroke-width="0.8" />
        </div>
        <div v-if="view.design.show_florals" class="pointer-events-none absolute end-3 bottom-5 opacity-50" :style="{ color: view.design.decorative_color }">
            <Leaf class="size-20 rotate-12" stroke-width="0.8" />
        </div>

        <div class="relative mx-auto max-w-2xl">
            <div class="text-center">
                <div class="mx-auto flex size-16 items-center justify-center rounded-full border-2 border-dashed" :style="{ borderColor: view.design.decorative_color + '88' }">
                    <Heart class="size-6" :style="{ color: view.design.primary_color }" />
                </div>
                <p class="mt-4 text-[12px] font-bold uppercase tracking-[0.35em] opacity-60">{{ view.content.title }}</p>
                <p v-if="view.content.religious" class="mx-auto mt-5 max-w-md text-[15px] leading-8 opacity-70">{{ view.content.religious }}</p>
                <p v-if="view.content.intro" class="mx-auto mt-5 max-w-md text-[12px] leading-7 opacity-65">{{ view.content.intro }}</p>
            </div>

            <div v-if="view.wakils.hasAny" class="relative mt-8 grid grid-cols-2 gap-4" dir="ltr">
                <WakilDisplay
                    :wakil="view.wakils.groom"
                    :lang="view.lang"
                    variant="default"
                    :class="view.couple.groomRight ? 'order-2' : 'order-1'"
                />
                <div class="absolute inset-y-2 start-1/2 hidden w-px -translate-x-1/2 sm:block" :style="{ background: view.design.decorative_color + '44' }" />
                <WakilDisplay
                    :wakil="view.wakils.bride"
                    :lang="view.lang"
                    variant="default"
                    :class="view.couple.groomRight ? 'order-1' : 'order-2'"
                />
            </div>

            <InvitationLead
                v-if="view.content.inviteLine"
                class="mt-8"
                :text="view.content.inviteLine"
                :lang="view.lang"
                :color="view.design.primary_color"
                :ornament="view.design.decorative_color"
            />

            <div class="my-7 flex items-center justify-center gap-3" :style="{ color: view.design.decorative_color }">
                <span class="h-px w-14" :style="{ background: 'currentColor' }" />
                <Heart class="size-4 fill-current opacity-70" />
                <span class="h-px w-14" :style="{ background: 'currentColor' }" />
            </div>

            <div class="grid grid-cols-1 items-center gap-4 text-center sm:grid-cols-[1fr_auto_1fr]" dir="ltr">
                <div :dir="view.dir" :class="view.couple.groomRight ? 'sm:order-3' : 'sm:order-1'">
                    <p class="text-[9px] font-bold uppercase tracking-[0.3em] opacity-45">{{ t('public.groom') }}</p>
                    <NameOrnament
                        class="mt-1"
                        :name="view.couple.groom"
                        :lang="view.lang"
                        size="lg"
                        :color="view.design.primary_color"
                        :ornament="view.design.decorative_color"
                        motif="flower"
                    />
                </div>
                <div class="order-2 flex flex-col items-center gap-1">
                    <span class="text-lg italic opacity-50">&</span>
                    <Sparkles class="size-4" :style="{ color: view.design.decorative_color }" />
                </div>
                <div :dir="view.dir" :class="view.couple.groomRight ? 'sm:order-1' : 'sm:order-3'">
                    <p class="text-[9px] font-bold uppercase tracking-[0.3em] opacity-45">{{ t('public.bride') }}</p>
                    <NameOrnament
                        class="mt-1"
                        :name="view.couple.bride"
                        :lang="view.lang"
                        size="lg"
                        :color="view.design.primary_color"
                        :ornament="view.design.decorative_color"
                        motif="leaf"
                    />
                </div>
            </div>

            <p v-if="view.couple.note" class="mt-3 text-center text-[11px] tracking-wide opacity-55">{{ view.couple.note }}</p>

            <div v-if="view.images.cover" class="mx-auto mt-7 max-w-md">
                <div class="rounded-[50%_50%_1.2rem_1.2rem] border-4 p-1.5" :style="{ borderColor: view.design.decorative_color + '66' }">
                    <img :src="view.images.cover" alt="" class="h-52 w-full rounded-[50%_50%_1rem_1rem] object-cover" loading="lazy" />
                </div>
            </div>

            <p v-if="view.content.message" class="mx-auto mt-7 max-w-lg text-center text-[13px] leading-8 opacity-75">{{ view.content.message }}</p>

            <div class="mt-8 rounded-[1.5rem] border px-4 py-5 sm:px-6" :style="{ borderColor: view.design.decorative_color + '44', background: 'rgba(255,255,255,.4)' }">
                <EventDetails :view="view" :lang="view.lang" variant="light" />
            </div>

            <CountdownTimer v-if="view.event.startIso" class="mt-7" :target="view.event.startIso" :lang="view.lang" variant="light" />

            <div v-if="view.content.additional" class="mx-auto mt-7 max-w-md text-center text-[11px] leading-7 opacity-65">
                {{ view.content.additional }}
            </div>

            <div class="mt-8 text-center">
                <Flower2 class="mx-auto size-5" :style="{ color: view.design.decorative_color }" />
                <p v-if="view.content.closing" class="mx-auto mt-3 max-w-sm text-sm leading-7 opacity-70">{{ view.content.closing }}</p>
                <p v-if="view.design.show_monogram" class="mt-5 text-xs tracking-[0.4em]" :style="{ color: view.design.primary_color }">{{ view.couple.monogram }}</p>
            </div>
        </div>
    </div>
</template>
