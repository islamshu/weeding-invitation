<script setup>
import { Leaf, Sprout, Heart } from 'lucide-vue-next';
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
        <div v-if="view.design.show_florals" class="pointer-events-none absolute -end-10 top-10 opacity-20" :style="{ color: view.design.primary_color }">
            <Leaf class="size-56 -rotate-12" stroke-width="0.6" />
        </div>
        <div v-if="view.design.show_florals" class="pointer-events-none absolute -start-12 bottom-12 opacity-20" :style="{ color: view.design.primary_color }">
            <Sprout class="size-56 rotate-12" stroke-width="0.6" />
        </div>

        <div class="relative mx-auto max-w-2xl overflow-hidden rounded-[2rem] border bg-white/35 px-5 py-9 shadow-[0_25px_70px_-45px_rgba(47,59,49,.55)] sm:px-9 sm:py-12" :style="{ borderColor: view.design.decorative_color + '66' }">
            <div class="pointer-events-none absolute -end-16 -top-16 size-40 rounded-full opacity-20 blur-2xl" :style="{ background: view.design.secondary_color }" />

            <div class="relative text-center">
                <div class="mx-auto flex size-14 items-center justify-center rounded-full border border-dashed" :style="{ borderColor: view.design.decorative_color + '88', color: view.design.primary_color }">
                    <Leaf class="size-6" />
                </div>

                <p class="mt-4 text-[11px] font-bold uppercase tracking-[0.4em] opacity-55">{{ view.content.title }}</p>

                <p v-if="view.content.religious" class="mx-auto mt-4 max-w-md text-[14px] leading-8 opacity-70">{{ view.content.religious }}</p>
                <p v-if="view.content.intro" class="mx-auto mt-4 max-w-md text-[12px] leading-7 opacity-65">{{ view.content.intro }}</p>

                <div v-if="view.wakils.hasAny" class="mt-7 grid grid-cols-2 gap-4" dir="ltr">
                    <WakilDisplay
                        :wakil="view.wakils.groom"
                        :lang="view.lang"
                        variant="default"
                        :class="view.couple.groomRight ? 'order-2' : 'order-1'"
                    />
                    <WakilDisplay
                        :wakil="view.wakils.bride"
                        :lang="view.lang"
                        variant="default"
                        :class="view.couple.groomRight ? 'order-1' : 'order-2'"
                    />
                </div>

                <InvitationLead
                    v-if="view.content.inviteLine"
                    class="mt-7"
                    :text="view.content.inviteLine"
                    :lang="view.lang"
                    :color="view.design.primary_color"
                    :ornament="view.design.decorative_color"
                />

                <div class="my-6 flex items-center justify-center gap-3" :style="{ color: view.design.decorative_color }">
                    <Leaf class="size-4 -scale-x-100" />
                    <span class="h-px w-20" :style="{ background: 'currentColor' }" />
                    <Leaf class="size-4" />
                </div>

                <div class="grid grid-cols-[1fr_auto_1fr] items-center gap-3 sm:gap-6" dir="ltr">
                    <div :dir="view.dir" :class="view.couple.groomRight ? 'order-3' : 'order-1'">
                        <p class="text-[8px] font-bold uppercase tracking-[0.3em] opacity-40">{{ t('public.groom') }}</p>
                        <NameOrnament
                            class="mt-1"
                            :name="view.couple.groom"
                            :lang="view.lang"
                            size="md"
                            :color="view.design.primary_color"
                            :ornament="view.design.decorative_color"
                            motif="leaf"
                        />
                    </div>
                    <Heart class="order-2 size-4 opacity-40" :style="{ color: view.design.decorative_color }" />
                    <div :dir="view.dir" :class="view.couple.groomRight ? 'order-1' : 'order-3'">
                        <p class="text-[8px] font-bold uppercase tracking-[0.3em] opacity-40">{{ t('public.bride') }}</p>
                        <NameOrnament
                            class="mt-1"
                            :name="view.couple.bride"
                            :lang="view.lang"
                            size="md"
                            :color="view.design.primary_color"
                            :ornament="view.design.decorative_color"
                            motif="flower"
                        />
                    </div>
                </div>

                <p v-if="view.couple.note" class="mt-2 text-[10px] opacity-50">{{ view.couple.note }}</p>

                <div v-if="view.images.cover" class="mx-auto mt-6 max-w-sm overflow-hidden rounded-[2rem_2rem_1rem_1rem] border-4 border-white/70 shadow-md">
                    <img :src="view.images.cover" alt="" class="h-44 w-full object-cover" loading="lazy" />
                </div>

                <p v-if="view.content.message" class="mx-auto mt-6 max-w-lg text-[13px] leading-8 opacity-70">{{ view.content.message }}</p>

                <div class="mt-7 text-start">
                    <EventDetails :view="view" :lang="view.lang" variant="light" />
                </div>

                <CountdownTimer v-if="view.event.startIso" class="mt-7" :target="view.event.startIso" :lang="view.lang" variant="light" />

                <div v-if="view.content.additional" class="mx-auto mt-7 max-w-md rounded-2xl bg-white/40 px-4 py-3 text-[11px] leading-7 opacity-65">
                    {{ view.content.additional }}
                </div>

                <div class="mt-8">
                    <Sprout class="mx-auto size-4 opacity-50" :style="{ color: view.design.primary_color }" />
                    <p v-if="view.content.closing" class="mx-auto mt-3 max-w-sm text-sm leading-7 opacity-70">{{ view.content.closing }}</p>
                    <p v-if="view.design.show_monogram" class="mt-5 text-[10px] uppercase tracking-[0.5em] opacity-60">{{ view.couple.monogram }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
