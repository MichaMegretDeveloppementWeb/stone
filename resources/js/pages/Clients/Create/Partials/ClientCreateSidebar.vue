<template>
    <div class="space-y-6">
        <!-- Message d'erreur dans la sidebar -->
        <template v-if="hasError">
            <Card class="border-0 bg-destructive/10 shadow-sm p-6">
                <CardHeader class="pb-4">
                    <CardTitle class="flex items-center gap-2 text-destructive">
                        <Icon name="alert-circle" class="h-5 w-5" />
                        Problème de connexion
                    </CardTitle>
                </CardHeader>
                <CardContent class="space-y-4 text-sm text-destructive/80 p-0">
                    <p>Une erreur s'est produite lors du chargement des données.</p>
                    <div class="flex items-center gap-2">
                        <Icon name="wifi-off" class="h-4 w-4" />
                        <span>Vérifiez votre connexion</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <Icon name="refresh-cw" class="h-4 w-4" />
                        <span>Rechargez la page si nécessaire</span>
                    </div>
                </CardContent>
            </Card>
        </template>

        <!-- Skeleton loading -->
        <template v-else-if="isLoading">
            <!-- Skeleton Conseils -->
            <Card class="border-0 bg-muted shadow-sm p-6 animate-pulse">
                <CardHeader class="pb-4">
                    <div class="flex items-center gap-2">
                        <div class="h-5 w-5 bg-muted rounded"></div>
                        <div class="h-5 w-16 bg-muted rounded"></div>
                    </div>
                </CardHeader>
                <CardContent class="space-y-4 p-0">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 h-4 w-4 bg-muted rounded"></div>
                        <div class="h-4 w-full bg-muted rounded"></div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 h-4 w-4 bg-muted rounded"></div>
                        <div class="h-4 w-3/4 bg-muted rounded"></div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 h-4 w-4 bg-muted rounded"></div>
                        <div class="h-4 w-5/6 bg-muted rounded"></div>
                    </div>
                </CardContent>
            </Card>


            <!-- Skeleton Prochaines étapes -->
            <Card class="border-0 bg-muted shadow-sm p-6 animate-pulse">
                <CardHeader class="pb-4">
                    <div class="flex items-center gap-2">
                        <div class="h-5 w-5 bg-muted rounded"></div>
                        <div class="h-5 w-32 bg-muted rounded"></div>
                    </div>
                </CardHeader>
                <CardContent class="space-y-3 p-0">
                    <div class="flex items-center gap-3 rounded-lg bg-muted p-3">
                        <div class="h-6 w-6 bg-muted rounded-full"></div>
                        <div class="h-4 w-24 bg-muted rounded"></div>
                    </div>
                    <div class="flex items-center gap-3 rounded-lg bg-muted p-3">
                        <div class="h-6 w-6 bg-muted rounded-full"></div>
                        <div class="h-4 w-32 bg-muted rounded"></div>
                    </div>
                    <div class="flex items-center gap-3 rounded-lg bg-muted p-3">
                        <div class="h-6 w-6 bg-muted rounded-full"></div>
                        <div class="h-4 w-28 bg-muted rounded"></div>
                    </div>
                </CardContent>
            </Card>
        </template>

        <!-- Contenu normal -->
        <template v-else>
            <!-- Conseils -->
            <Card class="border-0 bg-gradient-to-br from-emerald-50 to-emerald-100 shadow-sm p-6">
                <CardHeader class="pb-4 pl-0 pr-0">
                    <CardTitle class="flex items-center gap-2 text-emerald-900">
                        <Icon name="lightbulb" class="h-5 w-5" />
                        Conseils
                    </CardTitle>
                </CardHeader>
                <CardContent class="space-y-4 text-sm text-emerald-800 p-0">
                    <div class="flex items-start gap-3">
                        <Icon name="check-circle" class="mt-0.5 h-4 w-4 text-emerald-600" />
                        <p>Seul le nom du client est obligatoire.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <Icon name="check-circle" class="mt-0.5 h-4 w-4 text-emerald-600" />
                        <p>L'email doit être unique.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <Icon name="check-circle" class="mt-0.5 h-4 w-4 text-emerald-600" />
                        <p>Les notes aident à retenir des détails importants.</p>
                    </div>
                </CardContent>
            </Card>


            <!-- Prochaines étapes -->
            <Card class="border-0 bg-card shadow-sm p-6">
                <CardHeader class="pb-4 pl-0 pr-0">
                    <CardTitle class="flex items-center gap-2 text-foreground">
                        <Icon name="list-checks" class="h-5 w-5" />
                        Prochaines étapes
                    </CardTitle>
                </CardHeader>
                <CardContent class="space-y-3 text-sm p-0">
                    <div class="flex items-center gap-3 rounded-lg bg-muted/50 p-3">
                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 text-xs font-medium text-emerald-600">
                            1
                        </div>
                        <span>Créer le client</span>
                    </div>
                    <div class="flex items-center gap-3 rounded-lg bg-muted/50 p-3 opacity-60">
                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-muted text-xs font-medium text-muted-foreground">
                            2
                        </div>
                        <span>Créer le premier projet</span>
                    </div>
                    <div class="flex items-center gap-3 rounded-lg bg-muted/50 p-3 opacity-60">
                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-muted text-xs font-medium text-muted-foreground">
                            3
                        </div>
                        <span>Gérer les événements</span>
                    </div>
                </CardContent>
            </Card>
        </template>
    </div>
</template>

<script setup lang="ts">
import Icon from '@/components/Icon.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'

interface ClientCreateSidebarProps {
    isLoading: boolean
    hasError: boolean
}

defineProps<ClientCreateSidebarProps>()
</script>
