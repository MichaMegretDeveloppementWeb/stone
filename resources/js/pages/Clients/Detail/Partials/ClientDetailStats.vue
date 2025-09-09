<template>
    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Section Statistiques Projets -->
        <Card class="border border-border bg-card shadow-sm gap-2">
            <CardHeader class="pb-4">
                <CardTitle class="flex items-center gap-2 text-foreground">
                    <Icon name="folder" class="h-5 w-5 text-muted-foreground" />
                    Projets
                </CardTitle>
            </CardHeader>
            <CardContent class="space-y-4">
                <div v-if="isLoading" class="animate-pulse">
                    <div class="grid grid-cols-2 gap-6 p-2">
                        <div v-for="i in 4" :key="i" class="aspect-square rounded-lg bg-muted p-3"></div>
                    </div>
                </div>
                <div v-else-if="client?.project_stats" class="grid grid-cols-2 gap-6 p-2">
                    <div class="aspect-square rounded-lg bg-muted/50 p-3 flex flex-col items-center justify-center">
                        <div class="text-lg font-bold text-primary">
                            {{ client.project_stats.total_projects }}
                        </div>
                        <div class="text-xs font-medium text-primary/80">Total</div>
                    </div>
                    <div class="aspect-square rounded-lg bg-muted/50 p-3 flex flex-col items-center justify-center">
                        <div class="text-lg font-bold text-emerald-600 dark:text-emerald-400">
                            {{ client.project_stats.active_projects }}
                        </div>
                        <div class="text-xs font-medium text-emerald-600/80 dark:text-emerald-400/80">Actifs</div>
                    </div>
                    <div class="aspect-square rounded-lg bg-muted/50 p-3 flex flex-col items-center justify-center">
                        <div class="text-lg font-bold text-foreground">
                            {{ client.project_stats.completed_projects }}
                        </div>
                        <div class="text-xs font-medium text-muted-foreground">Terminés</div>
                    </div>
                    <div class="aspect-square rounded-lg bg-muted/50 p-3 flex flex-col items-center justify-center">
                        <div class="text-lg font-bold text-amber-600 dark:text-amber-400">
                            {{ client.project_stats.on_hold_projects }}
                        </div>
                        <div class="text-xs font-medium text-amber-600/80 dark:text-amber-400/80">En pause</div>
                    </div>
                </div>
            </CardContent>
        </Card>

        <!-- Section Statistiques Financières -->
        <Card class="border border-border bg-card shadow-sm lg:col-span-2">
            <CardHeader class="pb-4">
                <CardTitle class="flex items-center gap-2 text-foreground">
                    <Icon name="banknote" class="h-5 w-5 text-muted-foreground" />
                    Facturation
                </CardTitle>
            </CardHeader>
            <CardContent class="space-y-4 mt-auto mb-auto">
                <div v-if="isLoading" class="animate-pulse space-y-4">
                    <!-- Skeleton pour les 2 cartes simples -->
                    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
                        <div class="border-1 border-border rounded-lg p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0 flex-1 space-y-2">
                                    <div class="h-3 w-20 bg-muted rounded"></div>
                                    <div class="h-6 w-24 bg-muted rounded"></div>
                                </div>
                                <div class="w-8 h-8 bg-muted rounded-full"></div>
                            </div>
                        </div>
                        <div class="border-1 border-border rounded-lg p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0 flex-1 space-y-2">
                                    <div class="h-3 w-28 bg-muted rounded"></div>
                                    <div class="h-6 w-24 bg-muted rounded"></div>
                                </div>
                                <div class="w-8 h-8 bg-muted rounded-full"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Skeleton pour la carte complexe -->
                    <div class="border-1 border-border rounded-lg p-4 space-y-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0 flex-1 space-y-2">
                                <div class="h-3 w-24 bg-muted rounded"></div>
                                <div class="h-6 w-32 bg-muted rounded"></div>
                            </div>
                            <div class="w-8 h-8 bg-muted rounded-full"></div>
                        </div>
                        <div class="grid gap-2 grid-cols-3">
                            <div class="space-y-1">
                                <div class="h-3 w-12 bg-muted rounded"></div>
                                <div class="h-4 w-16 bg-muted rounded"></div>
                            </div>
                            <div class="space-y-1">
                                <div class="h-3 w-14 bg-muted rounded"></div>
                                <div class="h-4 w-16 bg-muted rounded"></div>
                            </div>
                            <div class="space-y-1">
                                <div class="h-3 w-16 bg-muted rounded"></div>
                                <div class="h-4 w-16 bg-muted rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else-if="financialStats">
                    <!-- Ligne 1: Cards simples côte à côte -->
                    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
                        <!-- Total Facturé -->
                        <Card class="border-0 bg-card shadow-sm ring-1 ring-gray-200/60">
                            <CardContent class="p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-medium text-muted-foreground mb-1">Total facturé</p>
                                        <p class="text-lg font-bold text-foreground leading-tight">{{ formatCurrency(financialStats.total_billed || 0) }}</p>
                                    </div>
                                    <div class="rounded-full bg-purple-50 p-2 flex-shrink-0">
                                        <Icon name="calculator" class="h-4 w-4 text-purple-600" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        <!-- Factures à envoyer -->
                        <Card v-if="(parseFloat(financialStats.total_pending) || 0) > 0" class="border-0 bg-card shadow-sm ring-1 ring-gray-200/60">
                            <CardContent class="p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-medium text-muted-foreground mb-1">Factures à envoyer</p>
                                        <p class="text-lg font-bold text-foreground leading-tight">{{ formatCurrency(financialStats.total_pending || 0) }}</p>
                                    </div>
                                    <div class="rounded-full bg-blue-50 p-2 flex-shrink-0">
                                        <Icon name="send" class="h-4 w-4 text-blue-600" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        <!-- Card de remplacement si pas de factures à envoyer -->
                        <Card v-else class="border-0 bg-card shadow-sm ring-1 ring-gray-200/60">
                            <CardContent class="p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-medium text-muted-foreground mb-1">Factures à envoyer</p>
                                        <p class="text-lg font-bold text-muted-foreground leading-tight">{{ formatCurrency(0) }}</p>
                                    </div>
                                    <div class="rounded-full bg-muted/50 p-2 flex-shrink-0">
                                        <Icon name="send" class="h-4 w-4 text-muted-foreground/70" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <!-- Ligne 2: Card complexe seule -->
                    <Card class="border-0 bg-card shadow-sm ring-1 ring-gray-200/60 mt-4">
                        <CardContent class="p-4">
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-medium text-muted-foreground mb-1">Factures envoyées</p>
                                    <p class="text-lg font-bold text-foreground leading-tight">{{ formatCurrency(parseFloat(financialStats.total_sent) || 0) }}</p>
                                </div>
                                <div class="rounded-full bg-blue-50 p-2 flex-shrink-0">
                                    <Icon name="file-text" class="h-4 w-4 text-blue-600" />
                                </div>
                            </div>
                            <!-- Détail payé/à payer/en retard -->
                            <div class="grid gap-2 grid-cols-3 mt-6">
                                <div class="text-left">
                                    <span class="text-muted-foreground text-xs block">Payé</span>
                                    <span class="text-emerald-600 font-medium text-sm">{{ formatCurrency(financialStats.total_paid || 0) }}</span>
                                </div>
                                <div class="text-left">
                                    <span class="text-muted-foreground text-xs block">À payer</span>
                                    <span class="text-amber-600 font-medium text-sm">{{ formatCurrency(financialStats.total_upcoming_payment || 0) }}</span>
                                </div>
                                <div class="text-left">
                                    <span class="text-muted-foreground text-xs block">En retard</span>
                                    <span class="text-red-600 font-medium text-sm">{{ formatCurrency(financialStats.total_overdue_payment || 0) }}</span>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </CardContent>
        </Card>
    </div>
</template>

<script setup lang="ts">
import Icon from '@/components/Icon.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import type { ClientDetailStatsProps } from '@/types/clients/detail/index'

defineProps<ClientDetailStatsProps>()

function formatCurrency(amount: number | string | null | undefined): string {
    const value = parseFloat(String(amount)) || 0
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR',
    }).format(value).replace(/[\u202F\u00A0]/g, '\u2004')
}
</script>
