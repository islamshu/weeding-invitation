<script setup>
import { computed } from 'vue';
import { buildView } from '../utils/invitation';
import InvitationTemplateRenderer from './InvitationTemplateRenderer.vue';

const props = defineProps({
    invitation: { type: Object, required: true },
    lang: { type: String, default: 'ar' },
    preview: { type: Boolean, default: false },
});

const view = computed(() => buildView(props.invitation, props.lang));
</script>

<template>
    <InvitationTemplateRenderer :view="view" :preview="preview" />
</template>
