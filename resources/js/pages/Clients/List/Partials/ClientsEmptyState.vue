<template>
    <Card class="border-2 border-dashed border-border bg-card">
        <CardContent class="p-12">
            <div class="mx-auto max-w-md text-center">
                <div 
                    :class="[
                        'mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full',
                        hasActiveFilters ? 'bg-amber-50 dark:bg-amber-950/50' : 'bg-blue-50 dark:bg-blue-950/50'
                    ]"
                >
                    <Icon 
                        :name="hasActiveFilters ? 'search-x' : 'user-plus'"
                        :class="[
                            'h-10 w-10',
                            hasActiveFilters ? 'text-amber-500 dark:text-amber-400' : 'text-blue-500 dark:text-blue-400'
                        ]"
                    />
                </div>

                <h3 class="mb-2 text-xl font-semibold text-foreground">
                    {{ title }}
                </h3>
                
                <p class="mb-6 text-muted-foreground">
                    {{ description }}
                </p>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-center">
                    <Button
                        v-if="hasActiveFilters"
                        variant="outline"
                        @click="$emit('clear-filters')"
                    >
                        <Icon name="filter-x" class="mr-2 h-4 w-4" />
                        Effacer les filtres
                    </Button>
                    
                    <Button
                        v-if="!hasActiveFilters"
                        @click="$emit('create-client')"
                        class="bg-primary text-primary-foreground hover:bg-primary/90"
                    >
                        <Icon name="plus" class="mr-2 h-4 w-4" />
                        Créer votre premier client
                    </Button>
                </div>

                <!-- Suggestions pour débuter -->
                <div v-if="!hasActiveFilters" class="mt-8 text-left">
                    <h4 class="mb-3 text-sm font-medium text-foreground">
                        Pour commencer :
                    </h4>
                    <ul class="space-y-2 text-sm text-muted-foreground">
                        <li class="flex items-start gap-2">
                            <Icon name="check-circle" class="mt-0.5 h-4 w-4 flex-shrink-0 text-green-500 dark:text-green-400" />
                            <span>Ajoutez vos premiers clients avec leurs informations de contact</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <Icon name="check-circle" class="mt-0.5 h-4 w-4 flex-shrink-0 text-green-500 dark:text-green-400" />
                            <span>Créez des projets pour chaque engagement client</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <Icon name="check-circle" class="mt-0.5 h-4 w-4 flex-shrink-0 text-green-500 dark:text-green-400" />
                            <span>Suivez les événements et la facturation de vos projets</span>
                        </li>
                    </ul>
                </div>
            </div>
        </CardContent>
    </Card>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { Card, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import Icon from '@/components/Icon.vue'

/**
 * État vide de la liste clients
 * Responsabilités :
 * - Message contextuel selon les filtres
 * - Actions suggérées
 * - Guide de démarrage
 */

interface Props {
    hasActiveFilters?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    hasActiveFilters: false
})

defineEmits<{
    'clear-filters': []
    'create-client': []
}>()

const title = computed(() => {
    return props.hasActiveFilters 
        ? 'Aucun client ne correspond à vos critères'
        : 'Aucun client pour le moment'
})

const description = computed(() => {
    return props.hasActiveFilters
        ? 'Essayez de modifier ou d\'effacer vos filtres pour voir plus de résultats.'
        : 'Commencez à construire votre base de clients en ajoutant votre premier client.'
})
</script>