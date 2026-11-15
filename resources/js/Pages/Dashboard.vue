<script setup>
import { computed, ref } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import {
    CalendarDays,
    Copy,
    ExternalLink,
    Eye,
    FileText,
    Globe2,
    Heart,
    Languages,
    Pencil,
    Plus,
    Rocket,
    Share2,
    Sparkles,
    Trash2,
    Undo2,
} from 'lucide-vue-next';
import AppLayout from '../Layouts/AppLayout.vue';
import BaseButton from '../Components/BaseButton.vue';
import Modal from '../Components/Modal.vue';
import ShareInvitation from '../Components/ShareInvitation.vue';
import StatusBadge from '../Components/StatusBadge.vue';
import TemplateThumb from '../Components/TemplateThumb.vue';
import { formatShortDate } from '../utils/invitation';
import { getTemplate, templateName } from '../data/templates';
import { translate, useI18n } from '../i18n';
import { toast } from '../utils/toast';

const props = defineProps({
    invitations: { type: Array, default: () => [] },
    stats: {
        type: Object,
        default: () => ({ total: 0, published: 0, drafts: 0, unpublished: 0, views: 0 }),
    },
});

const page = usePage();
const { t, locale } = useI18n();

const user = computed(() => page.props.auth?.user);
const firstName = computed(() => (user.value?.name ?? '').trim().split(/\s+/)[0] || '');
const workingId = ref(null);
const deleteTarget = ref(null);
const shareTarget = ref(null);
const deleting = ref(false);

const stats = computed(() => [
    { key: 'total', label: t('dashboard.total'), value: props.stats.total ?? 0, icon: Heart, tone: 'burgundy' },
    { key: 'published', label: t('dashboard.published'), value: props.stats.published ?? 0, icon: Globe2, tone: 'emerald' },
    { key: 'drafts', label: t('dashboard.drafts'), value: props.stats.drafts ?? 0, icon: FileText, tone: 'amber' },
    { key: 'unpublished', label: t('dashboard.unpublished'), value: props.stats.unpublished ?? 0, icon: Eye, tone: 'stone' },
    { key: 'views', label: t('dashboard.views'), value: props.stats.views ?? 0, icon: Sparkles, tone: 'gold' },
]);

const tones = {
    burgundy: 'bg-burgundy-600/10 text-burgundy-600',
    emerald: 'bg-emerald-100 text-emerald-700',
    amber: 'bg-amber-100 text-amber-700',
    stone: 'bg-stone-100 text-stone-600',
    gold: 'bg-champagne-100 text-champagne-600',
};

const shareView = computed(() => {
    if (!shareTarget.value) return null;
    return {
        url: shareTarget.value.public_url,
        title: t('public.og.title', {
            groom: shareTarget.value.groom_name_ar,
            bride: shareTarget.value.bride_name_ar,
        }),
        text: translate('public.shareText', locale.value, {
            groom: shareTarget.value.groom_name_ar,
            bride: shareTarget.value.bride_name_ar,
        }),
    };
});

function isReady(invitation) {
    const events = invitation.event_details ?? {};
    return Boolean(
        invitation.groom_name_ar
        && invitation.bride_name_ar
        && events.wedding_date
        && events.wedding_time
        && events.venue_name_ar
    );
}

function togglePublish(invitation) {
    if (workingId.value) return;

    workingId.value = invitation.id;
    const action = invitation.status === 'published' ? 'unpublish' : 'publish';

    router.post(`/invitations/${invitation.id}/${action}`, {}, {
        preserveScroll: true,
        onFinish: () => (workingId.value = null),
    });
}

async function copyLink(invitation) {
    if (!invitation.public_url) return;

    try {
        if (navigator.clipboard?.writeText) {
            await navigator.clipboard.writeText(invitation.public_url);
        } else {
            const area = document.createElement('textarea');
            area.value = invitation.public_url;
            area.setAttribute('readonly', '');
            area.style.position = 'fixed';
            area.style.opacity = '0';
            document.body.appendChild(area);
            area.select();
            document.execCommand('copy');
            document.body.removeChild(area);
        }
        toast.success(t('dashboard.linkCopied'));
    } catch {
        toast.error(t('dashboard.copyFailed'));
    }
}

function openShare(invitation) {
    shareTarget.value = invitation;
}

