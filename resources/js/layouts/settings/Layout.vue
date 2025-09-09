<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { User, Settings, Lock, Palette } from 'lucide-vue-next';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Profil',
        href: '/settings/profile',
        icon: User,
        description: 'Informations personnelles',
    },
    {
        title: 'Mot de passe',
        href: '/settings/password',
        icon: Lock,
        description: 'Sécurité du compte',
    },
    {
        title: 'Apparence',
        href: '/settings/appearance',
        icon: Palette,
        description: 'Thèmes et préférences',
    },
];

const page = usePage();

const currentPath = page.props.ziggy?.location ? new URL(page.props.ziggy.location).pathname : '';
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100/50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950/50">
        <div class="container mx-auto max-w-7xl px-4 py-8">
            <!-- Header Section -->
            <div class="mb-8 text-center lg:text-left">
                <div class="inline-flex items-center gap-3 rounded-full bg-primary/10 px-4 py-2 mb-4">
                    <Settings class="h-5 w-5 text-primary" />
                    <span class="text-sm font-medium text-primary">Paramètres</span>
                </div>
                <Heading title="Gérez votre compte" description="Personnalisez votre profil, sécurité et préférences d'apparence" />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Navigation Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="sticky top-8">
                        <div class="rounded-xl shadow-md bg-card backdrop-blur-sm p-2">
                            <nav class="space-y-1">
                                <template v-for="item in sidebarNavItems" :key="item.href">
                                    <Link :href="item.href" class="block">
                                        <div
                                            class="group relative rounded-lg p-3 transition-all duration-200 hover:bg-accent/50"
                                            :class="currentPath === item.href ? 'bg-primary/10 text-primary border border-primary/20' : 'hover:text-foreground'"
                                        >
                                            <!-- Active indicator -->
                                            <div
                                                v-if="currentPath === item.href"
                                                class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-primary rounded-r-full"
                                            />

                                            <div class="flex items-center gap-3">
                                                <component
                                                    :is="item.icon"
                                                    class="h-5 w-5 transition-colors"
                                                    :class="currentPath === item.href ? 'text-primary' : 'text-muted-foreground group-hover:text-foreground'"
                                                />
                                                <div class="flex-1">
                                                    <div class="font-medium text-sm text-foreground group-hover:text-foreground" :class="currentPath === item.href ? 'text-primary' : ''">{{ item.title }}</div>
                                                    <div
                                                        class="text-xs text-muted-foreground mt-0.5"
                                                        :class="currentPath === item.href ? 'text-primary/70' : ''"
                                                    >
                                                        {{ item.description }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </Link>
                                </template>
                            </nav>
                        </div>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="lg:col-span-3">
                    <div class="space-y-6">
                        <slot />
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>
