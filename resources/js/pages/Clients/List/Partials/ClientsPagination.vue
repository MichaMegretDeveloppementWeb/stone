<template>
    <div class="border-t border-border/70 bg-muted/20 px-6 py-4 sm:px-8">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <!-- Pagination info -->
            <div class="text-center text-sm text-muted-foreground sm:text-left">
                <span class="inline-flex items-center gap-1">
                    <span class="font-semibold text-foreground">{{ pageInfo.start }}</span>
                    <span class="text-muted-foreground/70">à</span>
                    <span class="font-semibold text-foreground">{{ pageInfo.end }}</span>
                    <span class="text-muted-foreground/70">sur</span>
                    <span class="rounded-md bg-primary/10 px-2 py-0.5 text-xs font-bold text-primary">
                        {{ pageInfo.total }}
                    </span>
                    <span class="text-muted-foreground">résultats</span>
                </span>
            </div>

            <!-- Pagination controls -->
            <div class="flex items-center justify-center gap-3">
                <!-- Previous button -->
                <Button
                    variant="outline"
                    size="sm"
                    :disabled="!canGoPrev"
                    @click="$emit('page-change', paginationState.currentPage - 1)"
                    class="group rounded-lg border-border bg-card px-3 py-2 text-foreground shadow-sm transition-all duration-200 hover:border-primary/30 hover:bg-primary/10 hover:text-primary hover:shadow-md disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:border-border disabled:hover:bg-card disabled:hover:text-foreground disabled:hover:shadow-sm"
                >
                    <Icon name="chevron-left" class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" />
                    <span class="ml-1.5 hidden font-medium sm:inline">Précédent</span>
                </Button>

                <!-- Page numbers -->
                <div class="hidden items-center gap-1.5 sm:flex">
                    <template v-for="(page, index) in visiblePages" :key="index">
                        <Button
                            v-if="page === -1"
                            variant="ghost"
                            size="sm"
                            disabled
                            class="h-9 w-9 cursor-default text-muted-foreground/70"
                        >
                            <Icon name="more-horizontal" class="h-4 w-4" />
                        </Button>
                        <Button
                            v-else
                            :variant="page === paginationState.currentPage ? 'default' : 'outline'"
                            size="sm"
                            class="h-9 w-9 rounded-lg font-medium shadow-sm transition-all duration-200"
                            :class="page === paginationState.currentPage
                                ? 'border-primary bg-gradient-to-b from-primary to-primary/90 text-primary-foreground shadow-primary/25 hover:from-primary/90 hover:to-primary/80 hover:shadow-primary/30'
                                : 'border-border bg-card text-foreground hover:border-primary/30 hover:bg-primary/10 hover:text-primary hover:shadow-md'"
                            @click="$emit('page-change', page)"
                        >
                            {{ page }}
                        </Button>
                    </template>
                </div>

                <!-- Mobile page indicator -->
                <div class="flex items-center gap-2.5 text-sm font-medium text-muted-foreground sm:hidden">
                    <span class="text-muted-foreground">Page</span>
                    <Input
                        :value="paginationState.currentPage"
                        type="number"
                        :min="1"
                        :max="paginationState.lastPage"
                        class="h-9 w-16 rounded-lg border-border bg-card text-center text-sm font-semibold text-foreground shadow-sm focus:border-primary focus:ring-2 focus:ring-primary/20"
                        @change="handlePageInput"
                    />
                    <span class="text-muted-foreground">sur</span>
                    <span class="rounded-md bg-muted px-2 py-1 text-xs font-bold text-foreground">
                        {{ paginationState.lastPage }}
                    </span>
                </div>

                <!-- Next button -->
                <Button
                    variant="outline"
                    size="sm"
                    :disabled="!canGoNext"
                    @click="$emit('page-change', paginationState.currentPage + 1)"
                    class="group rounded-lg border-border bg-card px-3 py-2 text-foreground shadow-sm transition-all duration-200 hover:border-primary/30 hover:bg-primary/10 hover:text-primary hover:shadow-md disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:border-border disabled:hover:bg-card disabled:hover:text-foreground disabled:hover:shadow-sm"
                >
                    <span class="mr-1.5 hidden font-medium sm:inline">Suivant</span>
                    <Icon name="chevron-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" />
                </Button>
            </div>

            <!-- Page size selector (optional) -->
            <div v-if="showPageSizeSelector" class="flex items-center gap-3 text-sm">
                <span class="text-muted-foreground">Afficher</span>
                <Select
                    :model-value="String(paginationState.perPage)"
                    @update:model-value="handlePageSizeChange"
                >
                    <SelectTrigger class="h-9 w-20 rounded-lg border-border bg-card shadow-sm transition-colors hover:border-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/20">
                        <SelectValue />
                    </SelectTrigger>
                    <SelectContent class="rounded-lg border-border shadow-lg">
                        <SelectItem
                            v-for="size in pageSizeOptions"
                            :key="size"
                            :value="String(size)"
                            class="rounded-md font-medium hover:bg-primary/10 hover:text-primary focus:bg-primary/10 focus:text-primary"
                        >
                            {{ size }}
                        </SelectItem>
                    </SelectContent>
                </Select>
                <span class="text-muted-foreground">par page</span>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import Icon from '@/components/Icon.vue'
import type { PaginationState } from '@/types/clients/list'

/**
 * Composant de pagination
 * Responsabilités :
 * - Navigation entre les pages
 * - Affichage des infos de pagination
 * - Changement de taille de page (optionnel)
 */

interface Props {
    paginationState: PaginationState
    pageInfo: {
        start: number
        end: number
        total: number
    }
    visiblePages: number[]
    canGoNext: boolean
    canGoPrev: boolean
    showPageSizeSelector?: boolean
    pageSizeOptions?: number[]
}

const props = withDefaults(defineProps<Props>(), {
    showPageSizeSelector: false,
    pageSizeOptions: () => [10, 15, 25, 50, 100]
})

const emit = defineEmits<{
    'page-change': [page: number]
    'page-size-change': [size: number]
}>()

const handlePageInput = (event: Event) => {
    const target = event.target as HTMLInputElement
    const page = parseInt(target.value, 10)

    if (page >= 1 && page <= props.paginationState.lastPage) {
        emit('page-change', page)
    }
}

const handlePageSizeChange = (value: string) => {
    const size = parseInt(value, 10)
    emit('page-size-change', size)
}
</script>
