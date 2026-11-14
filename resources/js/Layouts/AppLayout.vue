<script setup>
import { computed, ref, watch } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { LayoutDashboard, Plus, LogOut, ChevronDown, Menu, X, Heart, Sparkles, UserRound } from 'lucide-vue-next';
import { useI18n } from '../i18n';
import LanguageSwitcher from '../Components/LanguageSwitcher.vue';
import ToastHost from '../Components/ToastHost.vue';
import { toast } from '../utils/toast';

const { t, locale } = useI18n();
const page = usePage();
const mobileOpen = ref(false);

const user = computed(() => page.props.auth?.user);
const url = computed(() => page.props.url ?? '');

watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    },
    { immediate: true, deep: true }
);

watch(() => page.props.url, () => (mobileOpen.value = false));

const initials = computed(() => (user.value?.name ?? '?').trim().charAt(0));
const isActive = (path) => url.value === path || url.value.startsWith(path + '/');

function logout() {
    router.post('/logout');
}
</script>

<template>
    <div class="app-bg min-h-screen">
        <header class="sticky top-0 z-50 border-b border-champagne-200/60 bg-ivory-100/85 backdrop-blur-xl">
            <div class="container-page flex h-[68px] items-center justify-between gap-4">
                <div class="flex items-center gap-7">
                    <Link href="/dashboard" class="group flex items-center gap-2.5">
                        <span class="relative flex size-10 items-center justify-center rounded-full border border-champagne-400/70 bg-white text-burgundy-600 shadow-sm">
                            <Heart class="size-4 fill-burgundy-600/10" />
                            <Sparkles class="absolute -end-1 -top-1 size-3 text-champagne-500" />
                        </span>
                        <span class="leading-none">
                            <span class="block font-serif text-xl font-semibold tracking-wide text-ink-900">{{ t('brand') }}</span>
                            <span class="mt-1 block text-[8px] font-bold tracking-[0.32em] text-champagne-600">{{ t('brand.latin') }}</span>
                        </span>
                    </Link>

                    <nav class="hidden items-center gap-1 md:flex">
                        <Link
                            href="/dashboard"
                            class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold transition"
                            :class="isActive('/dashboard') ? 'bg-white text-burgundy-600 shadow-sm' : 'text-ink-500 hover:bg-white/70 hover:text-ink-900'"
                        >
                            <LayoutDashboard class="size-4" />
                            {{ t('nav.dashboard') }}
                        </Link>
                        <Link
                            href="/invitations/create"
                            class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold transition"
                            :class="isActive('/invitations/create') ? 'bg-white text-burgundy-600 shadow-sm' : 'text-ink-500 hover:bg-white/70 hover:text-ink-900'"
                        >
                            <Plus class="size-4" />
                            {{ t('nav.newInvitation') }}
                        </Link>
                    </nav>
                </div>

                <div class="flex items-center gap-2">
                    <LanguageSwitcher class="hidden sm:inline-flex" />

                    <details class="group relative hidden md:block">
                        <summary class="flex cursor-pointer list-none items-center gap-2 rounded-full border border-champagne-200 bg-white/70 py-1.5 pe-2.5 ps-1.5 text-sm text-ink-700 transition hover:border-champagne-400">
                            <span class="flex size-8 items-center justify-center rounded-full bg-burgundy-600 text-xs font-bold text-ivory-50">{{ initials }}</span>
                            <span class="max-w-[120px] truncate font-semibold">{{ user?.name }}</span>
                            <ChevronDown class="size-3.5 text-ink-500 transition group-open:rotate-180" />
                        </summary>
                        <div class="absolute end-0 top-[calc(100%+8px)] w-60 overflow-hidden rounded-2xl border border-champagne-200 bg-ivory-50 shadow-2xl shadow-ink-900/10">
                            <div class="border-b border-champagne-100 px-4 py-3">
                                <p class="truncate text-sm font-bold text-ink-900">{{ user?.name }}</p>
                                <p class="mt-0.5 truncate text-xs text-ink-500">{{ user?.email }}</p>
                            </div>
                            <div class="p-2">
                                <Link href="/dashboard" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm text-ink-700 transition hover:bg-champagne-100/60">
                                    <UserRound class="size-4" />
                                    {{ t('nav.myInvitations') }}
                                </Link>
                                <button type="button" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm text-red-700 transition hover:bg-red-50" @click="logout">
                                    <LogOut class="size-4" />
                                    {{ t('common.logout') }}
                                </button>
                            </div>
                        </div>
                    </details>

                    <button
                        type="button"
                        class="rounded-full border border-champagne-200 bg-white/70 p-2.5 text-ink-700 md:hidden"
                        :aria-label="mobileOpen ? t('common.close') : 'menu'"
                        @click="mobileOpen = !mobileOpen"
                    >
                        <X v-if="mobileOpen" class="size-5" />
                        <Menu v-else class="size-5" />
                    </button>
                </div>
            </div>

            <Transition
                enter-active-class="transition duration-200"
                enter-from-class="opacity-0 -translate-y-2"
                leave-active-class="transition duration-150"
                leave-to-class="opacity-0 -translate-y-2"
            >
                <div v-if="mobileOpen" class="border-t border-champagne-200/70 bg-ivory-50 px-4 py-4 md:hidden">
                    <nav class="grid gap-1.5">
                        <Link href="/dashboard" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-ink-700 hover:bg-champagne-100/60">
                            <LayoutDashboard class="size-4" /> {{ t('nav.dashboard') }}
                        </Link>
                        <Link href="/invitations/create" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-ink-700 hover:bg-champagne-100/60">
                            <Plus class="size-4" /> {{ t('nav.newInvitation') }}
                        </Link>
                    </nav>
                    <div class="mt-3 flex items-center justify-between border-t border-champagne-200/70 pt-3">
                        <LanguageSwitcher />
                        <button type="button" class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-xs font-semibold text-red-700" @click="logout">
                            <LogOut class="size-4" /> {{ t('common.logout') }}
                        </button>
                    </div>
                </div>
            </Transition>
        </header>

        <main class="min-h-[70vh]">
            <slot />
        </main>

        <footer class="mt-16 border-t border-champagne-200/60 py-8">
            <div class="container-page flex flex-col items-center justify-between gap-3 text-xs text-ink-500 sm:flex-row">
                <p>© {{ new Date().getFullYear() }} {{ t('brand') }} · {{ t('footer.rights') }}</p>
                <p class="inline-flex items-center gap-1.5">
                    {{ t('footer.madeFor') }} <Heart class="size-3.5 text-burgundy-500" />
                </p>
            </div>
        </footer>

        <ToastHost />
    </div>
</template>
