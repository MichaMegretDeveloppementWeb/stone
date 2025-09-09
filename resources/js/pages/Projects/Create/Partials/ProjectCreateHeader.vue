<template>
    <div class="border-b border-border pb-8">
        <!-- Breadcrumb -->
        <div class="mb-6 flex items-center gap-3 text-sm">
            <!-- Skeleton pour breadcrumb -->
            <div v-if="isLoading" class="flex items-center gap-3">
                <div class="h-4 w-16 bg-muted rounded animate-pulse"></div>
                <div class="h-4 w-px bg-muted"></div>
                <div class="h-4 w-20 bg-muted rounded animate-pulse"></div>
                <div class="h-4 w-px bg-muted"></div>
                <div class="h-4 w-28 bg-muted rounded animate-pulse"></div>
            </div>
            <!-- Breadcrumb réel -->
            <template v-else-if="!hasError">
                <Link :href="route('dashboard')" class="flex items-center gap-2 text-muted-foreground hover:text-foreground transition-colors">
                    <Icon name="home" class="h-4 w-4" />
                    <span>Tableau de bord</span>
                </Link>
                <div class="h-4 w-px bg-muted"></div>
                <Link :href="route('projects.index')" class="text-muted-foreground transition-colors hover:text-foreground">
                    Projets
                </Link>
                <div class="h-4 w-px bg-muted"></div>
                <span class="font-medium text-foreground">Nouveau projet</span>
            </template>
        </div>

        <!-- Main header content -->
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-3">
                    <div class="rounded-xl bg-gradient-to-br from-primary to-primary/90 p-2 shadow-sm">
                        <Icon name="folder-plus" class="h-6 w-6 text-primary-foreground" />
                    </div>
                    <div>
                        <!-- Skeleton pour titre -->
                        <div v-if="isLoading" class="space-y-2">
                            <div class="h-8 w-48 bg-muted rounded animate-pulse"></div>
                            <div class="h-4 w-32 bg-muted rounded animate-pulse"></div>
                        </div>
                        <!-- Erreur -->
                        <div v-else-if="hasError">
                            <h1 class="text-2xl font-bold tracking-tight text-foreground">Erreur</h1>
                            <p class="text-sm text-muted-foreground">Impossible de charger les données</p>
                        </div>
                        <!-- Données réelles -->
                        <div v-else>
                            <h1 class="text-2xl font-bold tracking-tight text-foreground">
                                Nouveau projet
                            </h1>
                            <p class="text-sm text-muted-foreground">
                                Créez un nouveau projet pour vos clients
                            </p>
                        </div>
                    </div>
                </div>
                <p class="max-w-2xl leading-relaxed text-muted-foreground">
                    {{ hasError ? 'Impossible de charger les données nécessaires à la création.' : 'Renseignez les informations de votre nouveau projet pour commencer votre suivi.' }}
                </p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col gap-2 sm:flex-row">
                <!-- Skeleton pour boutons -->
                <div v-if="isLoading" class="flex gap-2">
                    <div class="h-10 w-32 bg-muted rounded animate-pulse"></div>
                </div>
                <!-- Boutons réels -->
                <template v-else>
                    <!-- Bouton retour -->
                    <Button
                        variant="outline"
                        as-child
                        class="w-full border-border hover:bg-muted/50 sm:w-auto"
                    >
                        <Link :href="route('projects.index')">
                            <Icon name="arrow-left" class="mr-2 h-4 w-4" />
                            Retour à la liste
                        </Link>
                    </Button>
                </template>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import Icon from '@/components/Icon.vue'
import { Button } from '@/components/ui/button'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

interface Props {
    isLoading: boolean
    hasError: boolean
}

defineProps<Props>()
</script>