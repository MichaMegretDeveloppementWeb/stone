<script setup lang="ts">
interface Props {
    title: string;
    description?: string;
    danger?: boolean;
}

defineProps<Props>();
</script>

<template>
    <div 
        class="relative overflow-hidden rounded-xl border bg-card backdrop-blur-sm transition-all duration-200 hover:shadow-md"
        :class="danger ? 'border-destructive/20 bg-destructive/5 dark:border-destructive/30 dark:bg-destructive/10' : 'border-border'"
    >
        <!-- Header gradient -->
        <div 
            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-border to-transparent"
            :class="danger ? 'via-destructive/30' : ''"
        />
        
        <div class="space-y-6 p-6">
            <!-- Title Section -->
            <div class="space-y-1">
                <h3 class="text-lg font-semibold tracking-tight text-foreground">
                    {{ title }}
                </h3>
                <p v-if="description" class="text-sm text-muted-foreground leading-relaxed">
                    {{ description }}
                </p>
            </div>

            <!-- Content Slot -->
            <div class="space-y-4">
                <slot />
            </div>
        </div>

        <!-- Bottom accent -->
        <div 
            class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-border/30 to-transparent"
            :class="danger ? 'via-destructive/20' : ''"
        />
    </div>
</template>