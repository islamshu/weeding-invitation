<script setup>
import { computed } from 'vue';
import { Sparkles } from 'lucide-vue-next';

const props = defineProps({
    text: { type: String, default: '' },
    lang: { type: String, default: 'ar' },
    color: { type: String, default: 'var(--inv-primary)' },
    ornament: { type: String, default: 'var(--inv-decor)' },
});

const dir = computed(() => (props.lang === 'ar' ? 'rtl' : 'ltr'));
const isArabic = computed(() => props.lang === 'ar');
</script>

<template>
    <div v-if="text" class="invitation-lead relative text-center" :dir="dir">
        <div class="flex items-center justify-center gap-2.5" :style="{ color: ornament }" aria-hidden="true">
            <svg class="h-3 w-16 opacity-75" viewBox="0 0 64 16" fill="none">
                <path
                    d="M1 13c7.5 0 11.5-2.8 11.5-6.6 0-2.3-1.6-3.9-3.7-3.9-2 0-3.5 1.5-3.5 3.4 0 3.9 5.2 6.2 10 6.2 4 0 7.5-1.7 10.5-4.6"
                    stroke="currentColor"
                    stroke-width="1"
                    stroke-linecap="round"
                />
                <path d="M28 8.5c2.2-1.2 3.6-2.7 4.2-4.4" stroke="currentColor" stroke-width="1" stroke-linecap="round" />
                <circle cx="31.5" cy="7.6" r="1.1" fill="currentColor" />
            </svg>

            <Sparkles class="size-3.5 opacity-85" />

            <svg class="h-3 w-16 scale-x-[-1] opacity-75" viewBox="0 0 64 16" fill="none">
                <path
                    d="M1 13c7.5 0 11.5-2.8 11.5-6.6 0-2.3-1.6-3.9-3.7-3.9-2 0-3.5 1.5-3.5 3.4 0 3.9 5.2 6.2 10 6.2 4 0 7.5-1.7 10.5-4.6"
                    stroke="currentColor"
                    stroke-width="1"
                    stroke-linecap="round"
                />
                <path d="M28 8.5c2.2-1.2 3.6-2.7 4.2-4.4" stroke="currentColor" stroke-width="1" stroke-linecap="round" />
                <circle cx="31.5" cy="7.6" r="1.1" fill="currentColor" />
            </svg>
        </div>

        <p
            class="text-balance mx-auto mt-2.5 max-w-lg text-[16px] font-semibold leading-9 sm:text-[17px]"
            :class="isArabic ? '' : 'italic'"
            :style="{ color }"
        >
            {{ text }}
        </p>
    </div>
</template>
