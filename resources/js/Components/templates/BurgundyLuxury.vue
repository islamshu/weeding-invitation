<script setup>
import { Crown, Sparkles, Gem } from 'lucide-vue-next';
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
    <div class="invitation-surface px-4 py-9 sm:px-8 sm:py-14" :dir="view.dir" :style="{ fontFamily: view.fontFamily }">
        <div class="relative mx-auto max-w-2xl border p-1.5" :style="{ borderColor: view.design.decorative_color + '66' }">
            <div class="relative overflow-hidden border px-5 py-10 sm:px-10 sm:py-14" :style="{ borderColor: view.design.decorative_color + '33' }">
                <div class="pointer-events-none absolute -end-24 -top-24 size-64 rounded-full opacity-20 blur-3xl" :style="{ background: view.design.decorative_color }" />
                <div class="pointer-events-none absolute -bottom-24 -start-24 size-64 rounded-full opacity-10 blur-3xl" :style="{ background: view.design.primary_color }" />

                <div class="relative text-center">
                    <!-- crest -->
                    <div v-if="view.design.show_monogram" class="mx-auto flex size-20 flex-col items-center justify-center rounded-full border-2" :style="{ borderColor: view.design.decorative_color + '88' }">
                        <Crown class="size-4" :style="{ color: view.design.decorative_color }" />
                        <span class="mt-0.5 text-base font-semibold" :style="{ color: view.design.decorative_color }">{{ view.couple.monogram }}</span>
                    </div>

                    <p class="mt-5 text-[12px] font-semibold uppercase tracking-[0.5em]" :style="{ color: view.design.decorative_color }">{{ view.content.title }}</p>

                    <div class="mx-auto mt-4 flex w-36 items-center gap-2" :style="{ color: view.design.decorative_color }">
                        <span class="h-px flex-1 bg-current opacity-60" />
                        <Gem class="size-3" />
                        <span class="h-px flex-1 bg-current opacity-60" />
                    </div>

                    <p v-if="view.content.religious" class="mx-auto mt-5 max-w-lg text-[14px] leading-8 text-white/65">{{ view.content.religious }}</p>
                    <p v-if="view.content.intro" class="mx-auto mt-4 max-w-md text-[11px] leading-7 text-white/50">{{ view.content.intro }}</p>

                    <div v-if="view.wakils.hasAny" class="mt-8 grid grid-cols-2 gap-3 sm:gap-5" dir="ltr">
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

                    <div class="mx-auto my-6 flex w-44 items-center gap-2" :style="{ color: view.design.decorative_color }">
                        <span class="h-px flex-1 bg-current opacity-50" />
                        <Sparkles class="size-3" />
                        <span class="h-px flex-1 bg-current opacity-50" />
                    </div>

                    <div class="grid grid-cols-[1fr_auto_1fr] items-center gap-2 sm:gap-5" dir="ltr">
                        <div :dir="view.dir" :class="view.couple.groomRight ? 'order-3' : 'order-1'">
                            <p class="text-[8px] font-bold uppercase tracking-[0.35em] text-white/35">{{ t('public.groom') }}</p>
                            <NameOrnament
                                class="mt-1.5"
                                :name="view.couple.groom"
                                :lang="view.lang"
                                size="md"
                                :color="view.design.decorative_color"
                                :ornament="view.design.secondary_color"
                                motif="crown"
                            />
                        </div>
                        <div class="order-2 flex size-9 items-center justify-center rounded-full border border-white/20 text-xs text-white/60 sm:size-11">&</div>
                        <div :dir="view.dir" :class="view.couple.groomRight ? 'order-1' : 'order-3'">
                            <p class="text-[8px] font-bold uppercase tracking-[0.35em] text-white/35">{{ t('public.bride') }}</p>
                            <NameOrnament
                                class="mt-1.5"
                                :name="view.couple.bride"
                                :lang="view.lang"
                                size="md"
                                :color="view.design.decorative_color"
                                :ornament="view.design.secondary_color"
                                motif="gem"
                            />
                        </div>
                    </div>

                    <p v-if="view.couple.note" class="mt-2 text-[10px] text-white/40">{{ view.couple.note }}</p>

                    <div v-if="view.images.cover" class="mx-auto mt-7 max-w-sm border-4 p-1" :style="{ borderColor: view.design.decorative_color + '33' }">
                        <img :src="view.images.cover" alt="" class="h-48 w-full object-cover opacity-90 saturate-75" loading="lazy" />
                    </div>

                    <p v-if="view.content.message" class="mx-auto mt-7 max-w-lg text-[12px] leading-8 text-white/60">{{ view.content.message }}</p>

                    <div class="mt-7">
                        <EventDetails :view="view" :lang="view.lang" variant="royal" />
                    </div>

                    <CountdownTimer v-if="view.event.startIso" class="mt-7" :target="view.event.startIso" :lang="view.lang" variant="royal" />

                    <div v-if="view.content.additional" class="mx-auto mt-7 max-w-md border-y border-white/10 py-3 text-[11px] leading-7 text-white/50">
                        {{ view.content.additional }}
                    </div>

                    <div class="mt-8">
                        <div class="mx-auto flex w-24 items-center gap-2 text-[color:var(--inv-decor)] opacity-60">
                            <span class="h-px flex-1 bg-current" />
                            <Crown class="size-3" />
                            <span class="h-px flex-1 bg-current" />
                        </div>
                        <p v-if="view.content.closing" class="mx-auto mt-3 max-w-sm text-sm leading-7 text-white/65">{{ view.content.closing }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
