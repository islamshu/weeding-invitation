<script setup>
import { computed } from 'vue';
import { statusMeta } from '../utils/invitation';
import { useI18n } from '../i18n';

const props = defineProps({
    status: { type: String, default: 'draft' },
});

const { t } = useI18n();
const meta = computed(() => statusMeta(props.status));
</script>

<template>
    <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-[11px] font-bold" :class="meta.classes">
        <span class="size-1.5 rounded-full" :class="meta.dot" />
        {{ t(meta.key) }}
    </span>
</template>
