<script setup>
import { computed, onBeforeUnmount, ref, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import {
    ArrowLeft,
    ArrowRight,
    CalendarDays,
    Check,
    FileText,
    Heart,
    Languages,
    Maximize2,
    Palette,
    Rocket,
    Save,
    Sparkles,
    Users,
} from 'lucide-vue-next';
import { defaultForm, formFromInvitation, buildPreviewInvitation } from '../../utils/invitation';
import { useI18n } from '../../i18n';
import { toast } from '../../utils/toast';
import InvitationCard from '../InvitationCard.vue';
import InvitationExperience from '../InvitationExperience.vue';
import Modal from '../Modal.vue';
import StatusBadge from '../StatusBadge.vue';
import BaseButton from '../BaseButton.vue';
import CoupleStep from './CoupleStep.vue';
import WakilStep from './WakilStep.vue';
import ContentStep from './ContentStep.vue';
import DetailsStep from './DetailsStep.vue';
import DesignStep from './DesignStep.vue';
import ReviewStep from './ReviewStep.vue';

const props = defineProps({
    mode: { type: String, default: 'create' },
    invitation: { type: Object, default: null },
    initialStep: { type: [Number, String], default: 1 },
});

const { t, locale } = useI18n();

const form = useForm(props.invitation ? formFromInvitation(props.invitation) : defaultForm());
const isEdit = computed(() => props.mode === 'edit' && Boolean(props.invitation));

const clamp = (value) => Math.min(6, Math.max(1, Number(value) || 1));
const step = ref(clamp(props.initialStep));
const maxVisited = ref(step.value);
const localErrors = ref({});
const savingIntent = ref(null);
const previewOpen = ref(false);
const previewLang = ref(locale.value === 'en' && form.enable_english ? 'en' : 'ar');

const steps = computed(() => [
    { key: 'couple', icon: Heart, title: t('wizard.steps.couple'), desc: t('wizard.stepDesc.couple') },
    { key: 'wakils', icon: Users, title: t('wizard.steps.wakils'), desc: t('wizard.stepDesc.wakils') },
    { key: 'content', icon: FileText, title: t('wizard.steps.content'), desc: t('wizard.stepDesc.content') },
    { key: 'details', icon: CalendarDays, title: t('wizard.steps.details'), desc: t('wizard.stepDesc.details') },
    { key: 'design', icon: Palette, title: t('wizard.steps.design'), desc: t('wizard.stepDesc.design') },
    { key: 'review', icon: Rocket, title: t('wizard.steps.review'), desc: t('wizard.stepDesc.review') },
]);

const components = {
    couple: CoupleStep,
    wakils: WakilStep,
    content: ContentStep,
    details: DetailsStep,
    design: DesignStep,
    review: ReviewStep,
};

const current = computed(() => steps.value[step.value - 1]);
const currentComponent = computed(() => components[current.value.key]);
const previewInvitation = computed(() => buildPreviewInvitation(form));
const existingImages = computed(() => ({
    cover: form.cover_preview_url,
    background: form.background_preview_url,
    decorative: form.decorative_preview_url,
}));

const canPublish = computed(() =>
    Boolean(form.groom_name_ar?.trim())
    && Boolean(form.bride_name_ar?.trim())
    && Boolean(form.event_details.wedding_date)
    && Boolean(form.event_details.wedding_time)
    && Boolean(form.event_details.venue_name_ar?.trim())
);

function errors(path) {
    return localErrors.value[path] ?? form.errors[path] ?? '';
}

function stepForPath(path) {
    if (!path) return 1;
    if (path.startsWith('groom_wakil') || path.startsWith('bride_wakil')) return 2;
    if (path.startsWith('invitation_content')) return 3;
    if (path.startsWith('event_details')) return 4;
    if (path.startsWith('design_settings')) return 5;
    if (['template_key', 'cover_image', 'background_image', 'decorative_image'].includes(path)) return 5;
    if (path === 'slug') return 6;
    return 1;
}

function goTo(target) {
    step.value = clamp(target);
    maxVisited.value = Math.max(maxVisited.value, step.value);
}

function validateNames(container = {}) {
    if (!form.groom_name_ar?.trim()) container.groom_name_ar = t('common.required');
    if (!form.bride_name_ar?.trim()) container.bride_name_ar = t('common.required');
}

function validateDetails(container = {}) {
    if (!form.event_details.wedding_date) container['event_details.wedding_date'] = t('common.required');
    if (!form.event_details.wedding_time) container['event_details.wedding_time'] = t('common.required');
    if (!form.event_details.venue_name_ar?.trim()) container['event_details.venue_name_ar'] = t('common.required');
}

function next() {
    const validation = {};

    if (step.value === 1) validateNames(validation);

    if (step.value === 4) {
        if (form.event_details.henna_enabled && !form.event_details.henna_date) {
            validation['event_details.henna_date'] = t('common.required');
        }
        if (form.event_details.reception_enabled && !form.event_details.reception_date) {
            validation['event_details.reception_date'] = t('common.required');
        }
    }

    localErrors.value = validation;

    if (Object.keys(validation).length) {
        toast.error(t('wizard.fixErrors'));
        return;
    }

    goTo(step.value + 1);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function previous() {
    goTo(step.value - 1);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function submit(intent) {
    if (form.processing) return;

    const validation = {};

    if (intent === 'publish') {
        validateNames(validation);
        validateDetails(validation);
    }

    localErrors.value = validation;

    if (Object.keys(validation).length) {
        const first = Object.keys(validation)[0];
        goTo(stepForPath(first));
        toast.error(t('wizard.fixErrors'));
        return;
    }

    form.intent = intent;
    form.return_step = step.value;

    const options = {
        preserveScroll: true,
        forceFormData: true,
        onStart: () => (savingIntent.value = intent),
        onFinish: () => (savingIntent.value = null),
        onError: (validationErrors) => {
            const keys = Object.keys(validationErrors);
            if (keys.length) {
                goTo(Math.min(...keys.map(stepForPath)));
                toast.error(t('wizard.fixErrors'));
            }
        },
    };

    if (isEdit.value) {
        form.transform((data) => ({
            ...data,
            _method: 'PUT',
        }));

        form.post(`/invitations/${props.invitation.id}`, options);
    } else {
        form.post('/invitations', options);
    }
}

watch(
    () => form.enable_english,
    (enabled) => {
        if (!enabled) previewLang.value = 'ar';
    }
);

watch(
    () => form.groom_name_ar,
    () => {
        delete localErrors.value.groom_name_ar;
        delete form.errors.groom_name_ar;
    }
);

watch(
    () => form.bride_name_ar,
    () => {
        delete localErrors.value.bride_name_ar;
        delete form.errors.bride_name_ar;
    }
);

watch(
    () => [form.event_details.wedding_date, form.event_details.wedding_time, form.event_details.venue_name_ar],
    () => {
        delete localErrors.value['event_details.wedding_date'];
        delete localErrors.value['event_details.wedding_time'];
        delete localErrors.value['event_details.venue_name_ar'];
        delete form.errors['event_details.wedding_date'];
        delete form.errors['event_details.wedding_time'];
        delete form.errors['event_details.venue_name_ar'];
    }
);

onBeforeUnmount(() => {
    ['cover_preview_url', 'background_preview_url', 'decorative_preview_url'].forEach((key) => {
        if (typeof form[key] === 'string' && form[key].startsWith('blob:')) {
            URL.revokeObjectURL(form[key]);
        }
    });
});
</script>

<template>
    <div class="container-page py-6 lg:py-9">
        <!-- Header -->
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="min-w-0">
                <Link href="/dashboard"
                    class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-ink-500 transition hover:text-burgundy-600">
                    <ArrowLeft class="size-3.5 rtl:rotate-180" />
                    {{ t('wizard.backDashboard') }}
                </Link>
                <p class="eyebrow mt-3">{{ isEdit ? t('wizard.editTitle') : t('wizard.createTitle') }}</p>
                <h1 class="luxury-title mt-1.5 text-2xl font-semibold sm:text-3xl">
                    {{ form.groom_name_ar || t('wizard.groom') }}
                    <span class="text-champagne-500">&</span>
                    {{ form.bride_name_ar || t('wizard.bride') }}
                </h1>
                <p class="mt-2 max-w-2xl text-xs leading-6 text-ink-500">
                    {{ isEdit ? t('wizard.editSubtitle') : t('wizard.createSubtitle') }}
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <StatusBadge v-if="invitation" :status="invitation.status" />
                <span
                    class="rounded-full border border-champagne-200 bg-white/70 px-3 py-1.5 text-[10px] font-bold text-ink-600">
                    {{ t('wizard.step', { current: step, total: steps.length }) }}
                </span>
                <button type="button"
                    class="inline-flex items-center gap-1.5 rounded-full border border-champagne-200 bg-white/70 px-3 py-1.5 text-[10px] font-bold text-ink-700 transition hover:border-champagne-400 xl:hidden"
                    @click="previewOpen = true">
                    <Maximize2 class="size-3" />
                    {{ t('wizard.mobilePreview') }}
                </button>
            </div>
        </div>

        <!-- Progress -->
        <div class="studio-card mt-5 overflow-hidden p-2">
            <div class="no-scrollbar flex items-stretch gap-1 overflow-x-auto">
                <button v-for="(item, index) in steps" :key="item.key" type="button"
                    class="group flex min-w-[108px] flex-1 items-center gap-2 rounded-xl px-2.5 py-2.5 text-start transition"
                    :class="step === index + 1
                        ? 'bg-burgundy-600 text-ivory-50 shadow-sm'
                        : index + 1 < step
                            ? 'bg-champagne-100/60 text-ink-800 hover:bg-champagne-100'
                            : 'text-ink-500 hover:bg-champagne-100/40'" @click="goTo(index + 1)">
                    <span
                        class="flex size-7 shrink-0 items-center justify-center rounded-full border text-[11px] font-bold"
                        :class="step === index + 1
                            ? 'border-white/40 bg-white/15 text-white'
                            : index + 1 < step
                                ? 'border-champagne-400 bg-white text-champagne-600'
                                : 'border-stone-200 bg-white text-ink-500'">
                        <Check v-if="index + 1 < step" class="size-3.5" />
                        <component :is="item.icon" v-else class="size-3.5" />
                    </span>
                    <span class="min-w-0">
                        <span class="block truncate text-[10px] font-bold">{{ item.title }}</span>
                        <span class="mt-0.5 block text-[8px] opacity-70">{{ index + 1 }} / {{ steps.length }}</span>
                    </span>
                </button>
            </div>
        </div>

        <div class="mt-5 grid gap-5 xl:grid-cols-[minmax(0,1fr)_minmax(370px,420px)] xl:items-start">
            <div class="min-w-0">
                <div class="studio-card p-4 sm:p-6">
                    <div class="mb-4 border-b border-champagne-100 pb-4">
                        <h2 class="text-lg font-bold text-ink-900">{{ current.title }}</h2>
                        <p class="mt-1 text-[11px] leading-6 text-ink-500">{{ current.desc }}</p>
                    </div>

                    <Transition name="section" mode="out-in">
                        <component :is="currentComponent" :key="current.key" :form="form" :errors="errors"
                            :invitation="invitation" :can-publish="canPublish" :existing="existingImages" @go-to="goTo"
                            @publish="submit('publish')" @open-envelope="previewOpen = true" />
                    </Transition>
                </div>

                <!-- Actions -->
                <div
                    class="sticky bottom-3 z-20 mt-4 flex flex-wrap items-center justify-between gap-2 rounded-2xl border border-champagne-200 bg-ivory-50/95 p-2.5 shadow-[0_18px_45px_-30px_rgba(36,31,25,.6)] backdrop-blur-xl">
                    <BaseButton v-if="step > 1" variant="secondary" size="sm" @click="previous">
                        <ArrowLeft class="size-3.5 rtl:rotate-180" />
                        {{ t('common.previous') }}
                    </BaseButton>
                    <span v-else class="hidden sm:block" />

                    <div class="ms-auto flex flex-wrap items-center gap-2">
                        <BaseButton variant="secondary" size="sm" :loading="form.processing && savingIntent === 'save'"
                            :disabled="form.processing" @click="submit('save')">
                            <Save v-if="!form.processing" class="size-3.5" />
                            {{ t('common.saveDraft') }}
                        </BaseButton>

                        <BaseButton v-if="step < steps.length" size="sm" @click="next">
                            {{ t('common.next') }}
                            <ArrowRight class="size-3.5 rtl:rotate-180" />
                        </BaseButton>

                        <BaseButton v-else variant="primary" size="sm" :disabled="!canPublish || form.processing"
                            :loading="form.processing && savingIntent === 'publish'" @click="submit('publish')">
                            <Rocket v-if="!form.processing" class="size-3.5" />
                            {{ t('review.publishNow') }}
                        </BaseButton>
                    </div>
                </div>
            </div>

            <!-- Live preview -->
            <aside class="hidden xl:block">
                <div class="sticky top-24">
                    <div class="flex items-center justify-between gap-2">
                        <p class="eyebrow">{{ t('wizard.livePreview') }}</p>
                        <div class="flex items-center gap-1.5">
                            <button v-if="form.enable_english" type="button"
                                class="inline-flex items-center gap-1 rounded-full border border-champagne-200 bg-white px-2.5 py-1.5 text-[9px] font-bold text-ink-700"
                                @click="previewLang = previewLang === 'ar' ? 'en' : 'ar'">
                                <Languages class="size-3 text-champagne-600" />
                                {{ previewLang === 'ar' ? 'EN' : 'ع' }}
                            </button>
                            <button type="button"
                                class="inline-flex items-center gap-1 rounded-full border border-champagne-200 bg-white px-2.5 py-1.5 text-[9px] font-bold text-ink-700"
                                @click="previewOpen = true">
                                <Maximize2 class="size-3 text-champagne-600" />
                                {{ t('wizard.envelopePreview') }}
                            </button>
                        </div>
                    </div>

                    <div
                        class="mt-2.5 overflow-hidden rounded-[1.4rem] border border-champagne-200 bg-white shadow-[0_24px_60px_-45px_rgba(61,44,21,.65)]">
                        <div class="max-h-[70vh] overflow-y-auto">
                            <div class="pointer-events-none">
                                <InvitationCard :invitation="previewInvitation" :lang="previewLang" preview />
                            </div>
                        </div>
                    </div>

                    <p class="mt-2 flex items-start gap-1.5 text-[10px] leading-5 text-ink-500">
                        <Sparkles class="mt-0.5 size-3 shrink-0 text-champagne-500" />
                        {{ t('wizard.previewHint') }}
                    </p>
                </div>
            </aside>
        </div>

        <Modal :open="previewOpen" :title="t('wizard.previewOpen')" :description="t('wizard.previewHint')"
            max-width="max-w-5xl" @close="previewOpen = false">
            <div
                class="-mx-5 -mb-5 max-h-[76vh] overflow-y-auto rounded-b-xl border-t border-champagne-200 sm:-mx-6 sm:-mb-6">
                <InvitationExperience :invitation="previewInvitation" :lang="previewLang" preview :music="false" />
            </div>
        </Modal>
    </div>
</template>