function confirmDelete() {
    if (!deleteTarget.value || deleting.value) return;

    deleting.value = true;
    router.delete(`/invitations/${deleteTarget.value.id}`, {
        preserveScroll: true,
        onSuccess: () => (deleteTarget.value = null),
        onFinish: () => (deleting.value = false),
    });
}
</script>

<template>
    <Head :title="t('dashboard.title')" />

    <AppLayout>
        <div class="container-page py-6 lg:py-9">
            <!-- Hero -->
            <section class="relative overflow-hidden rounded-[1.8rem] border border-champagne-200 bg-gradient-to-br from-white via-ivory-50 to-champagne-100/60 p-5 shadow-[0_30px_80px_-60px_rgba(61,44,21,.6)] sm:p-7">
                <div class="pointer-events-none absolute -end-20 -top-24 size-64 rounded-full bg-champagne-200/30 blur-3xl" />
                <div class="pointer-events-none absolute -bottom-28 start-1/3 size-56 rounded-full bg-burgundy-500/5 blur-3xl" />

                <div class="relative flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                    <div class="min-w-0">
                        <p class="eyebrow">{{ t('dashboard.overview') }}</p>
                        <h1 class="luxury-title mt-2 text-2xl font-semibold sm:text-3xl">
                            {{ t('dashboard.welcome', { name: firstName || user?.name || '' }) }}
                        </h1>
                        <p class="mt-2 max-w-xl text-sm leading-7 text-ink-500">{{ t('dashboard.subtitle') }}</p>
                    </div>

                    <div class="flex shrink-0 flex-wrap items-center gap-2">
                        <BaseButton href="/invitations/create" size="lg">
                            <Plus class="size-4" />
                            {{ t('dashboard.new') }}
                        </BaseButton>
                        <Link
                            href="/"
                            class="inline-flex items-center gap-1.5 rounded-full border border-champagne-200 bg-white/70 px-4 py-3 text-xs font-semibold text-ink-600 transition hover:border-champagne-400"
                        >
                            <Sparkles class="size-3.5 text-champagne-600" />
                            {{ t('nav.home') }}
                        </Link>
                    </div>
                </div>
            </section>

            <!-- Stats -->
            <section class="mt-4 grid grid-cols-2 gap-2.5 sm:grid-cols-3 lg:grid-cols-5" :aria-label="t('dashboard.overview')">
                <div
                    v-for="stat in stats"
                    :key="stat.key"
                    class="rounded-2xl border border-champagne-200/80 bg-white/70 p-3.5 backdrop-blur-sm sm:p-4"
                >
                    <div class="flex items-center justify-between gap-2">
                        <span class="flex size-8 items-center justify-center rounded-xl" :class="tones[stat.tone]">
                            <component :is="stat.icon" class="size-4" />
                        </span>
                        <span class="text-xl font-bold tabular-nums text-ink-900 sm:text-2xl">{{ stat.value }}</span>
                    </div>
                    <p class="mt-2.5 text-[11px] font-semibold text-ink-500">{{ stat.label }}</p>
                </div>
            </section>

            <!-- Invitations -->
            <section class="mt-7">
                <div class="flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <p class="eyebrow">{{ t('nav.myInvitations') }}</p>
                        <h2 class="luxury-title mt-1.5 text-xl font-semibold sm:text-2xl">{{ t('dashboard.yourInvitations') }}</h2>
                    </div>
                    <span class="rounded-full border border-champagne-200 bg-white/70 px-3 py-1.5 text-[10px] font-bold text-ink-600">
                        {{ t('dashboard.invitationCount', { count: invitations.length }) }}
                    </span>
                </div>

                <div v-if="invitations.length" class="mt-4 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    <article
                        v-for="invitation in invitations"
                        :key="invitation.id"
                        class="group flex min-w-0 flex-col overflow-hidden rounded-[1.4rem] border border-champagne-200 bg-white/75 shadow-[0_20px_50px_-42px_rgba(61,44,21,.6)] backdrop-blur-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-[0_28px_60px_-40px_rgba(61,44,21,.55)]"
                    >
                        <!-- Preview -->
                        <div class="relative">
                            <div class="h-44 overflow-hidden bg-ivory-200 sm:h-48">
                                <TemplateThumb
                                    :template="getTemplate(invitation.template_key)"
                                    :groom="invitation.groom_name_ar"
                                    :bride="invitation.bride_name_ar"
                                    :groom-wakil="invitation.groom_wakil?.name_ar"
                                    :bride-wakil="invitation.bride_wakil?.name_ar"
                                    :lang="locale"
                                    rounded="rounded-none"
                                />
                            </div>

                            <div class="absolute inset-x-3 top-3 flex items-start justify-between gap-2">
                                <StatusBadge :status="invitation.status" />
                                <span
                                    v-if="invitation.enable_english"
                                    class="inline-flex items-center gap-1 rounded-full border border-white/60 bg-white/85 px-2 py-1 text-[9px] font-bold text-ink-700 backdrop-blur"
                                >
                                    <Languages class="size-3 text-champagne-600" />
                                    AR + EN
                                </span>
                            </div>

                            <div class="absolute inset-x-3 bottom-2 flex items-center justify-between gap-2 rounded-xl bg-ink-900/45 px-2.5 py-1.5 text-[9px] font-semibold text-white/90 backdrop-blur">
                                <span class="truncate">{{ templateName(getTemplate(invitation.template_key), locale) }}</span>
                                <span class="shrink-0 tabular-nums">{{ t('dashboard.viewsCount', { count: invitation.views_count ?? 0 }) }}</span>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="flex flex-1 flex-col p-4">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="min-w-0 truncate font-serif text-lg font-semibold text-ink-900">
                                    {{ invitation.groom_name_ar }}
                                    <span class="text-champagne-500">&</span>
                                    {{ invitation.bride_name_ar }}
                                </h3>
                                <button
                                    type="button"
                                    class="flex size-8 shrink-0 items-center justify-center rounded-full border border-champagne-200 text-ink-500 transition hover:border-champagne-400 hover:text-ink-900"
                                    :aria-label="t('dashboard.openPublic')"
                                    @click="router.visit(`/invitations/${invitation.id}/preview`)"
                                >
                                    <Eye class="size-3.5" />
                                </button>
                            </div>

                            <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-ink-500">
                                <span class="inline-flex items-center gap-1">
                                    <CalendarDays class="size-3.5 text-champagne-600" />
                                    {{ invitation.event_details?.wedding_date
                                        ? formatShortDate(invitation.event_details.wedding_date, locale)
                                        : t('dashboard.noDate') }}
                                </span>
                                <span class="inline-flex items-center gap-1">
                                    <Heart class="size-3.5 text-burgundy-500/70" />
                                    {{ invitation.enable_english ? t('dashboard.englishOn') : t('dashboard.arabicOnly') }}
                                </span>
                            </div>

                            <div class="mt-4 flex items-center gap-1.5 border-t border-champagne-100 pt-3">
                                <Link
                                    :href="`/invitations/${invitation.id}/edit`"
                                    class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-full bg-burgundy-600 px-3 py-2 text-[11px] font-bold text-ivory-50 transition hover:bg-burgundy-700"
                                >
                                    <Pencil class="size-3.5" />
                                    {{ t('common.edit') }}
                                </Link>

                                <Link
                                    :href="`/invitations/${invitation.id}/preview`"
                                    class="inline-flex size-9 items-center justify-center rounded-full border border-champagne-200 text-ink-600 transition hover:border-champagne-400 hover:bg-champagne-100/40"
                                    :aria-label="t('common.preview')"
                                >
                                    <Eye class="size-3.5" />
                                </Link>

                                <button
                                    v-if="invitation.public_url"
                                    type="button"
                                    class="inline-flex size-9 items-center justify-center rounded-full border border-champagne-200 text-ink-600 transition hover:border-champagne-400 hover:bg-champagne-100/40"
                                    :aria-label="t('dashboard.copyLink')"
                                    @click="copyLink(invitation)"
                                >
                                    <Copy class="size-3.5" />
                                </button>

                                <button
                                    v-if="invitation.public_url"
                                    type="button"
                                    class="inline-flex size-9 items-center justify-center rounded-full border border-champagne-200 text-ink-600 transition hover:border-champagne-400 hover:bg-champagne-100/40"
                                    :aria-label="t('common.share')"
                                    @click="openShare(invitation)"
                                >
                                    <Share2 class="size-3.5" />
                                </button>

                                <button
                                    type="button"
                                    class="inline-flex size-9 items-center justify-center rounded-full border border-stone-200 text-stone-500 transition hover:border-red-300 hover:bg-red-50 hover:text-red-700"
                                    :aria-label="t('common.delete')"
                                    @click="deleteTarget = invitation"
                                >
                                    <Trash2 class="size-3.5" />
                                </button>
                            </div>

                            <div class="mt-2 flex items-center gap-2">
                                <button
                                    v-if="invitation.status !== 'published'"
                                    type="button"
                                    class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-2 text-[10px] font-bold text-emerald-800 transition hover:bg-emerald-100 disabled:cursor-not-allowed disabled:opacity-50"
                                    :disabled="!isReady(invitation) || workingId === invitation.id"
                                    :title="!isReady(invitation) ? t('review.needMore') : t('dashboard.publishAction')"
                                    @click="togglePublish(invitation)"
                                >
                                    <Rocket class="size-3.5" />
                                    {{ t('dashboard.publishAction') }}
                                </button>

                                <button
                                    v-else
                                    type="button"
                                    class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-full border border-stone-200 bg-stone-50 px-3 py-2 text-[10px] font-bold text-stone-700 transition hover:bg-stone-100 disabled:opacity-50"
                                    :disabled="workingId === invitation.id"
                                    @click="togglePublish(invitation)"
                                >
                                    <Undo2 class="size-3.5" />
                                    {{ t('dashboard.unpublishAction') }}
                                </button>

                                <a
                                    v-if="invitation.public_url"
                                    :href="invitation.public_url"
                                    target="_blank"
                                    rel="noopener"
                                    class="inline-flex size-8 shrink-0 items-center justify-center rounded-full border border-champagne-200 text-ink-500 transition hover:border-champagne-400 hover:text-ink-900"
                                    :aria-label="t('dashboard.openPublic')"
                                >
                                    <ExternalLink class="size-3.5" />
                                </a>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Empty state -->
                <div
                    v-else
                    class="mt-4 overflow-hidden rounded-[1.6rem] border border-dashed border-champagne-300 bg-white/60 px-6 py-14 text-center"
                >
                    <div class="relative mx-auto flex size-20 items-center justify-center rounded-full border border-champagne-300 bg-ivory-50">
                        <Heart class="size-8 text-burgundy-600/70" />
                        <Sparkles class="absolute -end-1 -top-1 size-5 text-champagne-500" />
                    </div>
                    <h3 class="mt-5 font-serif text-xl font-semibold text-ink-900">{{ t('dashboard.emptyTitle') }}</h3>
                    <p class="mx-auto mt-2 max-w-md text-sm leading-7 text-ink-500">{{ t('dashboard.emptyDescription') }}</p>
                    <BaseButton href="/invitations/create" size="lg" class="mt-6">
                        <Plus class="size-4" />
                        {{ t('dashboard.createFirst') }}
                    </BaseButton>
                </div>
            </section>
        </div>

        <!-- Share modal -->
        <Modal
            :open="Boolean(shareTarget)"
            :title="t('public.shareTitle')"
            :description="t('public.guestNote')"
            max-width="max-w-md"
            @close="shareTarget = null"
        >
            <ShareInvitation
                v-if="shareView?.url"
                :url="shareView.url"
                :text="shareView.text"
                :title="shareView.title"
                :lang="locale"
            />
        </Modal>

        <!-- Delete modal -->
        <Modal
            :open="Boolean(deleteTarget)"
            :title="t('dashboard.deleteTitle')"
            :description="deleteTarget ? `${deleteTarget.groom_name_ar} & ${deleteTarget.bride_name_ar}` : ''"
            max-width="max-w-md"
            @close="deleteTarget = null"
        >
            <div class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-4">
                <Trash2 class="mt-0.5 size-5 shrink-0 text-red-700" />
                <div>
                    <p class="text-sm font-bold text-red-900">{{ t('common.areYouSure') }}</p>
                    <p class="mt-1 text-xs leading-6 text-red-800/80">{{ t('dashboard.deleteText') }}</p>
                </div>
            </div>

            <template #footer>
                <BaseButton variant="secondary" size="sm" :disabled="deleting" @click="deleteTarget = null">
                    {{ t('common.cancel') }}
                </BaseButton>
                <BaseButton variant="danger" size="sm" :loading="deleting" @click="confirmDelete">
                    <Trash2 v-if="!deleting" class="size-3.5" />
                    {{ t('common.delete') }}
                </BaseButton>
            </template>
        </Modal>
    </AppLayout>
</template>
