<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import { type BreadcrumbItem } from '@/types';
import { useAppearance } from '@/composables/useAppearance';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import SettingsCard from '@/components/ui/SettingsCard.vue';
import { Monitor, Moon, Sun, Palette, Eye, CheckCircle } from 'lucide-vue-next';

const { appearance, updateAppearance } = useAppearance();

const themeOptions = [
    { 
        value: 'light', 
        Icon: Sun, 
        label: 'Thème clair', 
        description: 'Interface claire et lumineuse',
        preview: 'bg-background border-2 border-border'
    },
    { 
        value: 'dark', 
        Icon: Moon, 
        label: 'Thème sombre', 
        description: 'Interface sombre et élégante',
        preview: 'bg-foreground border-2 border-border'
    },
    { 
        value: 'system', 
        Icon: Monitor, 
        label: 'Suivre le système', 
        description: 'S’adapte aux préférences de votre système',
        preview: 'bg-gradient-to-r from-background to-foreground border-2 border-border'
    },
] as const;

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Paramètres d\'apparence',
        href: '/settings/appearance',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Paramètres d'apparence" />

        <SettingsLayout>
            <!-- Current Theme Overview -->
            <SettingsCard 
                title="Apparence actuelle" 
                description="Aperçu de votre thème actuel et ses caractéristiques"
            >
                <div class="flex items-center gap-4 p-4 rounded-lg bg-muted/30">
                    <div class="p-3 rounded-full bg-primary/10">
                        <component 
                            :is="themeOptions.find(option => option.value === appearance)?.Icon || Palette" 
                            class="h-6 w-6 text-primary" 
                        />
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-foreground">
                            {{ themeOptions.find(option => option.value === appearance)?.label || 'Personnalisé' }}
                        </p>
                        <p class="text-sm text-muted-foreground">
                            {{ themeOptions.find(option => option.value === appearance)?.description || 'Configuration personnalisée' }}
                        </p>
                    </div>
                    <div class="w-12 h-8 rounded-md" :class="themeOptions.find(option => option.value === appearance)?.preview || 'bg-primary'"></div>
                </div>
            </SettingsCard>

            <!-- Theme Selection -->
            <SettingsCard 
                title="Choisir un thème" 
                description="Sélectionnez le thème qui correspond le mieux à vos préférences"
            >
                <div class="grid gap-3">
                    <div
                        v-for="option in themeOptions"
                        :key="option.value"
                        @click="updateAppearance(option.value)"
                        class="group relative cursor-pointer rounded-xl border p-4 transition-all duration-200 hover:border-primary/50 hover:bg-accent/30"
                        :class="[
                            appearance === option.value 
                                ? 'border-primary bg-primary/5 ring-2 ring-primary/20' 
                                : 'border-border hover:shadow-sm'
                        ]"
                    >
                        <!-- Selection Indicator -->
                        <div 
                            v-if="appearance === option.value"
                            class="absolute top-3 right-3 flex h-5 w-5 items-center justify-center rounded-full bg-primary"
                        >
                            <CheckCircle class="h-3 w-3 text-primary-foreground" />
                        </div>

                        <div class="flex items-start gap-4">
                            <!-- Theme Preview -->
                            <div class="relative">
                                <div class="w-16 h-10 rounded-lg" :class="option.preview"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <component :is="option.Icon" class="h-5 w-5" :class="option.value === 'dark' ? 'text-primary-foreground' : option.value === 'light' ? 'text-primary' : 'text-muted-foreground'" />
                                </div>
                            </div>

                            <!-- Theme Info -->
                            <div class="flex-1">
                                <h3 class="font-semibold text-foreground group-hover:text-primary transition-colors"
                                    :class="appearance === option.value ? 'text-primary' : ''"
                                >
                                    {{ option.label }}
                                </h3>
                                <p class="text-sm text-muted-foreground mt-0.5">
                                    {{ option.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </SettingsCard>

            <!-- Theme Information -->
            <SettingsCard 
                title="À propos des thèmes" 
                description="Informations sur les différentes options d'apparence disponibles"
            >
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <Eye class="h-4 w-4 text-muted-foreground mt-0.5" />
                        <div class="text-sm">
                            <p class="font-medium text-foreground">Adaptation automatique</p>
                            <p class="text-muted-foreground text-xs mt-0.5">
                                Le thème « Suivre le système » s'adapte automatiquement aux préférences de votre système d'exploitation
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <Palette class="h-4 w-4 text-muted-foreground mt-0.5" />
                        <div class="text-sm">
                            <p class="font-medium text-foreground">Persistance des préférences</p>
                            <p class="text-muted-foreground text-xs mt-0.5">
                                Votre choix de thème est sauvegardé localement et appliqué à toutes vos sessions
                            </p>
                        </div>
                    </div>
                </div>
            </SettingsCard>
        </SettingsLayout>
    </AppLayout>
</template>
