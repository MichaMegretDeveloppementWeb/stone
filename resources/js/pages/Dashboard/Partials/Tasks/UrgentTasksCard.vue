<template>
    <Card class="group relative overflow-hidden rounded-2xl border border-border bg-card shadow-xl shadow-black/5 dark:shadow-black/20 ring-1 ring-border/20 transition-all duration-300 hover:shadow-2xl hover:shadow-black/10 dark:hover:shadow-black/40 self-stretch w-full lg:w-[50%] lg:min-w-[20rem] flex flex-col">

        <!-- Header avec actions -->
        <CardHeader class="relative z-10 flex-shrink-0 space-y-0 pb-4 border-b border-border/50">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-3">
                    <div class="p-2 rounded-lg bg-gradient-to-br from-orange-100 to-orange-50 dark:from-orange-950/30 dark:to-orange-900/20">
                        <OptimizedIcon name="list-checks" :size="20" class="text-orange-600 dark:text-orange-400" preload />
                    </div>
                    <div class="space-y-1">
                        <CardTitle class="text-lg font-bold text-foreground">
                            {{ urgentOnly ? 'Tâches urgentes' : 'Tâches à faire' }}
                        </CardTitle>
                        <p class="text-sm text-muted-foreground">
                            Vos prochaines actions prioritaires
                        </p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="flex items-center gap-3">
                    <!-- Task count badge -->
                    <div class="px-3 py-1.5 rounded-full bg-primary/10 border border-primary/20">
                        <span class="text-xs font-semibold text-primary">
                            {{ urgentTasksCount }}
                        </span>
                    </div>

                    <!-- Toggle switch avec label -->
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-muted-foreground whitespace-nowrap">Urgent uniquement</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                :checked="urgentOnly"
                                @change="toggleUrgentFilter"
                                class="peer sr-only"
                            />
                            <div class="h-5 w-9 rounded-full bg-muted peer-checked:bg-orange-500 peer-focus:ring-2 peer-focus:ring-orange-300 transition-all duration-200"></div>
                            <div class="absolute left-0.5 top-0.5 h-4 w-4 rounded-full bg-card shadow-sm transition-transform duration-200 peer-checked:translate-x-4"></div>
                        </label>
                    </div>
                </div>
            </div>
        </CardHeader>

        <CardContent class="relative z-10 flex flex-1 flex-col p-0 min-h-[320px]">
            <!-- Loading skeleton -->
            <div v-if="isLoading" class="p-4 space-y-3">
                <div v-for="i in 3" :key="i" class="animate-pulse">
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-muted/50 dark:bg-muted/20">
                        <div class="h-4 w-4 rounded bg-slate-200 dark:bg-muted"></div>
                        <div class="flex-1 space-y-2">
                            <div class="h-4 bg-slate-200 dark:bg-muted rounded w-3/4"></div>
                            <div class="h-3 bg-slate-200 dark:bg-muted rounded w-1/2"></div>
                        </div>
                        <div class="h-6 w-16 bg-slate-200 dark:bg-muted rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Empty state -->
            <div v-else-if="urgentTasksCount === 0" class="flex flex-1 flex-col items-center justify-center p-8 text-center">
                <div class="relative mb-6">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 blur-lg opacity-20 animate-pulse"></div>
                    <div class="relative flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 shadow-lg shadow-green-500/25">
                        <OptimizedIcon name="check-circle" :size="28" class="text-white" preload />
                    </div>
                </div>
                <h3 class="mb-2 text-lg font-bold text-foreground">Excellent travail ! 🎉</h3>
                <p class="text-sm text-muted-foreground max-w-xs">
                    {{ urgentOnly ? 'Aucune tâche urgente en attente.' : 'Toutes vos tâches sont à jour.' }}
                </p>
                <p class="text-xs text-muted-foreground mt-2">
                    Profitez de ce moment de tranquillité !
                </p>
            </div>

            <!-- Tasks list moderne -->
            <div v-else class="flex-1 flex flex-col">
                <!-- Quick stats bar -->
                <div class="px-4 py-3 bg-muted/30 border-b border-border/50">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-muted-foreground">
                            {{ urgentTasksCount }} tâche{{ urgentTasksCount > 1 ? 's' : '' }}
                            {{ urgentOnly ? 'urgente' + (urgentTasksCount > 1 ? 's' : '') : 'en attente' }}
                        </span>
                        <button
                            @click="router.visit(route('events.index', { status: urgentOnly ? 'overdue' : 'todo' }))"
                            class="text-primary hover:text-primary/80 font-medium transition-colors"
                        >
                            Voir tout →
                        </button>
                    </div>
                </div>

                <!-- Tasks list with modern design -->
                <div class="divide-y divide-border/50">
                    <div
                        v-for="task in paginatedTasks"
                        :key="task.id"
                        class="group relative p-4 hover:bg-muted/90 transition-all duration-200 cursor-pointer"
                        @click="router.visit(route('events.show', task.id))"
                    >
                        <div class="flex items-start gap-3">
                            <!-- Task type icon -->
                            <div class="mt-1">
                                <div class="flex items-center justify-center h-6 w-6 rounded-full" :class="getTaskIconClasses(task)">
                                    <OptimizedIcon
                                        :name="getTaskIcon(task)"
                                        :size="12"
                                        class="text-current"
                                    />
                                </div>
                            </div>

                            <!-- Task content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-foreground group-hover:text-primary transition-colors"
                                            :class="task.status === 'done' ? 'line-through text-muted-foreground' : ''">
                                            {{ task.name }}
                                        </h4>

                                        <!-- Project context -->
                                        <div class="flex items-center flex-wrap gap-2 mt-1">
                                            <span class="text-xs text-muted-foreground">
                                                {{ task.project?.name || 'Sans projet' }}
                                            </span>
                                            <span class="text-xs text-muted-foreground font-bold">
                                                {{ task.project?.client?.name || 'Sans client' }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Due date badge -->
                                    <div v-if="hasExecutionDate(task)" class="flex-shrink-0">
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium"
                                            :class="getDueDateClasses(task)"
                                        >
                                            <OptimizedIcon name="calendar" :size="10" />
                                            {{ formatDueDate(task) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Task amount for billing tasks -->
                                <p v-if="task.event_type === 'billing' && (task as any).formatted_amount"
                                   class="text-xs font-medium text-emerald-600 dark:text-emerald-400 mt-2"
                                   :class="task.status === 'done' ? 'line-through' : ''">
                                    {{ (task as any).formatted_amount }}
                                </p>
                            </div>

                            <!-- Action indicator -->
                            <div class="mt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <OptimizedIcon name="chevron-right" :size="16" class="text-muted-foreground" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination footer -->
                <div v-if="totalPages > 1" class="border-t border-border/50 bg-muted/20 p-4 mt-auto">
                    <div class="flex items-center justify-center gap-2">
                        <button
                            @click="goToPrevPage"
                            :disabled="!hasPrevPage"
                            class="p-1.5 rounded-lg transition-colors"
                            :class="hasPrevPage ? 'hover:bg-muted text-foreground' : 'text-muted-foreground cursor-not-allowed'"
                        >
                            <OptimizedIcon name="chevron-left" :size="16" />
                        </button>

                        <span class="px-3 py-1 text-xs font-medium text-muted-foreground">
                            Page {{ currentPage }} sur {{ totalPages }}
                        </span>

                        <button
                            @click="goToNextPage"
                            :disabled="!hasNextPage"
                            class="p-1.5 rounded-lg transition-colors"
                            :class="hasNextPage ? 'hover:bg-muted text-foreground' : 'text-muted-foreground cursor-not-allowed'"
                        >
                            <OptimizedIcon name="chevron-right" :size="16" />
                        </button>
                    </div>
                </div>
            </div>
        </CardContent>
    </Card>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import OptimizedIcon from '@/components/OptimizedIcon.vue'
import { useTasks } from '@/composables/dashboard/useTasks'
import type { Task } from '@/types/dashboard/tasks'


// Composable pour la logique des tâches
const { isLoading, paginatedTasks, goToPrevPage, goToNextPage, totalPages, hasPrevPage, hasNextPage, loadTasks, taskCount, toggleUrgentFilter, urgentOnly, currentPage } = useTasks()

// Charger les tâches au montage
onMounted(() => {
    loadTasks()
})

// Les tâches paginées viennent du composable

const urgentTasksCount = computed(() => taskCount.value)

// Plus besoin de toggle status - navigation vers le détail seulement

// Task icon helpers
const getTaskIcon = (task: Task): string => {
    if (task.event_type === 'billing') {
        return 'credit-card'
    }
    return 'flag';
}

const getTaskIconClasses = (task: Task): string => {
    if (task.status === 'done') {
        return 'bg-green-100 dark:bg-green-950/20 text-green-600 dark:text-green-400'
    }
    if (task.event_type === 'billing') {
        return 'bg-emerald-100 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400'
    }
    return 'bg-blue-100 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400'
}

// Due date formatting - adapt to task types
const formatDueDate = (task: Task): string => {
    const date = task.event_type === 'step' ? (task as any).execution_date : (task as any).send_date
    if (!date) return ''

    const today = new Date()
    const dueDate = new Date(date)
    const diffTime = dueDate.getTime() - today.getTime()
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))

    if (diffDays === 0) return 'Aujourd\'hui'
    if (diffDays === 1) return 'Demain'
    if (diffDays === -1) return 'Hier'
    if (diffDays < 0) return `${Math.abs(diffDays)}j en retard`
    if (diffDays <= 7) return `${diffDays}j restants`

    return dueDate.toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'short'
    })
}

// Due date styling - adapt to task types
const getDueDateClasses = (task: Task): string => {
    const date = task.event_type === 'step' ? (task as any).execution_date : (task as any).send_date
    if (!date) return 'bg-muted/50 text-muted-foreground border border-border'

    const today = new Date()
    const dueDate = new Date(date)
    const diffTime = dueDate.getTime() - today.getTime()
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))

    if (diffDays < 0) {
        return 'text-red-600 dark:text-red-400'
    }
    if (diffDays === 0) {
        return 'bg-orange-100 dark:bg-orange-950/30 text-orange-700 dark:text-orange-400 border border-orange-200 dark:border-orange-800/30'
    }
    if (diffDays === 1) {
        return 'bg-yellow-100 dark:bg-yellow-950/30 text-yellow-700 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800/30'
    }
    return 'bg-muted/50 text-muted-foreground border border-border'
}

// Check if task has due date
const hasExecutionDate = (task: Task): boolean => {
    return task.event_type === 'step' ? !!(task as any).execution_date : !!(task as any).send_date
}

// Le composable gère la logique de filtre et pagination
</script>
