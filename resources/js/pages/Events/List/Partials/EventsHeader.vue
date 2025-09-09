<template>
    <div class="border-b border-border pb-8">
        <!-- Breadcrumb navigation -->
        <nav class="mb-6 flex items-center gap-3" aria-label="Breadcrumb">
            <Link
                :href="route('dashboard')"
                class="flex items-center gap-2 text-sm text-muted-foreground transition-colors hover:text-foreground"
            >
                <Icon name="home" class="h-4 w-4" />
                <span>Tableau de bord</span>
            </Link>
            <Icon name="chevron-right" class="h-4 w-4 text-muted-foreground" />
            <span class="text-sm font-medium text-foreground">Événements</span>
        </nav>

        <!-- Main header content -->
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-3">
                    <div class="rounded-xl bg-gradient-to-br from-primary to-primary/90 p-2 shadow-sm">
                        <Icon name="calendar" class="h-6 w-6 text-primary-foreground" />
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-foreground">
                            Événements
                        </h1>
                    </div>
                </div>
                <p class="max-w-2xl leading-relaxed text-muted-foreground">
                    Gérez vos tâches et facturations pour tous vos projets.
                    <span v-if="isLoading" class="ml-2 inline-flex items-center gap-1 text-sm">
                        <span class="h-2 w-2 animate-pulse rounded-full bg-primary"></span>
                        Chargement...
                    </span>
                </p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row">
                <!-- Create event button -->
                <Button
                    @click="$emit('create')"
                    class="w-full border-0 bg-primary text-primary-foreground shadow-sm hover:bg-primary/90 sm:w-auto"
                >
                    <Icon name="plus" class="mr-2 h-4 w-4" />
                    Nouvel événement
                </Button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import Icon from '@/components/Icon.vue'
import { Button } from '@/components/ui/button'

interface Props {
    hasActiveFilters: boolean
    isLoading: boolean
}

defineProps<Props>()

defineEmits<{
    refresh: []
    create: []
}>()
</script>
