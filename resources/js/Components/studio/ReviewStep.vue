<script setup>
import { computed, ref } from 'vue';
import { CalendarDays, Check, Copy, ExternalLink, Globe2, MapPin, Rocket, Share2, Sparkles, X } from 'lucide-vue-next';
import { buildPreviewInvitation, buildView, statusMeta } from '../../utils/invitation';
import { useI18n } from '../../i18n';
import { toast } from '../../utils/toast';
import BaseInput from '../BaseInput.vue';
import BaseButton from '../BaseButton.vue';

const props = defineProps({
    form: { type: Object, required: true },
    invitation: { type: Object, default: null },
    canPublish: { type: Boolean, default: false },
    errors: { type: Function, default: () => '' },
});

const emit = defineEmits(['publish', 'goTo', 'openEnvelope']);

const { t, locale } = useI18n();
const copied = ref(false);

const view = computed(() => buildView(buildPreviewInvitation(props.form), locale.value));
const meta = computed(() => statusMeta(props.invitation?.status ?? 'draft'));

const checklist = computed(() => [
    {
        key: 'names',
        label: `${props.form.groom_name_ar || '—'} & ${props.form.bride_name_ar || '—'}`,
        done: Boolean(props.form.groom_name_ar && props.form.bride_name_ar),
    },
    {
        key: 'date',
        label: view.value.event.dateShort || t('details.date'),
        done: Boolean(props.form.event_details.wedding_date && props.form.event_details.wedding_time),
    },
    {
        key: 'venue',
        label: props.form.event_details.venue_name_ar || t('details.venueName'),
        done: Boolean(props.form.event_details.venue_name_ar),
    },
    {
        key: 'template',
        label: view.value.template.name_ar,
        done: Boolean(props.form.template_key),
    },
]);

const publicUrl = computed(() => props.invitation?.public_url ?? '');

async function copyLink() {
    if (!publicUrl.value) return;
    try {
        await navigator.clipboard.writeText(publicUrl.value);
        copied.value = true;
        toast.success(t('public.linkCopied'));
        window.setTimeout(() => (copied.value = false), 2000);
    } catch {
        toast.error(t('public.copyFailed'));
    }
}
</script>

