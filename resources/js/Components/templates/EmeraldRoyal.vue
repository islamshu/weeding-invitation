<script setup>
import { Star, Sparkles, Moon } from 'lucide-vue-next';
import { translate } from '../../i18n';
import WakilDisplay from '../WakilDisplay.vue';
import InvitationLead from '../InvitationLead.vue';
import NameOrnament from '../NameOrnament.vue';
import EventDetails from '../EventDetails.vue';
import CountdownTimer from '../CountdownTimer.vue';

const props = defineProps({ view: { type: Object, required: true } });
const t = (key) => translate(key, props.view.lang);

const pattern = {
    backgroundImage:
        'radial-gradient(circle at 50% 50%, currentColor 1px, transparent 1.4px), radial-gradient(circle at 0 0, currentColor 1px, transparent 1.4px)',
    backgroundSize: '22px 22px',
};
</script>

<template>
    <div class="invitation-surface px-4 py-9 sm:px-8 sm:py-14" :dir="view.dir" :style="{ fontFamily: view.fontFamily }">
        <div class="relative mx-auto max-w-2xl">
            <div class="relative overflow-hidden rounded-t-[16rem] border-2 px-4 pb-10 pt-16 sm:px-10 sm:pt-20" :style="{ borderColor: view.design.decorative_color + '88' }">
                <div class="pointer-events-none absolute inset-0 opacity-[0.07]" :style="{ ...pattern, color: view.design.decorative_color }" />
                <div class="pointer-events-none absolute inset-x-6 bottom-0 top-10 rounded-t-[15rem] border opacity-30" :style="{ borderColor: view.design.decorative_color + '55' }" />

                <div class="relative text-center">
                    <div class="mx-auto flex size-16 items-center justify-center rounded-full border" :style="{ borderColor: view.design.decorative_color + '88', color: view.design.decorative_color }">
                        <Moon class="size-6" />
                    </div>

                    <p class="mt-4 text-[12px] font-semibold uppercase tracking-[0.5em]" :style="{ color: view.design.decorative_color }">{{ view.content.title }}</p>

                    <p v-if="view.content.religious" class="mx-auto mt-5 max-w-lg text-[14px] leading-8 text-white/60">{{ view.content.religious }}</p>
                    <p v-if="view.content.intro" class="mx-auto mt-4 max-w-md text-[11px] leading-7 text-white/45">{{ view.content.intro }}</p>

                    <div class="mx-auto mt-5 flex w-36 items-center gap-2 text-[color:var(--inv-decor)] opacity-70">
                        <span class="h-px flex-1 bg-current" />
                        <Star class="size-3" />
                        <span class="h-px flex-1 bg-current" />
                    </div>

                    <div v-if="view.wakils.hasAny" class="mt-7 grid grid-cols-2 gap-3 sm:gap-5" dir="ltr">
                        <WakilDisplay
                            :wakil="view.wakils.groom"
                            :lang="view.lang"
                            variant="glass"
                            :class="view.couple.groomRight ? 'order-2' : 'order-1'"
                        />
                        <WakilDisplay
                            :wakil="view.wakils.bride"
                            :lang="view.lang"
                            variant="glass"
                            :class="view.couple.groomRight ? 'order-1' : 'order-2'"
                        />
                    </div>

                    <InvitationLead
                        v-if="view.content.inviteLine"
                        class="mt-7"
                        :text="view.content.inviteLine"
                        :lang="view.lang"
                        :color="view.design.decorative_color"
                        :ornament="view.design.secondary_color"
                    />

                    <div class="my-6 flex items-center justify-center gap-2" :style="{ color: view.design.decorative_color }">
                        <Sparkles class="size-3" />
                        <span class="h-px w-32 bg-current opacity-50" />
                        <Sparkles class="size-3" />
                    </div>

                    <div class="grid grid-cols-[1fr_auto_1fr] items-center gap-2 sm:gap-5" dir="ltr">
                        <div :dir="view.dir" :class="view.couple.groomRight ? 'order-3' : 'order-1'">
                            <p class="text-[8px] font-bold uppercase tracking-[0.32em] text-white/35">{{ t('public.groom') }}</p>
                            <NameOrnament
                                class="mt-1.5"
                                :name="view.couple.groom"
                                :lang="view.lang"
                                size="md"
                                :color="view.design.decorative_color"
                                :ornament="view.design.secondary_color"
                                motif="arch"
                            />
                        </div>
                        <div class="order-2 flex size-10 items-center justify-center rounded-full border border-[color:var(--inv-decor)]/40 text-base text-white/60 sm:size-12">
                            {{ view.couple.monogram }}
                        </div>
                        <div :dir="view.dir" :class="view.couple.groomRight ? 'order-1' : 'order-3'">
                            <p class="text-[8px] font-bold uppercase tracking-[0.32em] text-white/35">{{ t('public.bride') }}</p>
                            <NameOrnament
                                class="mt-1.5"
                                :name="view.couple.bride"
                                :lang="view.lang"
                                size="md"
                                :color="view.design.decorative_color"
                                :ornament="view.design.secondary_color"
                                motif="star"
                            />
                        </div>
                    </div>

                    <p v-if="view.couple.note" class="mt-2 text-[10px] text-white/40">{{ view.couple.note }}</p>

                    <div v-if="view.images.cover" class="mx-auto mt-7 max-w-sm rounded-t-[4rem] border-2 p-1.5" :style="{ borderColor: view.design.decorative_color + '55' }">
                        <img :src="view.images.cover" alt="" class="h-48 w-full rounded-t-[3.6rem] object-cover sm:h-56" loading="lazy" />
                    </div>

                    <p v-if="view.content.message" class="mx-auto mt-7 max-w-lg text-[12px] leading-8 text-white/60">{{ view.content.message }}</p>

                    <div class="mt-7">
                        <EventDetails :view="view" :lang="view.lang" variant="emerald" />
                    </div>

                    <CountdownTimer v-if="view.event.startIso" class="mt-7" :target="view.event.startIso" :lang="view.lang" variant="emerald" />

                    <div v-if="view.content.additional" class="mx-auto mt-7 max-w-md rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3 text-[11px] leading-7 text-white/50">
                        {{ view.content.additional }}
                    </div>

                    <div class="mt-8">
                        <div class="mx-auto flex w-28 items-center gap-2 text-[color:var(--inv-decor)] opacity-60">
                            <span class="h-px flex-1 bg-current" />
                            <Star class="size-3" />
                            <span class="h-px flex-1 bg-current" />
                        </div>
                        <p v-if="view.content.closing" class="mx-auto mt-3 max-w-sm text-sm leading-7 text-white/65">{{ view.content.closing }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
