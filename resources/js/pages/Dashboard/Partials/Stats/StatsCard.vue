<template>
    <component
        :is="href ? Link : 'div'"
        :href="href"
        :class="linkClasses"
    >
        <Card
            class="h-full rounded-xl border border-border bg-card shadow-sm transition-all duration-300"
            :class="cardClasses"
        >
            <CardContent class="flex h-full flex-col p-4 sm:p-6">
                <div class="flex flex-1 items-start justify-between">
                    <div class="flex h-full flex-1 flex-col justify-start">
                        <!-- Header avec icône -->
                        <div class="mb-3 flex items-center gap-2">
                            <div
                                class="rounded-lg p-2"
                                :class="iconBgClasses"
                            >
                                <OptimizedIcon
                                    :name="icon"
                                    :size="16"
                                    :class="iconColorClasses"
                                    preload
                                />
                            </div>
                            <span class="text-sm font-medium text-muted-foreground">
                                {{ title }}
                            </span>
                        </div>

                        <!-- Valeur principale -->
                        <div class="space-y-1">
                            <div class="text-2xl font-bold text-foreground">
                                {{ formattedValue }}
                            </div>

                            <!-- Croissance/métrique additionnelle -->
                            <div v-if="hasGrowth" class="mt-2 flex items-center gap-1.5">
                                <div class="flex items-center gap-1">
                                    <div
                                        class="h-1 w-1 rounded-full"
                                        :class="growthDotColor"
                                    ></div>
                                    <span
                                        class="text-xs font-medium"
                                        :class="growthTextColor"
                                    >
                                        {{ growthPrefix }}{{ growth }}
                                    </span>
                                </div>
                                <span class="text-xs text-muted-foreground">
                                    {{ growthLabel }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </CardContent>
        </Card>
    </component>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Card, CardContent } from '@/components/ui/card';
import OptimizedIcon from '@/components/OptimizedIcon.vue';

// Types de couleur
type Color = 'blue' | 'emerald' | 'purple' | 'orange' | 'red' | 'yellow';

// Props
interface Props {
    title: string;
    value: number | string;
    icon: string;
    color?: Color;
    growth?: number;
    growthLabel?: string;
    href?: string;
    formatAsNumber?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    color: 'blue',
    formatAsNumber: true
});

// Classes de couleur
const colorConfig = {
    blue: {
        iconBg: 'bg-blue-50 dark:bg-blue-950/50',
        iconColor: 'text-blue-600 dark:text-blue-400',
        hover: 'group-hover:border-blue-200 dark:group-hover:border-blue-800',
        navIcon: 'group-hover:text-blue-500 dark:group-hover:text-blue-400'
    },
    emerald: {
        iconBg: 'bg-emerald-50 dark:bg-emerald-950/50',
        iconColor: 'text-emerald-600 dark:text-emerald-400',
        hover: 'group-hover:border-emerald-200 dark:group-hover:border-emerald-800',
        navIcon: 'group-hover:text-emerald-500 dark:group-hover:text-emerald-400'
    },
    purple: {
        iconBg: 'bg-purple-50 dark:bg-purple-950/50',
        iconColor: 'text-purple-600 dark:text-purple-400',
        hover: 'group-hover:border-purple-200 dark:group-hover:border-purple-800',
        navIcon: 'group-hover:text-purple-500 dark:group-hover:text-purple-400'
    },
    orange: {
        iconBg: 'bg-orange-50 dark:bg-orange-950/50',
        iconColor: 'text-orange-600 dark:text-orange-400',
        hover: 'group-hover:border-orange-200 dark:group-hover:border-orange-800',
        navIcon: 'group-hover:text-orange-500 dark:group-hover:text-orange-400'
    },
    red: {
        iconBg: 'bg-red-50 dark:bg-red-950/50',
        iconColor: 'text-red-600 dark:text-red-400',
        hover: 'group-hover:border-red-200 dark:group-hover:border-red-800',
        navIcon: 'group-hover:text-red-500 dark:group-hover:text-red-400'
    },
    yellow: {
        iconBg: 'bg-yellow-50 dark:bg-yellow-950/50',
        iconColor: 'text-yellow-600 dark:text-yellow-400',
        hover: 'group-hover:border-yellow-200 dark:group-hover:border-yellow-800',
        navIcon: 'group-hover:text-yellow-500 dark:group-hover:text-yellow-400'
    }
};

// Computed properties
const config = computed(() => colorConfig[props.color] || colorConfig.blue);

const linkClasses = computed(() => {
    return props.href ? 'group h-full' : 'h-full';
});

const cardClasses = computed(() => {
    return props.href
        ? `group-hover:-translate-y-0.5 group-hover:shadow-md ${config.value.hover}`
        : '';
});

const iconBgClasses = computed(() => config.value.iconBg);
const iconColorClasses = computed(() => config.value.iconColor);
// const navIconClasses = computed(() => config.value.navIcon); // Réservé pour futurs éléments de navigation

const formattedValue = computed(() => {
    if (typeof props.value === 'string') {
        return props.value;
    }

    // Vérifier si la valeur est valide
    if (props.value === undefined || props.value === null || isNaN(Number(props.value))) {
        return '0';
    }

    if (props.formatAsNumber) {
        return new Intl.NumberFormat('fr-FR').format(props.value);
    }

    return props.value.toString();
});

const hasGrowth = computed(() => {
    return typeof props.growth === 'number' && props.growthLabel;
});

const growthPrefix = computed(() => {
    if (typeof props.growth !== 'number') return '';
    return props.growth >= 0 ? '+' : '';
});

const growthTextColor = computed(() => {
    if (typeof props.growth !== 'number') return 'text-muted-foreground';

    if (props.growth > 0) return 'text-emerald-600 dark:text-emerald-400';
    if (props.growth < 0) return 'text-red-600 dark:text-red-400';
    return 'text-muted-foreground';
});

const growthDotColor = computed(() => {
    if (typeof props.growth !== 'number') return 'bg-muted-foreground';

    if (props.growth > 0) return 'bg-emerald-500';
    if (props.growth < 0) return 'bg-red-500';
    return 'bg-muted-foreground';
});
</script>

<style scoped>
.stats-card {
    contain: layout style paint;
}
</style>
