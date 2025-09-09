<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import SettingsCard from '@/components/ui/SettingsCard.vue';
import { type BreadcrumbItem } from '@/types';
import { Lock, Key, Shield, CheckCircle } from 'lucide-vue-next';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Paramètres du mot de passe',
        href: '/settings/password',
    },
];

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: (errors: any) => {
            if (errors.password) {
                form.reset('password', 'password_confirmation');
                if (passwordInput.value instanceof HTMLInputElement) {
                    passwordInput.value.focus();
                }
            }

            if (errors.current_password) {
                form.reset('current_password');
                if (currentPasswordInput.value instanceof HTMLInputElement) {
                    currentPasswordInput.value.focus();
                }
            }
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Paramètres du mot de passe" />

        <SettingsLayout>
            <!-- Security Overview -->
            <SettingsCard 
                title="Sécurité du compte" 
                description="Maintenez votre compte sécurisé avec un mot de passe fort"
            >
                <div class="space-y-4">
                    <div class="flex items-center gap-3 p-4 rounded-lg bg-muted/30">
                        <Shield class="h-5 w-5 text-green-600 dark:text-green-400" />
                        <div>
                            <p class="text-sm font-medium text-foreground">Recommandations de sécurité</p>
                            <p class="text-xs text-muted-foreground">Utilisez au moins 8 caractères avec majuscules, minuscules et chiffres</p>
                        </div>
                    </div>
                </div>
            </SettingsCard>

            <!-- Password Update Form -->
            <SettingsCard 
                title="Changer le mot de passe" 
                description="Modifiez votre mot de passe actuel pour un nouveau plus sécurisé"
            >
                <form method="POST" @submit.prevent="updatePassword" class="space-y-6">
                    <div class="grid gap-3">
                        <Label for="current_password" class="flex items-center gap-2 font-medium">
                            <Lock class="h-4 w-4" />
                            Mot de passe actuel
                        </Label>
                        <Input
                            id="current_password"
                            ref="currentPasswordInput"
                            v-model="form.current_password"
                            type="password"
                            autocomplete="current-password"
                            placeholder="Entrez votre mot de passe actuel"
                            class="h-11"
                        />
                        <InputError :message="form.errors.current_password" />
                    </div>

                    <div class="grid gap-3">
                        <Label for="password" class="flex items-center gap-2 font-medium">
                            <Key class="h-4 w-4" />
                            Nouveau mot de passe
                        </Label>
                        <Input
                            id="password"
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            autocomplete="new-password"
                            placeholder="Choisissez un mot de passe fort"
                            class="h-11"
                        />
                        <InputError :message="form.errors.password" />
                    </div>

                    <div class="grid gap-3">
                        <Label for="password_confirmation" class="flex items-center gap-2 font-medium">
                            <Shield class="h-4 w-4" />
                            Confirmer le nouveau mot de passe
                        </Label>
                        <Input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            placeholder="Confirmez votre nouveau mot de passe"
                            class="h-11"
                        />
                        <InputError :message="form.errors.password_confirmation" />
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <Button :disabled="form.processing" class="min-w-44 gap-2">
                            <Key v-if="!form.processing" class="h-4 w-4" />
                            {{ form.processing ? 'Mise à jour...' : 'Mettre à jour le mot de passe' }}
                        </Button>

                        <Transition
                            enter-active-class="transition-all duration-300 ease-out"
                            enter-from-class="opacity-0 scale-95"
                            leave-active-class="transition-all duration-200 ease-in"
                            leave-to-class="opacity-0 scale-95"
                        >
                            <div v-show="form.recentlySuccessful" class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400">
                                <CheckCircle class="h-4 w-4" />
                                <span>Mot de passe mis à jour avec succès</span>
                            </div>
                        </Transition>
                    </div>
                </form>
            </SettingsCard>

            <!-- Security Tips -->
            <SettingsCard 
                title="Conseils de sécurité" 
                description="Bonnes pratiques pour protéger votre compte"
            >
                <div class="grid gap-3">
                    <div class="flex items-start gap-3">
                        <CheckCircle class="h-4 w-4 text-green-600 dark:text-green-400 mt-0.5" />
                        <div class="text-sm">
                            <p class="font-medium text-foreground">Utilisez un mot de passe unique</p>
                            <p class="text-muted-foreground text-xs">Ne réutilisez jamais ce mot de passe sur d'autres sites</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <CheckCircle class="h-4 w-4 text-green-600 dark:text-green-400 mt-0.5" />
                        <div class="text-sm">
                            <p class="font-medium text-foreground">Combinez différents types de caractères</p>
                            <p class="text-muted-foreground text-xs">Majuscules, minuscules, chiffres et symboles</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <CheckCircle class="h-4 w-4 text-green-600 dark:text-green-400 mt-0.5" />
                        <div class="text-sm">
                            <p class="font-medium text-foreground">Changez régulièrement</p>
                            <p class="text-muted-foreground text-xs">Mettez à jour votre mot de passe tous les 3-6 mois</p>
                        </div>
                    </div>
                </div>
            </SettingsCard>
        </SettingsLayout>
    </AppLayout>
</template>
