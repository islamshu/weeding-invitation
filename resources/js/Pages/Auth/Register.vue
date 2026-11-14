<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { UserPlus } from 'lucide-vue-next';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import BaseInput from '../../Components/BaseInput.vue';
import BaseButton from '../../Components/BaseButton.vue';
import { useI18n } from '../../i18n';

const { t } = useI18n();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <GuestLayout :title="t('auth.registerTitle')" :subtitle="t('auth.registerSubtitle')">
        <form class="space-y-4" @submit.prevent="submit">
            <BaseInput
                v-model="form.name"
                :label="t('common.name')"
                :placeholder="t('auth.namePlaceholder')"
                autocomplete="name"
                required
                :error="form.errors.name"
            />

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

            <BaseInput
                v-model="form.password"
                :label="t('common.password')"
                type="password"
                dir="ltr"
                :hint="t('auth.passwordHint')"
                autocomplete="new-password"
                required
                :error="form.errors.password"
            />

            <BaseInput
                v-model="form.password_confirmation"
                :label="t('common.passwordConfirm')"
                type="password"
                dir="ltr"
                autocomplete="new-password"
                required
            />

            <p class="text-[11px] leading-6 text-ink-500">{{ t('auth.terms') }}</p>

            <BaseButton type="submit" block size="lg" :loading="form.processing">
                <UserPlus v-if="!form.processing" class="size-4" />
                {{ form.processing ? t('auth.loadingRegister') : t('common.register') }}
            </BaseButton>
        </form>

        <p class="mt-6 text-center text-xs text-ink-500">
            {{ t('auth.haveAccount') }}
            <Link href="/login" class="font-bold text-burgundy-600 hover:underline">{{ t('common.login') }}</Link>
        </p>
    </GuestLayout>
</template>