<template>
    <div class="space-y-5">
        <div class="rounded-2xl border border-champagne-200 bg-champagne-100/30 px-4 py-3">
            <p class="flex items-center gap-2 text-[11px] font-semibold leading-6 text-ink-700">
                <Sparkles class="size-4 shrink-0 text-champagne-600" />
                {{ t('review.subtitle') }}
            </p>
        </div>

        <!-- Summary -->
        <section class="overflow-hidden rounded-2xl border border-champagne-200 bg-white/70">
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-champagne-100 px-4 py-3">
                <div class="flex items-center gap-2">
                    <h3 class="text-sm font-bold text-ink-900">{{ t('wizard.summary') }}</h3>
                    <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-[10px] font-bold" :class="meta.classes">
                        <span class="size-1.5 rounded-full" :class="meta.dot" />
                        {{ t(meta.key) }}
                    </span>
                </div>
                <BaseButton size="sm" variant="secondary" @click="emit('openEnvelope')">
                    {{ t('wizard.previewOpen') }}
                </BaseButton>
            </div>

            <div class="grid gap-3 px-4 py-4 sm:grid-cols-2">
                <div class="space-y-2">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-ink-500">{{ t('wizard.reviewChecklist') }}</p>
                    <ul class="space-y-1.5">
                        <li v-for="item in checklist" :key="item.key" class="flex items-start gap-2 text-[11px] leading-5">
                            <span
                                class="mt-0.5 flex size-4 shrink-0 items-center justify-center rounded-full"
                                :class="item.done ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-100 text-stone-500'"
                            >
                                <Check v-if="item.done" class="size-2.5" />
                                <X v-else class="size-2.5" />
                            </span>
                            <span :class="item.done ? 'text-ink-700' : 'text-ink-500'">{{ item.label }}</span>
                        </li>
                    </ul>
                </div>

                <div class="space-y-1.5 text-[11px] leading-6 text-ink-600">
                    <p class="flex items-center gap-1.5"><CalendarDays class="size-3.5 text-champagne-600" /> {{ view.event.dateFormatted || t('dashboard.noDate') }}</p>
                    <p class="flex items-center gap-1.5"><MapPin class="size-3.5 text-champagne-600" /> {{ view.event.venueName || '—' }}</p>
                    <p class="flex items-center gap-1.5"><Globe2 class="size-3.5 text-champagne-600" /> {{ form.enable_english ? t('dashboard.englishOn') : t('dashboard.arabicOnly') }}</p>
                    <p class="flex items-center gap-1.5"><Sparkles class="size-3.5 text-champagne-600" /> {{ view.template.name_ar }}</p>
                </div>
            </div>
        </section>

        <!-- Slug & link -->
        <section class="rounded-2xl border border-[#ece2d1] bg-white/55 p-4">
            <div class="flex items-center gap-2">
                <Share2 class="size-4 text-champagne-600" />
                <h3 class="text-sm font-bold text-ink-900">{{ t('review.publicLink') }}</h3>
            </div>

            <div class="mt-3">
                <BaseInput
                    v-model="form.slug"
                    :label="t('review.slug')"
                    dir="ltr"
                    placeholder="ahmad-sara"
                    :hint="t('review.slugHint')"
                    :error="errors('slug')"
                    optional
                />
            </div>

            <p v-if="!form.slug" class="mt-1 text-[10px] leading-5 text-ink-500">{{ t('review.autoSlug') }}</p>

            <div v-if="publicUrl" class="mt-3 flex items-center gap-2 rounded-xl border border-champagne-200 bg-white p-1.5">
                <input :value="publicUrl" readonly dir="ltr" class="min-w-0 flex-1 bg-transparent px-2 text-[11px] text-ink-600 outline-none" @focus="$event.target.select()" />
                <button type="button" class="rounded-lg bg-burgundy-600 px-3 py-1.5 text-[10px] font-bold text-ivory-50" @click="copyLink">
                    <Copy class="me-1 inline size-3" />
                    {{ copied ? t('common.copied') : t('common.copy') }}
                </button>
                <a :href="publicUrl" target="_blank" rel="noopener" class="inline-flex size-7 items-center justify-center rounded-lg border border-champagne-200 text-ink-600" :aria-label="t('review.openPublic')">
                    <ExternalLink class="size-3" />
                </a>
            </div>
            <p v-else class="mt-2 rounded-xl bg-stone-50 px-3 py-2 text-[10px] leading-5 text-ink-500">{{ t('wizard.saveFirst') }}</p>
        </section>

        <!-- Publish -->
        <section class="rounded-2xl border border-burgundy-400/30 bg-gradient-to-br from-burgundy-500/5 to-champagne-100/30 p-4">
            <div class="flex items-start gap-3">
                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-burgundy-600 text-ivory-50">
                    <Rocket class="size-4" />
                </span>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-ink-900">
                        {{ canPublish ? t('wizard.ready') : t('wizard.notReady') }}
                    </p>
                    <p class="mt-1 text-[11px] leading-6 text-ink-500">{{ t('review.publishNote') }}</p>
                    <p class="mt-1 text-[10px] leading-5 text-ink-500">{{ t('wizard.publishWarning') }}</p>
                </div>
            </div>

            <div class="mt-3 flex flex-wrap gap-2">
                <BaseButton variant="primary" :disabled="!canPublish" @click="emit('publish')">
                    <Rocket class="size-4" />
                    {{ t('review.publishNow') }}
                </BaseButton>
                <BaseButton v-if="!canPublish" variant="secondary" @click="emit('goTo', 4)">
                    {{ t('review.toStep') }} ٤
                </BaseButton>
            </div>

            <p v-if="invitation" class="mt-3 text-[10px] leading-5 text-ink-500">
                <template v-if="invitation.status === 'published'">{{ t('review.publishedHint') }}</template>
                <template v-else-if="invitation.status === 'unpublished'">{{ t('review.unpublishedHint') }}</template>
                <template v-else>{{ t('review.draftHint') }}</template>
            </p>
        </section>
    </div>
</template>
