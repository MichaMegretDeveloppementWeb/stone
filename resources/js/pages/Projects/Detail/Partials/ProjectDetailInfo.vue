<template>
    <Card class="border-0 bg-card shadow-sm ring-1 ring-gray-200/60 gap-0">
        <CardHeader class="border-b border-border">
            <CardTitle class="text-lg font-semibold text-foreground">Détails du projet</CardTitle>
        </CardHeader>
        <CardContent class="p-6">
            <!-- Description -->
            <div v-if="project.description" class="mb-8">
                <h4 class="text-md font-medium text-foreground mb-3">Description</h4>
                <div class="bg-muted/50 rounded-md p-4 sm:py-8">
                    <p class="text-foreground leading-relaxed whitespace-pre-line">{{ project.description }}</p>
                </div>
            </div>

            <!-- Dates et infos -->
            <div class="grid gap-8 sm:grid-cols-3 p-4">
                <div v-if="project.start_date">
                    <h4 class="text-sm font-medium text-foreground mb-2">Date de début</h4>
                    <div class="flex items-center gap-2 text-muted-foreground">
                        <Icon name="calendar" class="h-4 w-4" />
                        <span class="text-sm">{{ formatDate(project.start_date) }}</span>
                    </div>
                </div>

                <div v-if="project.end_date">
                    <h4 class="text-sm font-medium text-foreground mb-2">Date de fin prévue</h4>
                    <div class="flex items-center gap-2 text-muted-foreground">
                        <Icon name="flag" class="h-4 w-4" />
                        <span class="text-sm">{{ formatDate(project.end_date) }}</span>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-foreground mb-2">Dernière modification</h4>
                    <div class="flex items-center gap-2 text-muted-foreground">
                        <Icon name="clock" class="h-4 w-4" />
                        <span class="text-sm">{{ formatDate(project.updated_at) }}</span>
                    </div>
                </div>
            </div>
        </CardContent>
    </Card>
</template>

<script setup lang="ts">
import Icon from '@/components/Icon.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import type { ProjectDetailData } from '@/types/projects/detail'
import { useProjectDetailFormatters } from '@/composables/projects/detail/useProjectDetailFormatters'

interface Props {
    project: ProjectDetailData['project']
}

defineProps<Props>()

const { formatDate } = useProjectDetailFormatters()
</script>
