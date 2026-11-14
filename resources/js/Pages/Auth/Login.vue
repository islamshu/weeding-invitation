<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { Eye, EyeOff, LogIn, Sparkles } from 'lucide-vue-next';
import { ref } from 'vue';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import BaseInput from '../../Components/BaseInput.vue';
import BaseButton from '../../Components/BaseButton.vue';
import { useI18n } from '../../i18n';

const { t } = useI18n();
const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
}

function fillDemo() {
    form.email = 'demo@dawati.test';
    form.password = 'password';
}
</script>

<template>
    <GuestLayout :title="t('auth.welcomeBack')" :subtitle="t('auth.loginSubtitle')">
        <button
            type="button"
            class="mb-5 flex w-full items-center justify-between gap-3 rounded-2xl border border-dashed border-champagne-300 bg-champagne-100/30 px-4 py-3 text-start transition hover:bg-champagne-100/60"
            @click="fillDemo"
        >
            <span>
                <span class="flex items-center gap-2 text-xs font-bold text-ink-700">
                    <Sparkles class="size-3.5 text-champagne-600" />
                    {{ t('auth.demoTitle') }}
                </span>
                <span class="mt-1 block text-[11px] text-ink-500">{{ t('auth.demoHint') }}</span>
            </span>
            <span class="rounded-full bg-white px-3 py-1 text-[10px] font-bold text-burgundy-600">تجربة</span>
        </button>

        <form class="space-y-4" @submit.prevent="submit">
            <BaseInput
                v-model="form.email"
                :label="t('common.email')"
                type="email"
                dir="ltr"
                placeholder="name@example.com"
                autocomplete="email"
                required
                :error="form.errors.email"
            />

            <div class="relative">
                <BaseInput
                    v-model="form.password"
                    :label="t('common.password')"
                    :type="showPassword ? 'text' : 'password'"
                    dir="ltr"
                    placeholder="••••••••"
                    autocomplete="current-password"
                    required
                    :error="form.errors.password"
                />
                <button
                    type="button"
                    class="absolute end-3 top-9 rounded-full p-1 text-ink-500 transition hover:text-ink-900"
                    :aria-label="showPassword ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور'"
                    @click="showPassword = !showPassword"
                >
                    <EyeOff v-if="showPassword" class="size-4" />
                    <Eye v-else class="size-4" />
                </button>
            </div>

            <label class="flex items-center gap-2 text-xs text-ink-500">
                <input v-model="form.remember" type="checkbox" class="size-4 rounded border-champagne-300 text-burgundy-600 focus:ring-champagne-400" />
                {{ t('common.remember') }}
            </label>

            <BaseButton type="submit" block size="lg" :loading="form.processing">
                <LogIn v-if="!form.processing" class="size-4" />
                {{ form.processing ? t('auth.loadingLogin') : t('common.login') }}
            </BaseButton>
        </form>

        <p class="mt-6 text-center text-xs text-ink-500">
            {{ t('auth.noAccount') }}
            <Link href="/register" class="font-bold text-burgundy-600 hover:underline">{{ t('common.register') }}</Link>
        </p>
    </GuestLayout>
</template>
