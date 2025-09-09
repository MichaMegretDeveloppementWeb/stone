<template>
    <Card v-if="shouldShowDetailsCard" class="border border-border bg-card shadow-sm">
        <CardHeader class="pb-4">
            <CardTitle class="flex items-center gap-2 text-foreground">
                <Icon name="file-text" class="h-5 w-5 text-muted-foreground" />
                Détails
            </CardTitle>
        </CardHeader>
        <CardContent class="space-y-6">
            <!-- Skeleton -->
            <div v-if="isLoading" class="space-y-4">
                <!-- Info cards skeleton -->
                <div class="grid gap-4">
                    <div class="h-16 bg-muted rounded-lg animate-pulse"></div>
                    <div class="h-16 bg-muted rounded-lg animate-pulse"></div>
                </div>
                <!-- Description skeleton -->
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="h-4 w-4 bg-muted rounded animate-pulse"></div>
                        <div class="h-4 bg-muted rounded w-20 animate-pulse"></div>
                    </div>
                    <div class="space-y-2">
                        <div class="h-4 bg-muted rounded animate-pulse"></div>
                        <div class="h-4 bg-muted rounded w-3/4 animate-pulse"></div>
                        <div class="h-4 bg-muted rounded w-1/2 animate-pulse"></div>
                    </div>
                </div>
            </div>

            <!-- Données réelles -->
            <template v-else-if="event">
                <!-- Informations principales -->
                <div class="flex items-center flex-wrap gap-4">

                    <!-- Catégorie -->
                    <div v-if="event.type" class="grow-1 flex items-center justify-between gap-4 p-3 rounded-lg bg-gradient-to-r from-primary/5 to-primary/10 border border-primary/20">
                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10">
                                <Icon name="tag" class="h-4 w-4 text-primary" />
                            </div>
                            <span class="text-sm font-medium text-muted-foreground">Catégorie</span>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary">
                            {{ event.type }}
                        </span>
                    </div>

                    <!-- Dernière modification -->
                    <div class="grow-1 flex items-center justify-between gap-4 p-3 rounded-lg bg-muted/20 border border-border">
                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-muted">
                                <Icon name="clock" class="h-4 w-4 text-muted-foreground" />
                            </div>
                            <span class="text-sm font-medium text-muted-foreground">Dernière modification</span>
                        </div>
                        <span class="text-sm font-medium text-foreground">
                            {{ formatDate(event.updated_at) }}
                        </span>
                    </div>

                </div>

                <!-- Description -->
                <div v-if="event.description" class="space-y-3">
                    <div class="flex items-center gap-2">
                        <Icon name="file-text" class="h-4 w-4 text-muted-foreground/70" />
                        <span class="text-sm font-medium text-foreground">Description</span>
                    </div>
                    <div class="rounded-lg bg-muted/50 p-4 border border-border">
                        <p class="text-foreground leading-relaxed">{{ event.description }}</p>
                    </div>
                </div>
            </template>
        </CardContent>
    </Card>
</template>

<script setup lang="ts">
import { computed, toRef } from 'vue'
import Icon from '@/components/Icon.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { useEventUtils } from '@/composables/events/detail/useEventUtils'
import type { EventDTO } from '@/types/models'

interface Props {
    event?: EventDTO | null
    isLoading?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    event: null,
    isLoading: false
})

const { formatDate } = useEventUtils(toRef(props, 'event'))

// Afficher la carte si il y a des détails à afficher ou en mode skeleton
const shouldShowDetailsCard = computed(() => {
    return props.isLoading || (props.event && (props.event.description || props.event.type))
})
</script>
