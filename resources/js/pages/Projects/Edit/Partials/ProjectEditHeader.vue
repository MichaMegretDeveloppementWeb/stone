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
                <div class="h-4 w-24 bg-muted rounded animate-pulse"></div>
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
                <Link
                    v-if="project"
                    :href="route('projects.show', project.id)"
                    class="text-muted-foreground transition-colors hover:text-foreground"
                >
                    {{ project.name }}
                </Link>
                <div class="h-4 w-px bg-muted"></div>
                <span class="font-medium text-foreground">Modifier</span>
            </template>
        </div>

        <!-- Main header content -->
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-3">
                    <div class="rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-2 shadow-sm">
                        <Icon name="edit" class="h-6 w-6 text-white" />
                    </div>
                    <div>
                        <!-- Skeleton pour titre -->
                        <div v-if="isLoading" class="space-y-2">
                            <div class="h-8 w-64 bg-muted rounded animate-pulse"></div>
                            <div class="h-4 w-48 bg-muted rounded animate-pulse"></div>
                        </div>
                        <!-- Erreur -->
                        <div v-else-if="hasError">
                            <h1 class="text-2xl font-bold tracking-tight text-foreground">Erreur</h1>
                            <p class="text-sm text-muted-foreground">Impossible de charger les données du projet</p>
                        </div>
                        <!-- Données réelles -->
                        <div v-else>
                            <h1 class="text-2xl font-bold tracking-tight text-foreground">
                                Modifier le projet
                            </h1>
                            <p class="text-sm text-muted-foreground">
                                {{ project?.name || '' }}
                            </p>
                        </div>
                </div>
            </div>

        </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import Icon from '@/components/Icon.vue'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import type { ProjectEditFormData } from '@/types/projects/edit'

interface Props {
    project: ProjectEditFormData | null
    isLoading: boolean
    hasError: boolean
}

defineProps<Props>()

// eslint-disable-next-line @typescript-eslint/no-unused-vars
function getStatusLabel(status: string): string {
    const labels = {
        active: 'Actif',
        completed: 'Terminé',
        on_hold: 'En pause',
        cancelled: 'Annulé',
    }
    return labels[status as keyof typeof labels] || status
}

</script>
