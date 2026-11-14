<script setup>
import { computed, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ArrowLeft, Eye, Globe2, Languages, Pencil, Rocket, Share2, Undo2 } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import InvitationExperience from '../../Components/InvitationExperience.vue';
import ShareInvitation from '../../Components/ShareInvitation.vue';
import Modal from '../../Components/Modal.vue';
import MusicToggle from '../../Components/MusicToggle.vue';
import StatusBadge from '../../Components/StatusBadge.vue';
import BaseButton from '../../Components/BaseButton.vue';
import { buildView } from '../../utils/invitation';
import { translate, useI18n } from '../../i18n';

const props = defineProps({
    invitation: { type: Object, required: true },
});

const { locale, t } = useI18n();
const lang = ref(locale.value === 'en' && props.invitation.enable_english ? 'en' : 'ar');
const opened = ref(false);
const shareOpen = ref(false);
const working = ref(false);

const view = computed(() => buildView(props.invitation, lang.value));
const isPublished = computed(() => props.invitation.status === 'published');

const shareTitle = computed(() => t('public.og.title', {
    groom: view.value.couple.groom,
    bride: view.value.couple.bride,
}));

const shareText = computed(() =>
    translate('public.shareText', lang.value, {
        groom: view.value.couple.groom,
        bride: view.value.couple.bride,
    })
);

function togglePublish() {
    if (working.value) return;
    working.value = true;
    const url = `/invitations/${props.invitation.id}/${isPublished.value ? 'unpublish' : 'publish'}`;
    router.post(url, {}, {
        preserveScroll: true,
        onFinish: () => (working.value = false),
    });
}
</script>

<template>
    <Head :title="`${view.couple.groom} & ${view.couple.bride}`" />

    <AppLayout>
        <div class="container-page py-6 lg:py-8">
            <div class="flex flex-col gap-4 rounded-[1.4rem] border border-champagne-200 bg-white/70 p-4 backdrop-blur sm:p-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex min-w-0 items-center gap-3">
                    <Link
                        href="/dashboard"
                        class="flex size-10 shrink-0 items-center justify-center rounded-full border border-champagne-200 bg-white text-ink-700 transition hover:border-champagne-400"
                        :aria-label="t('common.back')"
                    >
                        <ArrowLeft class="size-4 rtl:rotate-180" />
                    </Link>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h1 class="truncate font-serif text-xl font-semibold text-ink-900">
                                {{ view.couple.groom }} <span class="text-champagne-500">&</span> {{ view.couple.bride }}
                            </h1>
                            <StatusBadge :status="invitation.status" />
                        </div>
                        <p class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-ink-500">
                            <span class="inline-flex items-center gap-1"><Eye class="size-3.5" /> {{ t('common.preview') }}</span>
                            <span v-if="view.event.dateShort" class="inline-flex items-center gap-1">{{ view.event.dateShort }}</span>
                            <span class="inline-flex items-center gap-1 text-champagne-600">{{ view.template.name_ar }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <MusicToggle :lang="lang" />

                    <button
                        v-if="invitation.enable_english"
                        type="button"
                        class="inline-flex items-center gap-1.5 rounded-full border border-champagne-200 bg-white px-3.5 py-2 text-xs font-semibold text-ink-700 transition hover:border-champagne-400"
                        @click="lang = lang === 'ar' ? 'en' : 'ar'"
                    >
                        <Languages class="size-4 text-champagne-600" />
                        {{ lang === 'ar' ? 'English' : 'العربية' }}
                    </button>

                    <BaseButton :href="`/invitations/${invitation.id}/edit`" variant="secondary" size="sm">
                        <Pencil class="size-3.5" />
                        {{ t('common.edit') }}
                    </BaseButton>

                    <BaseButton
                        v-if="isPublished"
                        variant="secondary"
                        size="sm"
                        :loading="working"
                        @click="togglePublish"
                    >
                        <Undo2 class="size-3.5" />
                        {{ t('common.unpublish') }}
                    </BaseButton>
                    <BaseButton v-else variant="primary" size="sm" :loading="working" @click="togglePublish">
                        <Rocket class="size-3.5" />
                        {{ t('common.publish') }}
                    </BaseButton>

                    <BaseButton v-if="isPublished" variant="gold" size="sm" @click="shareOpen = true">
                        <Share2 class="size-3.5" />
                        {{ t('common.share') }}
                    </BaseButton>
                </div>
            </div>

            <div v-if="invitation.public_url" class="mt-3 flex flex-wrap items-center gap-2 rounded-2xl border border-dashed border-champagne-300 bg-champagne-100/30 px-4 py-2.5">
                <Globe2 class="size-4 text-champagne-600" />
                <a :href="invitation.public_url" target="_blank" rel="noopener" class="min-w-0 flex-1 truncate text-xs font-medium text-ink-700 underline decoration-champagne-400/60 underline-offset-4" dir="ltr">
                    {{ invitation.public_url }}
                </a>
                <button type="button" class="rounded-full bg-white px-3 py-1.5 text-[10px] font-bold text-burgundy-600" @click="shareOpen = true">
                    {{ t('common.share') }}
                </button>
            </div>

            <div v-else class="mt-3 rounded-2xl border border-dashed border-stone-300 bg-stone-50 px-4 py-2.5 text-[11px] text-ink-500">
                {{ t('review.draftHint') }}
            </div>
        </div>

        <div class="mx-auto max-w-5xl px-3 pb-12 sm:px-5">
            <div class="overflow-hidden rounded-[1.6rem] border border-champagne-200 shadow-[0_30px_80px_-50px_rgba(61,44,21,.5)]">
                <InvitationExperience v-model:opened="opened" :invitation="invitation" :lang="lang" preview />
            </div>
        </div>

        <Modal
            :open="shareOpen"
            :title="t('public.shareTitle')"
            :description="t('public.guestNote')"
            max-width="max-w-md"
            @close="shareOpen = false"
        >
            <ShareInvitation
                v-if="invitation.public_url"
                :url="invitation.public_url"
                :text="shareText"
                :title="shareTitle"
                :lang="lang"
            />
        </Modal>
    </AppLayout>
</template>
