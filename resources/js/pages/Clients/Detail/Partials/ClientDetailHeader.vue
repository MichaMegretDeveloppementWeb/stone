<template>
    <div class="border-b border-border pb-8">
        <!-- Breadcrumb style header -->
        <div class="mb-6 flex items-center gap-3 text-sm">
            <Link :href="route('dashboard')" class="flex items-center gap-2 text-muted-foreground hover:text-foreground transition-colors">
                <Icon name="home" class="h-4 w-4" />
                <span>Tableau de bord</span>
            </Link>
            <div class="h-4 w-px bg-muted"></div>
            <Link :href="route('clients.index')" class="text-muted-foreground transition-colors hover:text-foreground">Clients</Link>
        </div>

        <!-- Main header content -->
        <div class="flex items-start gap-4">
            <div class="rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 p-3 shadow-sm">
                <Icon name="user" class="h-6 w-6 text-white" />
            </div>
            <div class="flex-1 min-w-0">
                <div v-if="isLoading" class="animate-pulse">
                    <div class="h-8 w-48 bg-muted rounded mb-2"></div>
                    <div class="h-4 w-32 bg-muted rounded"></div>
                </div>
                <div v-else>
                    <h1 class="text-2xl font-bold text-foreground mb-1">{{ client?.name }}</h1>
                    <p v-if="client?.company" class="text-sm text-muted-foreground mb-2">{{ client.company }}</p>
                    <p class="text-sm text-muted-foreground">Détails du client et gestion de ses projets</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import Icon from '@/components/Icon.vue'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import type { ClientDetailHeaderProps } from '@/types/clients/detail/index'

defineProps<ClientDetailHeaderProps>()
</script>