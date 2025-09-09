<template>
    <Card class="group relative overflow-hidden rounded-2xl border border-border bg-card shadow-xl shadow-black/5 dark:shadow-black/20 ring-1 ring-border/20 transition-all duration-300 hover:shadow-2xl hover:shadow-black/10 dark:hover:shadow-black/40 self-stretch w-full lg:w-[50%] pb-0 flex flex-col">

        <!-- Header with quick actions -->
        <CardHeader class="relative z-10 pb-4 border-b border-border/50">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-3">
                    <div class="p-2 rounded-lg bg-gradient-to-br from-blue-100 to-blue-50 dark:from-blue-950/30 dark:to-blue-900/20">
                        <OptimizedIcon name="activity" :size="20" class="text-blue-600 dark:text-blue-400" preload />
                    </div>
                    <div class="space-y-1">
                        <CardTitle class="text-lg font-bold text-foreground">
                            Activités récentes
                        </CardTitle>
                        <p class="text-sm text-muted-foreground">
                            Vos dernières actions et événements
                        </p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="flex items-center gap-2">
                    <!-- Activity count badge -->
                    <div class="px-3 py-1.5 rounded-full bg-primary/10 border border-primary/20">
                        <span class="text-xs font-semibold text-primary">
                            {{ recentActivitiesCount }}
                        </span>
                    </div>

                    <!-- Refresh button -->
                    <button
                        @click="refreshActivities"
                        class="p-2 rounded-lg hover:bg-muted transition-colors text-muted-foreground hover:text-foreground"
                        title="Actualiser"
                    >
                        <OptimizedIcon name="refresh-cw" :size="16" :class="{ 'animate-spin': isLoading }" />
                    </button>
                </div>
            </div>
        </CardHeader>

        <CardContent class="relative z-10 overflow-hidden px-0 pb-0 min-h-[320px] flex-1 flex flex-col">
            <!-- Loading skeleton -->
            <div v-if="isLoading" class="p-4 space-y-3">
                <div v-for="i in 4" :key="i" class="animate-pulse">
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-muted/50 dark:bg-muted/20">
                        <div class="h-10 w-10 rounded-full bg-slate-200 dark:bg-muted"></div>
                        <div class="flex-1 space-y-2">
                            <div class="h-4 bg-slate-200 dark:bg-muted rounded w-3/4"></div>
                            <div class="h-3 bg-slate-200 dark:bg-muted rounded w-1/2"></div>
                        </div>
                        <div class="h-3 w-12 bg-slate-200 dark:bg-muted rounded"></div>
                    </div>
                </div>
            </div>

            <!-- Empty state -->
            <div v-else-if="!hasRecentActivities" class="flex flex-1 flex-col items-center justify-center p-8 text-center min-h-[280px]">
                <div class="relative mb-6">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 blur-lg opacity-20 animate-pulse"></div>
                    <div class="relative flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/25">
                        <OptimizedIcon name="clock" :size="28" class="text-white" preload />
                    </div>
                </div>
                <h3 class="mb-2 text-lg font-bold text-foreground">Prêt pour l'action ! ✨</h3>
                <p class="text-sm text-muted-foreground max-w-xs">
                    Vos premières activités apparaîtront ici dès que vous commencerez à travailler.
                </p>
                <p class="text-xs text-muted-foreground mt-2">
                    Créez votre première tâche ou événement
                </p>
            </div>

            <!-- Activities list -->
            <div v-else class="flex-1 flex flex-col">
                <!-- Quick stats bar -->
                <div class="px-4 py-3 bg-muted/30 border-b border-border/50">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-muted-foreground">
                            {{ recentActivitiesCount }} activité{{ recentActivitiesCount > 1 ? 's' : '' }} récente{{ recentActivitiesCount > 1 ? 's' : '' }}
                        </span>
                        <button
                            @click="router.visit(route('events.index'))"
                            class="text-primary hover:text-primary/80 font-medium transition-colors"
                        >
                            Voir tout →
                        </button>
                    </div>
                </div>

                <!-- Activities timeline -->
                <div class="relative">
                    <!-- Timeline line -->
                    <div class="absolute left-8 top-0 bottom-0 w-px bg-border/50"></div>

                    <div class="divide-y divide-border/30">
                        <div
                            v-for="(activity) in paginatedActivities"
                            :key="activity.id"
                            class="group relative px-4 py-4 hover:bg-muted/90 transition-all duration-200 cursor-pointer"
                            @click="router.visit(getActivityUrl(activity))"
                        >
                            <div class="flex items-start gap-4">
                                <!-- Timeline dot with activity type icon -->
                                <div class="relative z-10 flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center h-8 w-8 rounded-full border-2 border-border bg-card shadow-sm group-hover:shadow-md transition-all"
                                        :class="getActivityIconClasses(activity)"
                                    >
                                        <OptimizedIcon
                                            :name="getActivityIcon(activity)"
                                            :size="14"
                                            class="text-current"
                                        />
                                    </div>
                                </div>

                                <!-- Activity content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="flex-1">
                                            <!-- Activity title -->
                                            <h4 class="text-sm font-medium text-foreground group-hover:text-primary transition-colors line-clamp-1">
                                                {{ activity.name }}
                                            </h4>

                                            <!-- Activity metadata -->
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-xs px-2 py-0.5 rounded-full" :class="getActivityTypeClasses(activity)">
                                                    {{ getActivityTypeLabel(activity) }}
                                                </span>
                                                <span class="text-xs text-muted-foreground">
                                                    {{ activity.parent_project?.name || '' }}
                                                </span>
                                                <span class="text-xs text-muted-foreground font-bold">
                                                    {{ activity.parent_client?.name || '' }}
                                                </span>
                                            </div>

                                            <!-- Activity amount for billing -->
                                            <p v-if="activity.type === 'billing' && activity.formatted_amount"
                                               class="text-xs font-medium text-emerald-600 dark:text-emerald-400 mt-2">
                                                {{ activity.formatted_amount }}
                                            </p>

                                            <!-- Activity company -->
                                            <p v-if="activity.company"
                                               class="text-xs text-muted-foreground mt-1 line-clamp-2">
                                                {{ activity.company }}
                                            </p>
                                        </div>

                                        <!-- Time indicator -->
                                        <div class="flex-shrink-0 text-right">
                                            <span class="text-xs font-medium" :class="getTimeClasses(activity)">
                                                {{ activity.time_ago }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

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
import { useActivities } from '@/composables/dashboard/useActivities'
import type { Activity } from '@/types/dashboard/activities'

// Composable pour la logique des activités
const { isLoading, refreshActivities, paginatedActivities, goToPrevPage, goToNextPage, totalPages, hasPrevPage, hasNextPage, loadActivities, activitiesCount, currentPage } = useActivities()

// Charger les activités au montage
onMounted(() => {
    loadActivities()
})

// Les activités paginées viennent du composable

const recentActivitiesCount = computed(() => activitiesCount.value)
const hasRecentActivities = computed(() => activitiesCount.value > 0)

// Activity helpers
const getActivityUrl = (activity: Activity): string => {
    return activity.link || route('events.show', activity.id)
}

const getActivityIcon = (activity: Activity): string => {
    return activity.icon
}

const getActivityIconClasses = (activity: Activity): string => {
    if (activity.type === 'billing') {
        return 'text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-950/20 border-green-200 dark:border-green-800/30'
    }
    return 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/20 border-blue-200 dark:border-blue-800/30'
}

const getActivityTypeLabel = (activity: Activity): string => {
    return activity.status_label
}

const getActivityTypeClasses = (activity: Activity): string => {
    if (activity.type === 'billing') {
        return 'bg-green-100 dark:bg-green-950/30 text-green-700 dark:text-green-400'
    }
    return 'bg-blue-100 dark:bg-blue-950/30 text-blue-700 dark:text-blue-400'
}

const getStatusIndicatorClasses = (activity: Activity): string => {
    switch (activity.status) {
        case 'done':
        case 'sent':
        case 'paid':
            return 'bg-green-500'
        case 'created':
            return 'bg-orange-500'
        default:
            return 'bg-muted-foreground'
    }
}

const getTimeClasses = (activity: Activity): string => {
    const date = new Date(activity.timestamp)
    const now = new Date()
    const diffHours = Math.floor((now.getTime() - date.getTime()) / (1000 * 60 * 60))

    if (diffHours < 2) return 'text-primary'
    if (diffHours < 24) return 'text-foreground'
    return 'text-muted-foreground'
}
</script>
