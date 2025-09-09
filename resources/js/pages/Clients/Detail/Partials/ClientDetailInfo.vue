<template>
    <Card class="border border-border bg-card shadow-sm">
        <CardHeader class="pb-4">
            <CardTitle class="flex items-center gap-2 text-foreground">
                <Icon name="user" class="h-5 w-5 text-muted-foreground" />
                Informations client
            </CardTitle>
        </CardHeader>
        <CardContent class="space-y-8">
            <div v-if="isLoading" class="animate-pulse">
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="space-y-2">
                        <div class="h-4 w-20 bg-muted rounded"></div>
                        <div class="h-5 w-32 bg-muted rounded"></div>
                    </div>
                    <div class="space-y-2">
                        <div class="h-4 w-16 bg-muted rounded"></div>
                        <div class="h-5 w-40 bg-muted rounded"></div>
                    </div>
                    <div class="space-y-2">
                        <div class="h-4 w-24 bg-muted rounded"></div>
                        <div class="h-5 w-28 bg-muted rounded"></div>
                    </div>
                </div>
            </div>
            <div v-else-if="client">
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div v-if="client.company" class="space-y-2">
                        <label class="flex items-center gap-1.5 text-sm font-medium text-muted-foreground">
                            <Icon name="building" class="h-4 w-4 text-muted-foreground/70" />
                            Entreprise
                        </label>
                        <p class="font-medium text-foreground">{{ client.company }}</p>
                    </div>
                    <div v-if="client.email" class="space-y-2">
                        <label class="flex items-center gap-1.5 text-sm font-medium text-muted-foreground">
                            <Icon name="mail" class="h-4 w-4 text-muted-foreground/70" />
                            Email
                        </label>
                        <p class="font-medium text-foreground">{{ client.email }}</p>
                    </div>
                    <div v-if="client.phone" class="space-y-2">
                        <label class="flex items-center gap-1.5 text-sm font-medium text-muted-foreground">
                            <Icon name="phone" class="h-4 w-4 text-muted-foreground/70" />
                            Téléphone
                        </label>
                        <p class="font-medium text-foreground">{{ client.phone }}</p>
                    </div>
                </div>
                <div v-if="client.address" class="space-y-2 mt-8">
                    <label class="flex items-center gap-1.5 text-sm font-medium text-muted-foreground">
                        <Icon name="map-pin" class="h-4 w-4 text-muted-foreground/70" />
                        Adresse
                    </label>
                    <p class="rounded-lg border border-border bg-muted/50 p-3 text-sm leading-relaxed whitespace-pre-line">
                        {{ client.address }}
                    </p>
                </div>
                <div v-if="client.notes" class="space-y-2 mt-8">
                    <label class="flex items-center gap-1.5 text-sm font-medium text-muted-foreground">
                        <Icon name="sticky-note" class="h-4 w-4 text-muted-foreground/70" />
                        Notes
                    </label>
                    <p class="rounded-lg border border-border bg-muted/50 p-3 text-sm leading-relaxed whitespace-pre-line">
                        {{ client.notes }}
                    </p>
                </div>
            </div>
        </CardContent>
    </Card>
</template>

<script setup lang="ts">
import Icon from '@/components/Icon.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import type { ClientDetailInfoProps } from '@/types/clients/detail/index'

defineProps<ClientDetailInfoProps>()
</script>