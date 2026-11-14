<script setup>
import { Sparkles, Heart, Diamond } from 'lucide-vue-next';
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
    <div class="invitation-surface px-4 py-10 sm:px-8 sm:py-14" :dir="view.dir" :style="{ fontFamily: view.fontFamily }">
        <div class="mx-auto max-w-2xl">
            <div class="relative overflow-hidden rounded-[2rem] border border-white/70 bg-white/60 p-1 shadow-[0_25px_70px_-40px_rgba(60,70,80,.4)] backdrop-blur">
                <div class="relative overflow-hidden rounded-[1.8rem] border px-5 py-9 sm:px-10 sm:py-12" :style="{ borderColor: view.design.decorative_color + '66' }">
                    <div class="pointer-events-none absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-white to-transparent" />
                    <Sparkles class="pointer-events-none absolute end-6 top-6 size-5 opacity-30" :style="{ color: view.design.primary_color }" />
                    <Sparkles class="pointer-events-none absolute start-8 top-16 size-3 opacity-20" :style="{ color: view.design.primary_color }" />

                    <div class="relative text-center">
                        <div class="mx-auto flex size-14 items-center justify-center rounded-full border bg-white/80 shadow-sm" :style="{ borderColor: view.design.decorative_color + '77', color: view.design.primary_color }">
                            <Diamond class="size-5" />
                        </div>

                        <p class="mt-5 text-[11px] font-bold uppercase tracking-[0.45em] opacity-55">{{ view.content.title }}</p>

                        <p v-if="view.content.religious" class="mx-auto mt-5 max-w-md text-[14px] leading-8 opacity-65">{{ view.content.religious }}</p>
                        <p v-if="view.content.intro" class="mx-auto mt-4 max-w-md text-[12px] leading-7 opacity-60">{{ view.content.intro }}</p>

                        <div v-if="view.wakils.hasAny" class="mt-8 grid grid-cols-2 gap-3 rounded-2xl border border-white bg-white/50 px-3 py-5 sm:gap-5" dir="ltr">
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

                        <div class="mx-auto mt-7 flex items-center gap-3 opacity-50" :style="{ color: view.design.decorative_color }">
                            <span class="h-px w-14 bg-current" />
                            <Heart class="size-3" />
                            <span class="h-px w-14 bg-current" />
                        </div>

                        <div class="mt-5 grid grid-cols-[1fr_auto_1fr] items-center gap-3" dir="ltr">
                            <div :dir="view.dir" :class="view.couple.groomRight ? 'order-3' : 'order-1'">
                                <p class="text-[8px] font-bold uppercase tracking-[0.3em] opacity-40">{{ t('public.groom') }}</p>
                                <NameOrnament
                                    class="mt-1.5"
                                    :name="view.couple.groom"
                                    :lang="view.lang"
                                    size="md"
                                    :color="view.design.primary_color"
                                    :ornament="view.design.decorative_color"
                                    motif="ring"
                                />
                            </div>
                            <span class="order-2 text-lg italic opacity-40">&</span>
                            <div :dir="view.dir" :class="view.couple.groomRight ? 'order-1' : 'order-3'">
                                <p class="text-[8px] font-bold uppercase tracking-[0.3em] opacity-40">{{ t('public.bride') }}</p>
                                <NameOrnament
                                    class="mt-1.5"
                                    :name="view.couple.bride"
                                    :lang="view.lang"
                                    size="md"
                                    :color="view.design.primary_color"
                                    :ornament="view.design.decorative_color"
                                    motif="diamond"
                                />
                            </div>
                        </div>

                        <p v-if="view.couple.note" class="mt-2 text-[10px] opacity-50">{{ view.couple.note }}</p>

                        <div v-if="view.images.cover" class="mx-auto mt-6 max-w-sm overflow-hidden rounded-[1.4rem] border-4 border-white shadow-md">
                            <img :src="view.images.cover" alt="" class="h-44 w-full object-cover" loading="lazy" />
                        </div>

                        <p v-if="view.content.message" class="mx-auto mt-6 max-w-lg text-[12px] leading-8 opacity-65">{{ view.content.message }}</p>

                        <div class="mt-7 text-start">
                            <EventDetails :view="view" :lang="view.lang" variant="light" />
                        </div>

                        <CountdownTimer v-if="view.event.startIso" class="mt-7" :target="view.event.startIso" :lang="view.lang" variant="light" />

                        <div v-if="view.content.additional" class="mt-7 text-[11px] leading-7 opacity-55">{{ view.content.additional }}</div>

                        <div class="mt-8 flex items-center justify-center gap-2 opacity-40" :style="{ color: view.design.decorative_color }">
                            <Sparkles class="size-3" />
                            <span class="h-px w-16 bg-current" />
                            <Sparkles class="size-3" />
                        </div>
                        <p v-if="view.content.closing" class="mx-auto mt-3 max-w-sm text-[11px] leading-6 opacity-55">{{ view.content.closing }}</p>
                        <p v-if="view.design.show_monogram" class="mt-5 text-[10px] uppercase tracking-[0.5em]" :style="{ color: view.design.primary_color }">{{ view.couple.monogram }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
