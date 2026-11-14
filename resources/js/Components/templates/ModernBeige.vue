<script setup>
import { ArrowDown, Sparkles } from 'lucide-vue-next';
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
        <div class="mx-auto max-w-3xl">
            <div v-if="view.images.cover" class="relative mb-8 overflow-hidden rounded-[1.6rem]">
                <img :src="view.images.cover" alt="" class="h-56 w-full object-cover sm:h-72" loading="lazy" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/45 to-transparent" />
                <p class="absolute bottom-4 start-5 text-base text-white/90">{{ view.content.title }}</p>
            </div>

            <div class="grid gap-8 sm:grid-cols-[1.15fr_.85fr]">
                <div>
                    <p class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-[9px] font-bold uppercase tracking-[0.28em]" :style="{ borderColor: view.design.decorative_color + '77', color: view.design.primary_color }">
                        <Sparkles class="size-3" />
                        {{ view.content.title }}
                    </p>

                    <p v-if="view.content.religious" class="mt-6 max-w-md text-[15px] leading-8 opacity-70">{{ view.content.religious }}</p>
                    <p v-if="view.content.intro" class="mt-4 max-w-md text-[12px] leading-7 opacity-65">{{ view.content.intro }}</p>

                    <div v-if="view.wakils.hasAny" class="mt-7 grid grid-cols-2 gap-4 border-t pt-6" :style="{ borderColor: view.design.decorative_color + '44' }" dir="ltr">
                        <WakilDisplay
                            :wakil="view.wakils.groom"
                            :lang="view.lang"
                            variant="minimal"
                            align="start"
                            :class="view.couple.groomRight ? 'order-2' : 'order-1'"
                        />
                        <WakilDisplay
                            :wakil="view.wakils.bride"
                            :lang="view.lang"
                            variant="minimal"
                            align="start"
                            :class="view.couple.groomRight ? 'order-1' : 'order-2'"
                        />
                    </div>

                    <InvitationLead
                        v-if="view.content.inviteLine"
                        class="mt-6"
                        :text="view.content.inviteLine"
                        :lang="view.lang"
                        :color="view.design.primary_color"
                        :ornament="view.design.decorative_color"
                    />

                    <div class="mt-6 border-t pt-6" :style="{ borderColor: view.design.decorative_color + '44' }">
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] opacity-40">{{ t('public.groom') }} <span class="mx-1 opacity-40">&</span> {{ t('public.bride') }}</p>
                        <div class="mt-3 grid grid-cols-2 gap-3">
                            <NameOrnament
                                :name="view.couple.groom"
                                :lang="view.lang"
                                size="lg"
                                :color="view.design.primary_color"
                                :ornament="view.design.decorative_color"
                                motif="sparkle"
                            />
                            <NameOrnament
                                :name="view.couple.bride"
                                :lang="view.lang"
                                size="lg"
                                :color="view.design.primary_color"
                                :ornament="view.design.decorative_color"
                                motif="leaf"
                            />
                        </div>
                        <p v-if="view.couple.note" class="mt-2 text-[11px] leading-6 opacity-55">{{ view.couple.note }}</p>
                    </div>
                </div>

                <div class="flex flex-col justify-end rounded-[1.4rem] border px-5 py-6" :style="{ borderColor: view.design.decorative_color + '55', background: 'rgba(255,255,255,.35)' }">
                    <p class="text-[9px] font-bold uppercase tracking-[0.3em] opacity-40">{{ t('public.date') }}</p>
                    <p class="mt-2 text-lg font-semibold leading-7">{{ view.event.dateFormatted || '—' }}</p>
                    <div class="my-4 flex items-center gap-2 opacity-40">
                        <span class="h-px flex-1 bg-current" />
                        <ArrowDown class="size-3" />
                        <span class="h-px flex-1 bg-current" />
                    </div>
                    <p class="text-sm font-bold">{{ view.event.venueName || '—' }}</p>
                    <p v-if="view.event.venueAddress" class="mt-1 text-[11px] leading-5 opacity-60">{{ view.event.venueAddress }}</p>
                </div>
            </div>

            <p v-if="view.content.message" class="mt-9 max-w-2xl text-[13px] leading-8 opacity-75">{{ view.content.message }}</p>

            <div class="mt-8">
                <EventDetails :view="view" :lang="view.lang" variant="light" />
            </div>

            <CountdownTimer v-if="view.event.startIso" class="mt-8" :target="view.event.startIso" :lang="view.lang" variant="light" />

            <div v-if="view.content.additional" class="mt-8 rounded-2xl bg-black/[0.03] px-5 py-4 text-[11px] leading-7 opacity-65">
                {{ view.content.additional }}
            </div>

            <div class="mt-8 flex flex-wrap items-end justify-between gap-4 border-t pt-6" :style="{ borderColor: view.design.decorative_color + '44' }">
                <p v-if="view.content.closing" class="max-w-md text-sm leading-7 opacity-70">{{ view.content.closing }}</p>
                <p v-if="view.design.show_monogram" class="text-xl tracking-[0.3em]" :style="{ color: view.design.primary_color }">{{ view.couple.monogram }}</p>
            </div>
        </div>
    </div>
</template>
