<script setup>
import { BadgeInfo, ShieldCheck } from 'lucide-vue-next';
import { useI18n } from '../../i18n';
import WakilForm from './WakilForm.vue';

defineProps({
    form: { type: Object, required: true },
    errors: { type: Function, default: () => '' },
});

const { t } = useI18n();
</script>

<template>
    <div class="space-y-4">
        <div class="rounded-2xl border border-champagne-200 bg-champagne-100/30 px-4 py-3">
            <p class="flex items-start gap-2 text-[11px] font-semibold leading-6 text-ink-700">
                <BadgeInfo class="mt-0.5 size-4 shrink-0 text-champagne-600" />
                {{ t('wakil.notice') }}
            </p>
            <p class="mt-1 ps-6 text-[10px] leading-5 text-ink-500">{{ t('wizard.stepDesc.wakils') }}</p>
        </div>

        <WakilForm
            :wakil="form.groom_wakil"
            side="groom"
            prefix="groom_wakil"
            :errors="errors"
            :english="form.enable_english"
        />

        <WakilForm
            :wakil="form.bride_wakil"
            side="bride"
            prefix="bride_wakil"
            :errors="errors"
            :english="form.enable_english"
        />

        <p class="flex items-center justify-center gap-1.5 text-center text-[10px] text-ink-500">
            <ShieldCheck class="size-3.5 text-emerald-600" />
            {{ t('wakil.optionalSection') }}
        </p>
    </div>
</template>
