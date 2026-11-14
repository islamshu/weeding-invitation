<script setup>
import { onBeforeUnmount, onMounted, watch } from 'vue';
import { X } from 'lucide-vue-next';

const props = defineProps({
    open: { type: Boolean, default: false },
    title: { type: String, default: '' },
    description: { type: String, default: '' },
    maxWidth: { type: String, default: 'max-w-lg' },
    closeable: { type: Boolean, default: true },
});

const emit = defineEmits(['close']);
let previousOverflow = '';

function close() {
    if (props.closeable) emit('close');
}

function onKeydown(event) {
    if (event.key === 'Escape' && props.open) close();
}

watch(
    () => props.open,
    (open) => {
        if (typeof document === 'undefined') return;
        if (open) {
            previousOverflow = document.body.style.overflow;
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = previousOverflow;
        }
    }
);

onMounted(() => window.addEventListener('keydown', onKeydown));
onBeforeUnmount(() => {
    window.removeEventListener('keydown', onKeydown);
    if (typeof document !== 'undefined') document.body.style.overflow = previousOverflow;
});
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            leave-active-class="transition duration-150 ease-in"
            leave-to-class="opacity-0"
        >
            <div v-if="open" class="fixed inset-0 z-[90] flex items-end justify-center bg-ink-900/45 p-0 backdrop-blur-sm sm:items-center sm:p-6" @click.self="close">
                <Transition
                    appear
                    enter-active-class="transition duration-250 ease-out"
                    enter-from-class="translate-y-6 opacity-0 sm:translate-y-2"
                    leave-active-class="transition duration-150 ease-in"
                    leave-to-class="translate-y-4 opacity-0"
                >
                    <div v-if="open" class="w-full overflow-hidden rounded-t-[1.75rem] border border-champagne-200 bg-ivory-50 shadow-2xl sm:rounded-[1.75rem]" :class="maxWidth">
                        <div v-if="title || $slots.header" class="flex items-start justify-between gap-4 border-b border-[#eee4d4] px-5 py-4 sm:px-6">
                            <div>
                                <slot name="header">
                                    <h3 class="text-lg font-bold text-ink-900">{{ title }}</h3>
                                    <p v-if="description" class="mt-1 text-sm text-ink-500">{{ description }}</p>
                                </slot>
                            </div>
                            <button
                                v-if="closeable"
                                type="button"
                                class="rounded-full p-2 text-ink-500 transition hover:bg-champagne-100 hover:text-ink-900"
                                :aria-label="$t('common.close')"
                                @click="close"
                            >
                                <X class="size-4" />
                            </button>
                        </div>

                        <div class="px-5 py-5 sm:px-6">
                            <slot />
                        </div>

                        <div v-if="$slots.footer" class="flex flex-wrap justify-end gap-2 border-t border-[#eee4d4] bg-white/50 px-5 py-4 sm:px-6">
                            <slot name="footer" />
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
