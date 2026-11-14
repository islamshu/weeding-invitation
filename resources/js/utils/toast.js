import { reactive } from 'vue';

let counter = 0;

export const toasts = reactive([]);

export function dismissToast(id) {
    const index = toasts.findIndex((item) => item.id === id);
    if (index !== -1) toasts.splice(index, 1);
}

export function pushToast(message, type = 'success', duration = 4200) {
    if (!message) return;
    const id = ++counter;
    toasts.push({ id, message, type });
    if (duration > 0) {
        setTimeout(() => dismissToast(id), duration);
    }
}

export const toast = {
    success: (message) => pushToast(message, 'success'),
    error: (message) => pushToast(message, 'error'),
    info: (message) => pushToast(message, 'info'),
};
