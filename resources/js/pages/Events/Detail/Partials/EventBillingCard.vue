<template>
    <Card v-if="shouldShowBillingCard" class="border border-border bg-card shadow-sm">
        <CardHeader class="pb-4">
            <CardTitle class="flex items-center gap-2 text-base text-foreground">
                <Icon name="credit-card" class="h-4 w-4 text-muted-foreground" />
                Facturation
            </CardTitle>
        </CardHeader>
        <CardContent class="space-y-4">
            <!-- Skeleton -->
            <div v-if="isLoading" class="space-y-4">
                <!-- Amount skeleton -->
                <div class="flex items-center gap-2">
                    <div class="h-4 w-4 bg-muted rounded animate-pulse"></div>
                    <div class="space-y-1 flex-1">
                        <div class="h-4 bg-muted rounded w-24 animate-pulse"></div>
                        <div class="h-6 bg-muted rounded w-20 animate-pulse"></div>
                    </div>
                </div>
                <!-- Date skeleton -->
                <div class="flex items-center gap-2">
                    <div class="h-4 w-4 bg-muted rounded animate-pulse"></div>
                    <div class="space-y-1 flex-1">
                        <div class="h-4 bg-muted rounded w-32 animate-pulse"></div>
                        <div class="h-3 bg-muted rounded w-24 animate-pulse"></div>
                    </div>
                </div>
                <!-- Alert skeleton -->
                <div class="h-12 bg-muted rounded-lg animate-pulse"></div>
            </div>

            <!-- Données réelles -->
            <template v-else-if="event">
                <!-- Montant facturé -->
                <div class="flex items-center gap-2">
                    <Icon name="banknote" class="h-4 w-4 text-muted-foreground/70" />
                    <div class="flex-1">
                        <div class="text-sm font-medium text-foreground">Montant facturé</div>
                        <div class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ formatCurrency(event.amount || 0) }}</div>
                    </div>
                </div>

                <!-- Échéance de paiement -->
                <div v-if="event.payment_due_date" class="flex items-center gap-2">
                    <Icon name="clock" class="h-4 w-4 text-muted-foreground/70" />
                    <div class="flex-1">
                        <div class="text-sm font-medium text-foreground">Échéance de paiement</div>
                        <div class="text-sm text-muted-foreground">{{ formatDate(event.payment_due_date) }}</div>
                    </div>
                </div>

                <!-- Alerte d'annulation pour les facturations -->
                <div v-if="event.status === 'cancelled'" class="rounded-lg bg-muted/50 border border-border p-3">
                    <div class="flex items-center gap-2">
                        <Icon name="x-circle" class="h-4 w-4 text-muted-foreground" />
                        <span class="text-sm font-medium text-foreground">
                            Événement annulé
                        </span>
                    </div>
                </div>

                <!-- Informations de paiement complètes (masquées si annulé) -->
                <template v-else>
                    <!-- Date de paiement (si payé) -->
                    <div v-if="event.payment_status === 'paid' && event.paid_at" class="flex items-center gap-2">
                        <Icon name="check" class="h-4 w-4 text-emerald-500" />
                        <div class="flex-1">
                            <div class="text-sm font-medium text-foreground">Payé le</div>
                            <div class="text-sm text-muted-foreground">{{ formatDate(event.paid_at) }}</div>
                        </div>
                    </div>

                    <!-- Indicateur de retard de paiement -->
                    <div v-if="event.is_payment_overdue" class="rounded-lg bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800/30 p-3">
                        <div class="flex items-center gap-2">
                            <Icon name="alert-triangle" class="h-4 w-4 text-red-600 dark:text-red-400" />
                            <span class="text-sm font-medium text-red-800 dark:text-red-300">
                                Paiement en retard de {{ getDaysOverdue(event.payment_due_date) }} jour{{ getDaysOverdue(event.payment_due_date) > 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>

                    <!-- Indicateur d'écart de paiement par rapport à l'échéance (pour les factures payées) -->
                    <div v-else-if="event.payment_status === 'paid' && event.paid_at && getBillingCompletionDelay() !== 0" class="rounded-lg p-3" :class="getBillingCompletionDelayClass()">
                        <div class="flex items-center gap-2">
                            <Icon :name="getBillingCompletionDelayIcon()" class="h-4 w-4" />
                            <span class="text-sm font-medium">{{ getBillingCompletionDelayText() }}</span>
                        </div>
                    </div>

                    <!-- Indicateurs d'échéances proches (pour les factures non payées) -->
                    <div v-else-if="getBillingUrgencyLevel()" class="rounded-lg p-3" :class="getBillingUrgencyClass()">
                        <div class="flex items-center gap-2">
                            <Icon :name="getBillingUrgencyIcon()" class="h-4 w-4" />
                            <span class="text-sm font-medium">{{ getBillingUrgencyText() }}</span>
                        </div>
                    </div>
                </template>
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

const { formatDate, formatCurrency, getDaysOverdue, getDaysUntil } = useEventUtils(toRef(props, 'event'))

// Afficher la carte uniquement si c'est un événement de facturation ou en mode skeleton
const shouldShowBillingCard = computed(() => {
    return props.isLoading || (props.event?.event_type === 'billing')
})

// Fonctions pour la section Facturation (copiées de Show.vue original)
const getBillingUrgencyLevel = () => {
    if (!props.event || props.event.payment_status === 'paid') return null

    const referenceDate = props.event.payment_due_date
    if (!referenceDate) return null

    const daysUntil = getDaysUntil(referenceDate)

    if (daysUntil < 0) return 'overdue'
    if (daysUntil === 0) return 'today'
    if (daysUntil === 1) return 'high'
    if (daysUntil <= 3) return 'medium'

    return null
}

const getBillingUrgencyClass = () => {
    const level = getBillingUrgencyLevel()
    switch (level) {
        case 'overdue': return 'bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800/30 text-red-800 dark:text-red-300'
        case 'high': return 'bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800/30 text-red-800 dark:text-red-300'
        case 'today': return 'bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800/30 text-amber-800 dark:text-amber-300'
        case 'medium': return 'bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800/30 text-amber-800 dark:text-amber-300'
        default: return ''
    }
}

const getBillingUrgencyIcon = () => {
    const level = getBillingUrgencyLevel()
    switch (level) {
        case 'overdue': return 'alert-triangle'
        case 'high': return 'alert-triangle'
        case 'today': return 'clock'
        case 'medium': return 'clock'
        default: return 'info'
    }
}

const getBillingUrgencyText = () => {
    const referenceDate = props.event?.payment_due_date
    if (!referenceDate) return ''

    const daysUntil = getDaysUntil(referenceDate)

    if (daysUntil < 0) {
        const daysOverdue = Math.abs(daysUntil)
        return `Paiement en retard de ${daysOverdue} jour${daysOverdue > 1 ? 's' : ''}`
    }

    if (daysUntil === 0) return `Paiement prévu aujourd'hui`
    if (daysUntil === 1) return `Paiement prévu demain`
    if (daysUntil <= 3) return `Paiement prévu dans ${daysUntil} jours`

    return ''
}

// Fonctions pour l'écart par rapport à l'échéance de paiement (factures payées)
const getBillingCompletionDelay = () => {
    if (!props.event?.paid_at || props.event.payment_status !== 'paid') return 0

    const referenceDate = props.event.payment_due_date
    if (!referenceDate) return 0

    const paidDate = new Date(props.event.paid_at)
    paidDate.setHours(0, 0, 0, 0)

    const dueDate = new Date(referenceDate)
    dueDate.setHours(0, 0, 0, 0)

    const diffTime = paidDate - dueDate
    return Math.floor(diffTime / (1000 * 60 * 60 * 24))
}

const getBillingCompletionDelayClass = () => {
    const delay = getBillingCompletionDelay()
    if (delay > 0) {
        return 'bg-orange-50 dark:bg-orange-950/20 border border-orange-200 dark:border-orange-800/30 text-orange-800 dark:text-orange-300'
    } else {
        return 'bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/30 text-emerald-800 dark:text-emerald-300'
    }
}

const getBillingCompletionDelayIcon = () => {
    const delay = getBillingCompletionDelay()
    return delay > 0 ? 'clock' : 'check-circle'
}

const getBillingCompletionDelayText = () => {
    const delay = getBillingCompletionDelay()
    const absDelay = Math.abs(delay)

    if (delay > 0) {
        return `Payé ${absDelay} jour${absDelay > 1 ? 's' : ''} après l'échéance`
    } else {
        return `Payé ${absDelay} jour${absDelay > 1 ? 's' : ''} avant l'échéance`
    }
}
</script>
