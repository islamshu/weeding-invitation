<script setup>
import { Heart, Flower2, Sparkles } from 'lucide-vue-next';
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
    <div class="invitation-surface relative px-4 py-8 sm:px-8 sm:py-12" :dir="view.dir" :style="{ fontFamily: view.fontFamily }">
        <!-- lace edge -->
        <div class="pointer-events-none absolute inset-x-0 top-0 h-4 opacity-30" :style="{ color: view.design.decorative_color, backgroundImage: 'radial-gradient(circle at 50% 0, transparent 6px, currentColor 6.5px, currentColor 7.5px, transparent 8px)', backgroundSize: '18px 10px', backgroundRepeat: 'repeat-x' }" />
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-4 rotate-180 opacity-30" :style="{ color: view.design.decorative_color, backgroundImage: 'radial-gradient(circle at 50% 0, transparent 6px, currentColor 6.5px, currentColor 7.5px, transparent 8px)', backgroundSize: '18px 10px', backgroundRepeat: 'repeat-x' }" />

        <div class="relative mx-auto max-w-2xl">
            <div class="overflow-hidden rounded-t-[10rem] border bg-white/45 px-5 pb-9 pt-14 shadow-[0_25px_70px_-45px_rgba(178,99,122,.5)] sm:px-10 sm:pt-16" :style="{ borderColor: view.design.decorative_color + '88' }">
                <div class="text-center">
                    <div class="mx-auto flex size-14 items-center justify-center rounded-full border-2 border-dashed" :style="{ borderColor: view.design.decorative_color + '77', color: view.design.primary_color }">
                        <Flower2 class="size-6" />
                    </div>

                    <p class="mt-4 text-[11px] font-bold uppercase tracking-[0.42em] opacity-55">{{ view.content.title }}</p>
                    <p v-if="view.content.religious" class="mx-auto mt-4 max-w-md text-[14px] leading-8 opacity-65">{{ view.content.religious }}</p>
                    <p v-if="view.content.intro" class="mx-auto mt-4 max-w-md text-[12px] leading-7 opacity-60">{{ view.content.intro }}</p>

                    <div v-if="view.wakils.hasAny" class="mt-7 grid grid-cols-2 gap-3 sm:gap-6" dir="ltr">
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

                    <div class="mx-auto my-6 flex items-center justify-center gap-2 opacity-60" :style="{ color: view.design.decorative_color }">
                        <Heart class="size-3 fill-current" />
                        <span class="h-px w-24 bg-current" />
                        <Heart class="size-3 fill-current" />
                    </div>

                    <div class="grid grid-cols-[1fr_auto_1fr] items-center gap-2 sm:gap-5" dir="ltr">
                        <div :dir="view.dir" :class="view.couple.groomRight ? 'order-3' : 'order-1'">
                            <p class="text-[8px] font-bold uppercase tracking-[0.3em] opacity-40">{{ t('public.groom') }}</p>
                            <NameOrnament
                                class="mt-1"
                                :name="view.couple.groom"
                                :lang="view.lang"
                                size="md"
                                :color="view.design.primary_color"
                                :ornament="view.design.decorative_color"
                                motif="heart"
                            />
                        </div>
                        <div class="order-2 flex size-10 items-center justify-center rounded-full border bg-white/60" :style="{ borderColor: view.design.decorative_color + '88' }">
                            <Heart class="size-4" :style="{ color: view.design.primary_color }" />
                        </div>
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

                    <div v-if="view.images.cover" class="mx-auto mt-6 max-w-sm rounded-[50%_50%_1rem_1rem] border-4 border-white p-1 shadow-md">
                        <img :src="view.images.cover" alt="" class="h-44 w-full rounded-[50%_50%_.8rem_.8rem] object-cover" loading="lazy" />
                    </div>

                    <p v-if="view.content.message" class="mx-auto mt-6 max-w-lg text-[13px] leading-8 opacity-70">{{ view.content.message }}</p>

                    <div class="mt-7 text-start">
                        <EventDetails :view="view" :lang="view.lang" variant="light" />
                    </div>

                    <CountdownTimer v-if="view.event.startIso" class="mt-7" :target="view.event.startIso" :lang="view.lang" variant="light" />

                    <div v-if="view.content.additional" class="mx-auto mt-7 max-w-md rounded-full border px-5 py-2.5 text-[11px] leading-6" :style="{ borderColor: view.design.decorative_color + '66' }">
                        {{ view.content.additional }}
                    </div>

                    <div class="mt-8">
                        <Sparkles class="mx-auto size-4 opacity-50" :style="{ color: view.design.decorative_color }" />
                        <p v-if="view.content.closing" class="mx-auto mt-3 max-w-sm text-sm leading-7 opacity-65">{{ view.content.closing }}</p>
                        <p v-if="view.design.show_monogram" class="mt-5 text-[10px] uppercase tracking-[0.5em]" :style="{ color: view.design.primary_color }">{{ view.couple.monogram }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
