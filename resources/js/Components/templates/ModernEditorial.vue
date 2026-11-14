<script setup>
import { ArrowDownRight, Sparkles } from 'lucide-vue-next';
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
            <div class="flex items-start justify-between gap-4 border-b pb-3" :style="{ borderColor: view.design.decorative_color + '77' }">
                <p class="text-[11px] font-bold uppercase tracking-[0.3em] opacity-50">{{ view.content.title }}</p>
                <p class="text-[9px] font-bold uppercase tracking-[0.3em] opacity-40">{{ view.event.dateShort || '—' }}</p>
            </div>

            <div class="mt-8 grid gap-8 lg:grid-cols-[1.35fr_.65fr]">
                <div>
                    <p v-if="view.content.religious" class="max-w-xl text-[14px] leading-8 opacity-55">{{ view.content.religious }}</p>

                    <div class="mt-6 border-t pt-6" :style="{ borderColor: view.design.decorative_color + '33' }">
                        <p class="text-[9px] font-bold uppercase tracking-[0.3em] opacity-40">01 / {{ t('wizard.steps.wakils') }}</p>
                        <div v-if="view.wakils.hasAny" class="mt-4 grid grid-cols-2 gap-4 sm:gap-6" dir="ltr">
                            <WakilDisplay
                                :wakil="view.wakils.groom"
                                :lang="view.lang"
                                align="start"
                                variant="default"
                                :class="view.couple.groomRight ? 'order-2' : 'order-1'"
                            />
                            <WakilDisplay
                                :wakil="view.wakils.bride"
                                :lang="view.lang"
                                align="start"
                                variant="default"
                                :class="view.couple.groomRight ? 'order-1' : 'order-2'"
                            />
                        </div>
                    </div>

                    <InvitationLead
                        v-if="view.content.inviteLine"
                        class="mt-6"
                        :text="view.content.inviteLine"
                        :lang="view.lang"
                        :color="view.design.text_color"
                        :ornament="view.design.decorative_color"
                    />

                    <div class="mt-6 grid grid-cols-[1fr_auto_1fr] items-center gap-2" dir="ltr">
                        <NameOrnament
                            :name="view.couple.groom"
                            :lang="view.lang"
                            size="xl"
                            :color="view.design.text_color"
                            :ornament="view.design.decorative_color"
                            motif="grid"
                        />
                        <span class="text-2xl font-light opacity-30">&</span>
                        <NameOrnament
                            :name="view.couple.bride"
                            :lang="view.lang"
                            size="xl"
                            :color="view.design.text_color"
                            :ornament="view.design.decorative_color"
                            motif="line"
                        />
                    </div>

                    <p v-if="view.couple.note" class="mt-3 text-[11px] leading-6 opacity-50">{{ view.couple.note }}</p>

                    <p v-if="view.content.message" class="mt-7 max-w-xl text-[13px] leading-8 opacity-70">{{ view.content.message }}</p>

                    <div v-if="view.images.cover" class="mt-7 overflow-hidden">
                        <img :src="view.images.cover" alt="" class="h-56 w-full object-cover sm:h-72" loading="lazy" />
                    </div>
                </div>

                <div class="flex flex-col gap-5">
                    <div class="border-t-2 pt-4" :style="{ borderColor: view.design.primary_color }">
                        <p class="text-[9px] font-bold uppercase tracking-[0.3em] opacity-40">02 / {{ t('public.eventDetails') }}</p>
                        <p class="mt-3 text-lg leading-7">{{ view.event.dateFormatted || '—' }}</p>
                        <p class="mt-1 text-[11px] font-semibold tracking-wide opacity-70">{{ view.event.timeFormatted }}</p>
                        <div class="mt-4 h-px" :style="{ background: view.design.decorative_color + '55' }" />
                        <p class="mt-4 text-sm font-bold">{{ view.event.venueName || '—' }}</p>
                        <p v-if="view.event.venueAddress" class="mt-1 text-[11px] leading-5 opacity-55">{{ view.event.venueAddress }}</p>
                        <a
                            v-if="view.event.mapsUrl"
                            :href="view.event.mapsUrl"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-3 inline-flex items-center gap-1.5 border-b pb-0.5 text-[10px] font-bold uppercase tracking-widest transition hover:opacity-70"
                            :style="{ borderColor: view.design.primary_color, color: view.design.primary_color }"
                        >
                            {{ t('public.openMaps') }}
                            <ArrowDownRight class="size-3" />
                        </a>
                    </div>

                    <div v-if="view.event.henna.enabled || view.event.reception.enabled" class="border-t pt-4" :style="{ borderColor: view.design.decorative_color + '33' }">
                        <p class="text-[9px] font-bold uppercase tracking-[0.3em] opacity-40">03 / {{ t('public.additionalEvents') }}</p>
                        <div class="mt-3 space-y-3 text-[11px] leading-6 opacity-70">
                            <div v-if="view.event.henna.enabled">
                                <p class="font-bold">{{ t('public.henna') }}</p>
                                <p>{{ view.event.henna.dateFormatted }} · {{ view.event.henna.timeFormatted }}</p>
                                <p v-if="view.event.henna.location">{{ view.event.henna.location }}</p>
                            </div>
                            <div v-if="view.event.reception.enabled">
                                <p class="font-bold">{{ t('public.reception') }}</p>
                                <p>{{ view.event.reception.dateFormatted }} · {{ view.event.reception.timeFormatted }}</p>
                                <p v-if="view.event.reception.location">{{ view.event.reception.location }}</p>
                            </div>
                        </div>
                    </div>

                    <CountdownTimer v-if="view.event.startIso" class="border-t pt-4" :target="view.event.startIso" :lang="view.lang" variant="light" compact />
                </div>
            </div>

            <div v-if="view.content.additional" class="mt-8 border-y py-4 text-[11px] leading-7 opacity-60" :style="{ borderColor: view.design.decorative_color + '33' }">
                {{ view.content.additional }}
            </div>

            <div class="mt-8 flex items-end justify-between gap-4">
                <p v-if="view.content.closing" class="max-w-md text-[12px] leading-7 opacity-55">{{ view.content.closing }}</p>
                <div class="text-end">
                    <Sparkles v-if="view.design.show_monogram" class="ms-auto size-4 opacity-40" :style="{ color: view.design.primary_color }" />
                    <p v-if="view.design.show_monogram" class="mt-2 text-xl tracking-[0.2em]" :style="{ color: view.design.primary_color }">{{ view.couple.monogram }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
