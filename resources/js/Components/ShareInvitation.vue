<script setup>
import { computed, ref } from 'vue';
import { Copy, Check, Facebook, Mail, MessageCircle, Send, Share2, Link2 } from 'lucide-vue-next';
import { translate } from '../i18n';
import { toast } from '../utils/toast';

const props = defineProps({
    url: { type: String, required: true },
    text: { type: String, default: '' },
    title: { type: String, default: '' },
    lang: { type: String, default: 'ar' },
    showLink: { type: Boolean, default: true },
});

const t = (key, params = {}) => translate(key, props.lang, params);
const copied = ref(false);

const message = computed(() => [props.text, props.url].filter(Boolean).join('\n'));

const links = computed(() => [
    {
        key: 'whatsapp',
        label: t('public.whatsapp'),
        icon: MessageCircle,
        href: `https://wa.me/?text=${encodeURIComponent(message.value)}`,
        classes: 'border-emerald-200 bg-emerald-50 text-emerald-800 hover:bg-emerald-100',
        iconClass: 'text-emerald-600',
    },
    {
        key: 'facebook',
        label: t('public.facebook'),
        icon: Facebook,
        href: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(props.url)}`,
        classes: 'border-blue-200 bg-blue-50 text-blue-800 hover:bg-blue-100',
        iconClass: 'text-blue-600',
    },
    {
        key: 'telegram',
        label: t('public.telegram'),
        icon: Send,
        href: `https://t.me/share/url?url=${encodeURIComponent(props.url)}&text=${encodeURIComponent(props.text)}`,
        classes: 'border-sky-200 bg-sky-50 text-sky-800 hover:bg-sky-100',
        iconClass: 'text-sky-600',
    },
    {
        key: 'email',
        label: t('public.email'),
        icon: Mail,
        href: `mailto:?subject=${encodeURIComponent(props.title)}&body=${encodeURIComponent(message.value)}`,
        classes: 'border-stone-200 bg-stone-50 text-stone-700 hover:bg-stone-100',
        iconClass: 'text-stone-500',
    },
]);

async function copyLink() {
    try {
        if (navigator.clipboard?.writeText) {
            await navigator.clipboard.writeText(props.url);
        } else {
            const area = document.createElement('textarea');
            area.value = props.url;
            area.setAttribute('readonly', '');
            area.style.position = 'fixed';
            area.style.opacity = '0';
            document.body.appendChild(area);
            area.select();
            document.execCommand('copy');
            document.body.removeChild(area);
        }

        copied.value = true;
        toast.success(t('public.linkCopied'));
        window.setTimeout(() => (copied.value = false), 2200);
    } catch {
        toast.error(t('public.copyFailed'));
    }
}

async function nativeShare() {
    if (!navigator.share) return;
    try {
        await navigator.share({ title: props.title, text: props.text, url: props.url });
    } catch {
        // Guest cancelled the native sheet — no feedback required.
    }
}

const canNativeShare = computed(() => typeof navigator !== 'undefined' && Boolean(navigator.share));
</script>

<template>
    <div class="space-y-4">
        <div v-if="showLink" class="rounded-2xl border border-champagne-200 bg-white/70 p-1.5">
            <div class="flex items-center gap-2">
                <span class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-champagne-100 text-champagne-600">
                    <Link2 class="size-4" />
                </span>
                <input
                    :value="url"
                    type="text"
                    readonly
                    dir="ltr"
                    class="min-w-0 flex-1 select-all bg-transparent px-1 text-xs font-medium text-ink-700 outline-none"
                    :aria-label="t('review.publicLink')"
                    @focus="$event.target.select()"
                />
                <button
                    type="button"
                    class="inline-flex shrink-0 items-center gap-1.5 rounded-xl bg-burgundy-600 px-3 py-2 text-[11px] font-bold text-ivory-50 transition hover:bg-burgundy-700"
                    @click="copyLink"
                >
                    <Check v-if="copied" class="size-3.5" />
                    <Copy v-else class="size-3.5" />
                    {{ copied ? t('common.copied') : t('common.copy') }}
                </button>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2.5">
            <a
                v-for="link in links"
                :key="link.key"
                :href="link.href"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center justify-center gap-2 rounded-2xl border px-3 py-3 text-xs font-bold transition"
                :class="link.classes"
            >
                <component :is="link.icon" class="size-4" :class="link.iconClass" />
                {{ link.label }}
            </a>
        </div>

        <button
            v-if="canNativeShare"
            type="button"
            class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-champagne-300 bg-champagne-100/50 px-4 py-3 text-xs font-bold text-ink-700 transition hover:bg-champagne-100"
            @click="nativeShare"
        >
            <Share2 class="size-4 text-champagne-600" />
            {{ t('public.nativeShare') }}
        </button>
    </div>
</template>
