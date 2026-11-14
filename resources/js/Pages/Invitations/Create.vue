<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';
import InvitationWizard from '../../Components/studio/InvitationWizard.vue';
import { useI18n } from '../../i18n';

const { t } = useI18n();
</script>

<template>
    <Head :title="t('wizard.createTitle')" />

    <AppLayout>
        <InvitationWizard mode="create" />
    </AppLayout>
</template>
