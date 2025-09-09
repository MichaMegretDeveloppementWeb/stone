<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import SettingsCard from '@/components/ui/SettingsCard.vue';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Mail, User as UserIcon, CheckCircle, AlertCircle } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type User } from '@/types';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Paramètres du profil',
        href: '/settings/profile',
    },
];

const page = usePage();
const user = page.props.auth.user as User;

const form = useForm({
    name: user.name,
    email: user.email,
});

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Paramètres du profil" />

        <SettingsLayout>
            <!-- Profile Overview Card -->
            <SettingsCard 
                title="Aperçu du profil" 
                description="Voici vos informations de profil actuelles"
            >
                <div class="flex items-start gap-6">
                    <Avatar class="h-20 w-20 ring-2 ring-border">
                        <AvatarFallback class="text-lg font-semibold bg-primary/10 text-primary">
                            {{ user.name.charAt(0).toUpperCase() }}
                        </AvatarFallback>
                    </Avatar>
                    
                    <div class="flex-1 space-y-3">
                        <div class="flex items-center gap-3">
                            <h4 class="text-xl font-semibold text-foreground">{{ user.name }}</h4>
                            <Badge v-if="user.email_verified_at" variant="secondary" class="gap-1.5">
                                <CheckCircle class="h-3.5 w-3.5 text-green-600 dark:text-green-400" />
                                Vérifiée
                            </Badge>
                            <Badge v-else variant="outline" class="gap-1.5">
                                <AlertCircle class="h-3.5 w-3.5 text-amber-600 dark:text-amber-400" />
                                Non vérifiée
                            </Badge>
                        </div>
                        
                        <div class="flex items-center gap-2 text-muted-foreground">
                            <Mail class="h-4 w-4" />
                            <span>{{ user.email }}</span>
                        </div>
                        
                        <div class="text-sm text-muted-foreground">
                            Membre depuis {{ new Date(user.created_at).toLocaleDateString('fr-FR', { 
                                year: 'numeric', 
                                month: 'long',
                                day: 'numeric' 
                            }) }}
                        </div>
                    </div>
                </div>
            </SettingsCard>

            <!-- Edit Profile Information -->
            <SettingsCard 
                title="Informations personnelles" 
                description="Mettez à jour votre nom et votre adresse email"
            >
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-3">
                        <Label for="name" class="flex items-center gap-2 font-medium">
                            <UserIcon class="h-4 w-4" />
                            Nom complet
                        </Label>
                        <Input 
                            id="name" 
                            v-model="form.name" 
                            required 
                            autocomplete="name" 
                            placeholder="Entrez votre nom complet"
                            class="h-11"
                        />
                        <InputError :message="form.errors.name" />
                    </div>

                    <div class="grid gap-3">
                        <Label for="email" class="flex items-center gap-2 font-medium">
                            <Mail class="h-4 w-4" />
                            Adresse email
                        </Label>
                        <Input
                            id="email"
                            type="email"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            placeholder="Entrez votre adresse email"
                            class="h-11"
                        />
                        <InputError :message="form.errors.email" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at" class="rounded-lg border border-amber-200 bg-amber-50 p-4 dark:border-amber-800/50 dark:bg-amber-900/20">
                        <div class="flex items-start gap-3">
                            <AlertCircle class="h-5 w-5 text-amber-600 dark:text-amber-400 mt-0.5" />
                            <div class="space-y-2">
                                <p class="text-sm font-medium text-amber-800 dark:text-amber-200">
                                    Email non vérifié
                                </p>
                                <p class="text-sm text-amber-700 dark:text-amber-300">
                                    Votre adresse email n'est pas vérifiée. 
                                    <Link
                                        :href="route('verification.send')"
                                        method="post"
                                        as="button"
                                        class="font-medium underline underline-offset-4 hover:no-underline transition-all"
                                    >
                                        Cliquez ici pour renvoyer l'email de vérification
                                    </Link>
                                </p>
                                <div v-if="status === 'verification-link-sent'" class="text-sm font-medium text-green-700 dark:text-green-300">
                                    ✓ Un nouveau lien de vérification a été envoyé
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <Button :disabled="form.processing" class="min-w-32">
                            {{ form.processing ? 'Sauvegarde...' : 'Sauvegarder' }}
                        </Button>

                        <Transition
                            enter-active-class="transition-all duration-300 ease-out"
                            enter-from-class="opacity-0 scale-95"
                            leave-active-class="transition-all duration-200 ease-in"
                            leave-to-class="opacity-0 scale-95"
                        >
                            <div v-show="form.recentlySuccessful" class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400">
                                <CheckCircle class="h-4 w-4" />
                                <span>Modifications sauvegardées avec succès</span>
                            </div>
                        </Transition>
                    </div>
                </form>
            </SettingsCard>

            <!-- Account Deletion Section -->
            <DeleteUser />
        </SettingsLayout>
    </AppLayout>
</template>
