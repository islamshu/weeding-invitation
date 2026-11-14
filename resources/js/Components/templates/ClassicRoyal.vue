<script setup>
import { Crown, Heart, Sparkles, Quote } from 'lucide-vue-next';
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
    <div class="invitation-surface px-3 py-8 sm:px-6 sm:py-12" :dir="view.dir" :style="{ fontFamily: view.fontFamily }">
        <div
            class="relative mx-auto max-w-3xl rounded-[1.9rem] p-[2px] shadow-[0_30px_80px_-50px_rgba(61,44,21,.55)]"
            :style="{ background: `linear-gradient(145deg, ${view.design.decorative_color}, ${view.design.secondary_color}aa, ${view.design.decorative_color})` }"
        >
            <div class="relative overflow-hidden rounded-[1.8rem] border border-[color:var(--inv-decor)]/30 bg-[color:var(--inv-bg)] px-5 py-10 sm:px-12 sm:py-14">
                <!-- corner flourishes -->
                <span class="pointer-events-none absolute start-4 top-4 size-14 border-s border-t" :style="{ borderColor: view.design.decorative_color + '77' }" />
                <span class="pointer-events-none absolute end-4 top-4 size-14 border-e border-t" :style="{ borderColor: view.design.decorative_color + '77' }" />
                <span class="pointer-events-none absolute bottom-4 start-4 size-14 border-b border-s" :style="{ borderColor: view.design.decorative_color + '77' }" />
                <span class="pointer-events-none absolute bottom-4 end-4 size-14 border-b border-e" :style="{ borderColor: view.design.decorative_color + '77' }" />

                <div class="relative text-center">
                    <div class="mx-auto flex size-14 items-center justify-center rounded-full border" :style="{ borderColor: view.design.decorative_color + '88', color: view.design.primary_color }">
                        <Crown class="size-6" />
                    </div>

                    <p class="mt-5 text-[12px] font-bold uppercase tracking-[0.4em]" :style="{ color: view.design.primary_color }">{{ view.content.title }}</p>

                    <p v-if="view.content.religious" class="mx-auto mt-5 max-w-xl text-[15px] leading-8 opacity-80 sm:text-base">{{ view.content.religious }}</p>

                    <div class="mx-auto mt-5 flex items-center justify-center gap-3" :style="{ color: view.design.decorative_color }">
                        <span class="h-px w-12" :style="{ background: 'currentColor' }" />
                        <Sparkles class="size-3.5" />
                        <span class="h-px w-12" :style="{ background: 'currentColor' }" />
                    </div>

                    <p v-if="view.content.intro" class="mx-auto mt-5 max-w-lg text-[13px] leading-7 opacity-75">{{ view.content.intro }}</p>

                    <!-- Wakil representatives -->
                    <div v-if="view.wakils.hasAny" class="mt-8 grid grid-cols-2 gap-3 sm:gap-6" dir="ltr">
                        <WakilDisplay
                            :wakil="view.wakils.groom"
                            :lang="view.lang"
                            variant="framed"
                            :class="view.couple.groomRight ? 'order-2' : 'order-1'"
                        />
                        <WakilDisplay
                            :wakil="view.wakils.bride"
                            :lang="view.lang"
                            variant="framed"
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

                    <div class="mx-auto mt-7 flex items-center justify-center gap-3" :style="{ color: view.design.decorative_color }">
                        <span class="h-px w-16" :style="{ background: 'currentColor' }" />
                        <Heart class="size-3.5 fill-current opacity-70" />
                        <span class="h-px w-16" :style="{ background: 'currentColor' }" />
                    </div>

                    <!-- Couple -->
                    <div class="mt-7 grid grid-cols-[1fr_auto_1fr] items-center gap-3 sm:gap-6" dir="ltr">
                        <div :dir="view.dir" :class="view.couple.groomRight ? 'order-3' : 'order-1'">
                            <p class="text-[9px] font-bold uppercase tracking-[0.3em] opacity-50">{{ t('public.groom') }}</p>
                            <NameOrnament
                                class="mt-1.5"
                                :name="view.couple.groom"
                                :lang="view.lang"
                                size="md"
                                :color="view.design.primary_color"
                                :ornament="view.design.decorative_color"
                                motif="crown"
                            />
                            <p v-if="view.couple.note" class="mt-2 text-[10px] leading-5 opacity-60">{{ view.couple.note }}</p>
                        </div>

                        <div v-if="view.design.show_centerpiece" class="order-2 flex flex-col items-center gap-2">
                            <div class="flex size-14 items-center justify-center rounded-full border sm:size-16" :style="{ borderColor: view.design.decorative_color + '88', color: view.design.primary_color }">
                                <span class="text-base font-semibold sm:text-lg">{{ view.couple.monogram }}</span>
                            </div>
                            <Sparkles class="size-3.5 opacity-60" :style="{ color: view.design.decorative_color }" />
                        </div>
                        <div v-else class="order-2 px-1 text-xl opacity-40">&</div>

                        <div :dir="view.dir" :class="view.couple.groomRight ? 'order-1' : 'order-3'">
                            <p class="text-[9px] font-bold uppercase tracking-[0.3em] opacity-50">{{ t('public.bride') }}</p>
                            <NameOrnament
                                class="mt-1.5"
                                :name="view.couple.bride"
                                :lang="view.lang"
                                size="md"
                                :color="view.design.primary_color"
                                :ornament="view.design.decorative_color"
                                motif="flower"
                            />
                        </div>
                    </div>

                    <div v-if="view.images.cover" class="mx-auto mt-7 max-w-sm overflow-hidden rounded-2xl border p-1.5" :style="{ borderColor: view.design.decorative_color + '66' }">
                        <img :src="view.images.cover" alt="" class="h-44 w-full rounded-xl object-cover sm:h-52" loading="lazy" />
                    </div>

                    <p v-if="view.content.message" class="mx-auto mt-7 max-w-xl text-[13px] leading-8 opacity-80">{{ view.content.message }}</p>

                    <div class="mt-8 rounded-2xl border px-4 py-5 sm:px-6" :style="{ borderColor: view.design.decorative_color + '44', background: 'rgba(255,255,255,.35)' }">
                        <EventDetails :view="view" :lang="view.lang" variant="light" />
                    </div>

                    <CountdownTimer v-if="view.event.startIso" class="mt-7" :target="view.event.startIso" :lang="view.lang" variant="light" />

                    <div v-if="view.content.additional" class="mx-auto mt-7 max-w-lg rounded-xl px-4 py-3 text-[12px] leading-7" :style="{ background: view.design.decorative_color + '14' }">
                        {{ view.content.additional }}
                    </div>

                    <div class="mt-8 flex items-center justify-center gap-3" :style="{ color: view.design.decorative_color }">
                        <span class="h-px w-10" :style="{ background: 'currentColor' }" />
                        <Quote class="size-3.5" />
                        <span class="h-px w-10" :style="{ background: 'currentColor' }" />
                    </div>
                    <p v-if="view.content.closing" class="mx-auto mt-3 max-w-md text-sm leading-7 opacity-80">{{ view.content.closing }}</p>

                    <div v-if="view.design.show_monogram" class="mx-auto mt-7 flex size-11 items-center justify-center rounded-full border text-xs font-bold" :style="{ borderColor: view.design.decorative_color + '88', color: view.design.primary_color }">
                        {{ view.couple.monogram }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
