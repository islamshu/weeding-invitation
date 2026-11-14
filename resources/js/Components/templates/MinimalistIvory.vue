<script setup>
import { Minus, Heart } from 'lucide-vue-next';
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
    <div class="invitation-surface px-5 py-12 sm:px-10 sm:py-16" :dir="view.dir" :style="{ fontFamily: view.fontFamily }">
        <div class="mx-auto max-w-2xl">
            <div class="flex items-center justify-between gap-4">
                <span class="h-px flex-1" :style="{ background: view.design.decorative_color + '66' }" />
                <p class="text-[11px] font-bold uppercase tracking-[0.4em]" :style="{ color: view.design.primary_color }">{{ view.content.title }}</p>
                <span class="h-px flex-1" :style="{ background: view.design.decorative_color + '66' }" />
            </div>

            <div v-if="view.images.cover" class="mt-8 overflow-hidden rounded-sm">
                <img :src="view.images.cover" alt="" class="h-48 w-full object-cover sm:h-64" loading="lazy" />
            </div>

            <p v-if="view.content.religious" class="mt-8 text-center text-[14px] leading-8 opacity-60">{{ view.content.religious }}</p>

            <p v-if="view.content.intro" class="mx-auto mt-6 max-w-md text-center text-[12px] leading-7 opacity-65">{{ view.content.intro }}</p>

            <!-- representatives -->
            <div v-if="view.wakils.hasAny" class="mt-10 grid grid-cols-2 gap-5 border-y py-7" :style="{ borderColor: view.design.decorative_color + '44' }" dir="ltr">
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
                class="mt-8"
                :text="view.content.inviteLine"
                :lang="view.lang"
                :color="view.design.primary_color"
                :ornament="view.design.decorative_color"
            />

            <!-- couple -->
            <div class="mt-8 grid grid-cols-[1fr_auto_1fr] items-center gap-4" dir="ltr">
                <div :dir="view.dir" :class="view.couple.groomRight ? 'order-3' : 'order-1'" class="text-center">
                    <p class="text-[8px] font-bold uppercase tracking-[0.35em] opacity-40">{{ t('public.groom') }}</p>
                    <NameOrnament
                        class="mt-2"
                        :name="view.couple.groom"
                        :lang="view.lang"
                        size="sm"
                        :color="view.design.text_color"
                        :ornament="view.design.decorative_color"
                        motif="line"
                    />
                </div>
                <div class="order-2 flex flex-col items-center gap-1.5">
                    <Minus class="size-4 opacity-30" :style="{ color: view.design.decorative_color }" />
                    <span class="text-sm italic opacity-50">&</span>
                    <Minus class="size-4 opacity-30" :style="{ color: view.design.decorative_color }" />
                </div>
                <div :dir="view.dir" :class="view.couple.groomRight ? 'order-1' : 'order-3'" class="text-center">
                    <p class="text-[8px] font-bold uppercase tracking-[0.35em] opacity-40">{{ t('public.bride') }}</p>
                    <NameOrnament
                        class="mt-2"
                        :name="view.couple.bride"
                        :lang="view.lang"
                        size="sm"
                        :color="view.design.text_color"
                        :ornament="view.design.decorative_color"
                        motif="ring"
                    />
                </div>
            </div>

            <p v-if="view.couple.note" class="mt-4 text-center text-[10px] tracking-wide opacity-50">{{ view.couple.note }}</p>

            <p v-if="view.content.message" class="mx-auto mt-8 max-w-lg text-center text-[13px] leading-8 opacity-70">{{ view.content.message }}</p>

            <div class="mt-9">
                <EventDetails :view="view" :lang="view.lang" variant="minimal" />
            </div>

            <CountdownTimer v-if="view.event.startIso" class="mt-8" :target="view.event.startIso" :lang="view.lang" variant="light" compact />

            <div v-if="view.content.additional" class="mt-8 border-s-2 ps-4 text-[11px] leading-7 opacity-60" :style="{ borderColor: view.design.decorative_color }">
                {{ view.content.additional }}
            </div>

            <div class="mt-9 text-center">
                <Heart class="mx-auto size-3.5" :style="{ color: view.design.decorative_color }" />
                <p v-if="view.content.closing" class="mx-auto mt-3 max-w-sm text-[11px] leading-6 opacity-55">{{ view.content.closing }}</p>
                <p v-if="view.design.show_monogram" class="mt-5 text-[11px] uppercase tracking-[0.5em]" :style="{ color: view.design.primary_color }">{{ view.couple.monogram }}</p>
            </div>
        </div>
    </div>
</template>
