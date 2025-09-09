<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import stoneLogo from '../../../images/stone_logo.webp'

defineProps<{
    title?: string
    description?: string
}>()
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-muted/30 via-background to-background flex items-center justify-center p-4 relative overflow-hidden">
        <!-- Éléments premium subtils -->
        <div class="absolute inset-0">
            <!-- Grille sophistiquée -->
            <div class="absolute inset-0 opacity-[0.02]" style="background-image: linear-gradient(rgba(0,0,0,.05) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,.05) 1px, transparent 1px); background-size: 32px 32px;"></div>

            <!-- Gradient radial premium -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[600px] bg-gradient-radial from-slate-100/50 via-transparent to-transparent rounded-full"></div>

            <!-- Accent lumineux très subtil -->
            <div class="absolute top-1/4 right-1/3 w-2 h-32 bg-gradient-to-b from-primary/10 via-primary/5 to-transparent rounded-full blur-sm"></div>
            <div class="absolute bottom-1/3 left-1/4 w-2 h-24 bg-gradient-to-t from-muted-foreground/8 via-muted-foreground/4 to-transparent rounded-full blur-sm"></div>
        </div>

        <!-- Main content -->
        <div class="relative w-full max-w-md md:max-w-lg lg:max-w-xl">
            <!-- Card premium avec ombres sophistiquées -->
            <div class="bg-card/95 backdrop-blur-sm rounded-2xl shadow-[0_8px_40px_rgba(0,0,0,0.12)] dark:shadow-[0_8px_40px_rgba(0,0,0,0.3)] border border-border/50 ring-1 ring-border/5 overflow-hidden">

                <!-- Header section premium -->
                <div class="px-8 md:px-12 lg:px-16 pt-16 pb-12 relative">
                    <!-- Micro gradient subtil -->
                    <div class="absolute inset-0 bg-gradient-to-b from-card/50 to-transparent"></div>

                    <div class="text-center relative">
                        <!-- Logo premium -->
                        <div class="inline-flex items-center justify-center mb-8">
                            <a :href="route('home')" class="flex items-center gap-4">
                                <img
                                    :src="stoneLogo"
                                    alt="Stone Logo"
                                    class="relative w-12 h-12 rounded-lg"
                                />
                                <span class="text-3xl font-light text-foreground tracking-tight">Stone</span>
                            </a>
                        </div>

                        <!-- Title & Description premium -->
                        <div class="space-y-3 mb-2">
                            <h1 class="text-2xl font-medium text-foreground leading-tight tracking-tight">
                                {{ title }}
                            </h1>
                            <p v-if="description" class="text-muted-foreground text-sm leading-relaxed max-w-sm mx-auto">
                                {{ description }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Séparateur premium -->
                <div class="px-8 md:px-12 lg:px-16">
                    <div class="h-px bg-gradient-to-r from-transparent via-border/60 to-transparent"></div>
                </div>

                <!-- Form content premium -->
                <div class="px-8 md:px-12 lg:px-16 pt-12 pb-16 relative">
                    <slot />
                </div>
            </div>

            <!-- Footer info premium -->
            <div class="text-center mt-8">
                <p class="text-xs text-muted-foreground/60 font-light">
                    Sécurisé et chiffré • Conforme aux standards
                </p>
            </div>
        </div>
    </div>
</template>
