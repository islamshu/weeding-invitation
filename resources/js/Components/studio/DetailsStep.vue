<script setup>
import { CalendarDays, Languages, MapPin, PartyPopper, Sparkles } from 'lucide-vue-next';
import { useI18n } from '../../i18n';
import BaseInput from '../BaseInput.vue';
import ToggleSwitch from '../ToggleSwitch.vue';

defineProps({
    form: { type: Object, required: true },
    errors: { type: Function, default: () => '' },
});

const { t } = useI18n();
</script>

<template>
    <div class="space-y-5">
        <div class="rounded-2xl border border-champagne-200 bg-champagne-100/30 px-4 py-3">
            <p class="flex items-center gap-2 text-[11px] font-semibold leading-6 text-ink-700">
                <CalendarDays class="size-4 shrink-0 text-champagne-600" />
                {{ t('wizard.stepDesc.details') }}
            </p>
            <p class="mt-1 ps-6 text-[10px] leading-5 text-ink-500">{{ t('review.publishNote') }}</p>
        </div>

        <section class="rounded-2xl border border-[#ece2d1] bg-white/55 p-4">
            <p class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em] text-burgundy-600">
                <Sparkles class="size-3.5" />
                {{ t('details.title') }}
            </p>

            <div class="mt-3 grid gap-3.5 sm:grid-cols-2">
                <BaseInput
                    v-model="form.event_details.wedding_date"
                    :label="t('details.date')"
                    type="date"
                    dir="ltr"
                    :hint="t('details.dateHint')"
                    :error="errors('event_details.wedding_date')"
                    required
                />
                <BaseInput
                    v-model="form.event_details.wedding_time"
                    :label="t('details.time')"
                    type="time"
                    dir="ltr"
                    :hint="t('details.timeHint')"
                    :error="errors('event_details.wedding_time')"
                    required
                />
                <BaseInput
                    v-model="form.event_details.venue_name_ar"
                    :label="t('details.venueName')"
                    :placeholder="t('details.venueNamePlaceholder')"
                    :error="errors('event_details.venue_name_ar')"
                    required
                />
                <BaseInput
                    v-model="form.event_details.venue_address_ar"
                    :label="t('details.venueAddress')"
                    :placeholder="t('details.venueAddressPlaceholder')"
                    :error="errors('event_details.venue_address_ar')"
                />
            </div>

            <div class="mt-3.5">
                <BaseInput
                    v-model="form.event_details.maps_url"
                    :label="t('details.maps')"
                    type="url"
                    dir="ltr"
                    placeholder="https://maps.google.com/..."
                    :hint="t('details.mapsHint')"
                    :error="errors('event_details.maps_url')"
                />
            </div>

            <div v-if="form.enable_english" class="mt-4 rounded-xl border border-dashed border-champagne-300 bg-white/60 p-3">
                <p class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-champagne-600">
                    <Languages class="size-3.5" />
                    {{ t('wizard.englishOptional') }}
                </p>
                <div class="mt-2.5 grid gap-3 sm:grid-cols-2">
                    <BaseInput v-model="form.event_details.venue_name_en" :label="`${t('details.venueName')} (EN)`" dir="ltr" :placeholder="t('details.venueNamePlaceholder')" :error="errors('event_details.venue_name_en')" optional />
                    <BaseInput v-model="form.event_details.venue_address_en" :label="`${t('details.venueAddress')} (EN)`" dir="ltr" :placeholder="t('details.venueAddressPlaceholder')" :error="errors('event_details.venue_address_en')" optional />
                </div>
            </div>
        </section>

        <!-- Additional events -->
        <section class="rounded-2xl border border-[#ece2d1] bg-white/55 p-4">
            <p class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em] text-champagne-600">
                <PartyPopper class="size-3.5" />
                {{ t('details.additionalEvents') }}
            </p>
            <p class="mt-1 text-[10px] leading-5 text-ink-500">{{ t('details.additionalDesc') }}</p>

            <div class="mt-3 space-y-3">
                <div class="rounded-xl border border-champagne-200 bg-white/70 p-3">
                    <ToggleSwitch v-model="form.event_details.henna_enabled" :label="t('details.enableHenna')" />
                    <div v-if="form.event_details.henna_enabled" class="mt-3 grid gap-3 sm:grid-cols-2">
                        <BaseInput v-model="form.event_details.henna_date" :label="t('details.eventDate')" type="date" dir="ltr" :error="errors('event_details.henna_date')" />
                        <BaseInput v-model="form.event_details.henna_time" :label="t('details.eventTime')" type="time" dir="ltr" :error="errors('event_details.henna_time')" />
                        <BaseInput v-model="form.event_details.henna_location_ar" :label="t('details.eventLocation')" :placeholder="t('details.eventLocationPlaceholder')" :error="errors('event_details.henna_location_ar')" />
                        <BaseInput v-if="form.enable_english" v-model="form.event_details.henna_location_en" :label="`${t('details.eventLocation')} (EN)`" dir="ltr" :error="errors('event_details.henna_location_en')" optional />
                    </div>
                </div>

                <div class="rounded-xl border border-champagne-200 bg-white/70 p-3">
                    <ToggleSwitch v-model="form.event_details.reception_enabled" :label="t('details.enableReception')" />
                    <div v-if="form.event_details.reception_enabled" class="mt-3 grid gap-3 sm:grid-cols-2">
                        <BaseInput v-model="form.event_details.reception_date" :label="t('details.eventDate')" type="date" dir="ltr" :error="errors('event_details.reception_date')" />
                        <BaseInput v-model="form.event_details.reception_time" :label="t('details.eventTime')" type="time" dir="ltr" :error="errors('event_details.reception_time')" />
                        <BaseInput v-model="form.event_details.reception_location_ar" :label="t('details.eventLocation')" :placeholder="t('details.eventLocationPlaceholder')" :error="errors('event_details.reception_location_ar')" />
                        <BaseInput v-if="form.enable_english" v-model="form.event_details.reception_location_en" :label="`${t('details.eventLocation')} (EN)`" dir="ltr" :error="errors('event_details.reception_location_en')" optional />
                    </div>
                </div>
            </div>
        </section>

        <p class="flex items-center gap-1.5 text-[10px] text-ink-500">
            <MapPin class="size-3.5 text-champagne-600" />
            {{ t('details.mapsHint') }}
        </p>
    </div>
</template>
