<script setup>
import { CircleCheck, CircleAlert, Info, X } from 'lucide-vue-next';
import { toasts, dismissToast } from '../utils/toast';

const icons = { success: CircleCheck, error: CircleAlert, info: Info };
const styles = {
    success: 'border-emerald-200 bg-emerald-50 text-emerald-900',
    error: 'border-red-200 bg-red-50 text-red-900',
    info: 'border-champagne-200 bg-ivory-50 text-ink-700',
};
</script>

<template>
    <Teleport to="body">
        <div class="pointer-events-none fixed inset-x-0 top-4 z-[120] flex flex-col items-center gap-2 px-4 sm:items-end sm:pe-6">
            <TransitionGroup
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="translate-y-2 opacity-0 scale-95"
                leave-active-class="transition duration-200 ease-in"
                leave-to-class="translate-y-1 opacity-0 scale-95"
            >
                <div
                    v-for="item in toasts"
                    :key="item.id"
                    class="pointer-events-auto flex w-full max-w-sm items-start gap-3 rounded-2xl border px-4 py-3 shadow-xl shadow-ink-900/5"
                    :class="styles[item.type] ?? styles.info"
                >
                    <component :is="icons[item.type] ?? Info" class="mt-0.5 size-5 shrink-0" />
                    <p class="flex-1 text-sm font-medium leading-6">{{ item.message }}</p>
                    <button type="button" class="rounded-full p-1 opacity-60 transition hover:opacity-100" aria-label="إغلاق" @click="dismissToast(item.id)">
                        <X class="size-3.5" />
                    </button>
                </div>
            </TransitionGroup>
        </div>
    </Teleport>
</template>
