<script setup>
import { Gem, Sparkles, Heart } from 'lucide-vue-next';
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
        <div class="relative mx-auto max-w-3xl border p-2" :style="{ borderColor: view.design.decorative_color + '88' }">
            <div class="relative border px-4 py-9 sm:px-10 sm:py-12" :style="{ borderColor: view.design.decorative_color + '44' }">
                <!-- art deco corners -->
                <span class="pointer-events-none absolute start-0 top-0 size-12 border-s-2 border-t-2" :style="{ borderColor: view.design.decorative_color }" />
                <span class="pointer-events-none absolute end-0 top-0 size-12 border-e-2 border-t-2" :style="{ borderColor: view.design.decorative_color }" />
                <span class="pointer-events-none absolute bottom-0 start-0 size-12 border-b-2 border-s-2" :style="{ borderColor: view.design.decorative_color }" />
                <span class="pointer-events-none absolute bottom-0 end-0 size-12 border-b-2 border-e-2" :style="{ borderColor: view.design.decorative_color }" />

                <div class="text-center">
                    <div class="mx-auto flex w-24 items-center justify-center gap-2 text-[color:var(--inv-decor)]">
                        <span class="h-px flex-1 bg-current opacity-60" />
                        <Gem class="size-4" />
                        <span class="h-px flex-1 bg-current opacity-60" />
                    </div>

                    <p class="gold-text mt-5 text-[13px] font-semibold uppercase tracking-[0.42em]">{{ view.content.title }}</p>

                    <p v-if="view.content.religious" class="mx-auto mt-5 max-w-lg text-[15px] leading-8 text-white/65">{{ view.content.religious }}</p>

                    <p v-if="view.content.intro" class="mx-auto mt-5 max-w-md text-[11px] leading-7 text-white/55">{{ view.content.intro }}</p>

                    <div v-if="view.wakils.hasAny" class="mt-8 grid grid-cols-2 gap-3 text-center sm:gap-5" dir="ltr">
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
                        :ornament="view.design.decorative_color"
                    />

                    <div class="mx-auto mt-7 flex w-40 items-center gap-2" :style="{ color: view.design.decorative_color }">
                        <span class="h-px flex-1 bg-current" />
                        <Sparkles class="size-3" />
                        <span class="h-px flex-1 bg-current" />
                    </div>

                    <div class="mt-6 grid grid-cols-[1fr_auto_1fr] items-center gap-3 sm:gap-6" dir="ltr">
                        <div :dir="view.dir" :class="view.couple.groomRight ? 'order-3' : 'order-1'">
                            <p class="text-[8px] font-bold uppercase tracking-[0.35em] text-white/40">{{ t('public.groom') }}</p>
                            <NameOrnament
                                class="mt-1.5"
                                :name="view.couple.groom"
                                :lang="view.lang"
                                size="md"
                                :color="view.design.decorative_color"
                                :ornament="view.design.decorative_color"
                                motif="deco"
                                gold
                            />
                        </div>
                        <div class="order-2 flex size-12 items-center justify-center rounded-full border sm:size-14" :style="{ borderColor: view.design.decorative_color + '88', color: view.design.decorative_color }">
                            <span class="text-sm">{{ view.couple.monogram }}</span>
                        </div>
                        <div :dir="view.dir" :class="view.couple.groomRight ? 'order-1' : 'order-3'">
                            <p class="text-[8px] font-bold uppercase tracking-[0.35em] text-white/40">{{ t('public.bride') }}</p>
                            <NameOrnament
                                class="mt-1.5"
                                :name="view.couple.bride"
                                :lang="view.lang"
                                size="md"
                                :color="view.design.decorative_color"
                                :ornament="view.design.decorative_color"
                                motif="gem"
                                gold
                            />
                        </div>
                    </div>

                    <p v-if="view.couple.note" class="mt-3 text-[10px] tracking-wider text-white/45">{{ view.couple.note }}</p>

                    <p v-if="view.content.message" class="mx-auto mt-7 max-w-lg text-[12px] leading-8 text-white/65">{{ view.content.message }}</p>

                    <div v-if="view.images.cover" class="mx-auto mt-7 max-w-md border p-1.5" :style="{ borderColor: view.design.decorative_color + '55' }">
                        <img :src="view.images.cover" alt="" class="h-44 w-full object-cover opacity-90 sm:h-56" loading="lazy" />
                    </div>

                    <div class="mt-7">
                        <EventDetails :view="view" :lang="view.lang" variant="dark" />
                    </div>

                    <CountdownTimer v-if="view.event.startIso" class="mt-7" :target="view.event.startIso" :lang="view.lang" variant="dark" />

                    <div v-if="view.content.additional" class="mx-auto mt-7 max-w-md rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-[11px] leading-7 text-white/55">
                        {{ view.content.additional }}
                    </div>

                    <div class="mt-8 flex justify-center" :style="{ color: view.design.decorative_color }">
                        <Heart class="size-4" />
                    </div>
                    <p v-if="view.content.closing" class="mx-auto mt-3 max-w-sm text-sm leading-7 text-white/70">{{ view.content.closing }}</p>

                    <p v-if="view.design.show_monogram" class="mt-6 text-[10px] uppercase tracking-[0.5em]" :style="{ color: view.design.decorative_color }">{{ view.couple.monogram }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
