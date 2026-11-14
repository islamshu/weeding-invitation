<script setup>
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';
import InvitationWizard from '../../Components/studio/InvitationWizard.vue';
import { useI18n } from '../../i18n';

const props = defineProps({
    invitation: { type: Object, required: true },
    initialStep: { type: [Number, String], default: 1 },
});

const page = usePage();
const { t } = useI18n();

const step = computed(() => {
    const fromQuery = new URLSearchParams((page.url ?? '').split('?')[1] ?? '').get('step');
    return fromQuery ?? props.initialStep ?? 1;
});

const title = computed(() => {
    const groom = props.invitation.groom_name_ar;
    const bride = props.invitation.bride_name_ar;
    return groom && bride ? `${groom} & ${bride}` : t('wizard.editTitle');
});
</script>

<template>
    <Head :title="title" />

    <AppLayout>
        <InvitationWizard mode="edit" :invitation="invitation" :initial-step="step" />
    </AppLayout>
</template>
