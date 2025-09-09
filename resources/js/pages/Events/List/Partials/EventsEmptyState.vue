<template>
    <div class="py-12 text-center">
        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-muted/50">
            <Icon
                :name="hasActiveFilters ? 'search-x' : 'calendar-plus'"
                class="h-8 w-8 text-muted-foreground/70"
            />
        </div>

        <h3 class="mb-1 text-lg font-medium text-foreground">
            {{ hasActiveFilters ? 'Aucun événement trouvé' : 'Aucun événement' }}
        </h3>

        <p class="mb-4 text-sm text-muted-foreground">
            {{ hasActiveFilters
                ? 'Essayez de modifier vos critères de recherche'
                : 'Créez votre premier événement pour commencer'
            }}
        </p>

        <div class="flex flex-col gap-2 sm:flex-row sm:justify-center sm:gap-3">
            <Button
                v-if="hasActiveFilters"
                variant="outline"
                @click="$emit('clear-filters')"
                class="border-border hover:bg-muted/50"
            >
                <Icon name="filter-x" class="mr-2 h-4 w-4" />
                Effacer les filtres
            </Button>

            <Button
                as-child
                class="bg-primary text-primary-foreground hover:bg-primary/90"
                @click="$emit('create-event')"
            >
                <Link :href="route('events.create')">
                    <Icon name="plus" class="mr-2 h-4 w-4" />
                    Créer un événement
                </Link>
            </Button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button'
import Icon from '@/components/Icon.vue'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

interface Props {
    hasActiveFilters: boolean
}

defineProps<Props>()

defineEmits<{
    'clear-filters': []
    'create-event': []
}>()
</script>