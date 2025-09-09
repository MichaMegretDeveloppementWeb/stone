<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Components
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import SettingsCard from '@/components/ui/SettingsCard.vue';
import { AlertTriangle, Trash2, Lock } from 'lucide-vue-next';

const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    password: '',
});

const deleteUser = (e: Event) => {
    e.preventDefault();

    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <SettingsCard 
        title="Zone de danger" 
        description="Suppression définitive de votre compte et de toutes vos données"
        danger
    >
        <!-- Warning Alert -->
        <div class="rounded-lg border border-destructive/30 bg-destructive/10 p-4 dark:border-destructive/20 dark:bg-destructive/5">
            <div class="flex items-start gap-3">
                <AlertTriangle class="h-5 w-5 text-destructive mt-0.5" />
                <div class="space-y-1">
                    <h4 class="text-sm font-semibold text-destructive">
                        Action irréversible
                    </h4>
                    <p class="text-sm text-destructive/80">
                        Cette action supprimera définitivement votre compte, tous vos clients, projets et événements. 
                        Aucune donnée ne pourra être récupérée après suppression.
                    </p>
                </div>
            </div>
        </div>

        <!-- Delete Action -->
        <div class="pt-2">
            <Dialog>
                <DialogTrigger as-child>
                    <Button variant="destructive" class="gap-2">
                        <Trash2 class="h-4 w-4" />
                        Supprimer mon compte
                    </Button>
                </DialogTrigger>
                <DialogContent class="sm:max-w-md">
                    <form method="POST" class="space-y-6" @submit="deleteUser">
                        <DialogHeader class="space-y-4">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-destructive/10">
                                <AlertTriangle class="h-6 w-6 text-destructive" />
                            </div>
                            <div class="text-center">
                                <DialogTitle class="text-lg font-semibold">
                                    Confirmer la suppression
                                </DialogTitle>
                                <DialogDescription class="mt-2 text-sm leading-relaxed">
                                    Cette action est définitive. Votre compte et toutes vos données seront 
                                    supprimées de façon permanente.
                                </DialogDescription>
                            </div>
                        </DialogHeader>

                        <div class="space-y-3">
                            <Label for="password" class="flex items-center gap-2 font-medium">
                                <Lock class="h-4 w-4" />
                                Confirmez avec votre mot de passe
                            </Label>
                            <Input 
                                id="password" 
                                type="password" 
                                name="password" 
                                ref="passwordInput" 
                                v-model="form.password" 
                                placeholder="Entrez votre mot de passe" 
                                class="h-11"
                            />
                            <InputError :message="form.errors.password" />
                        </div>

                        <DialogFooter class="gap-3 sm:gap-2">
                            <DialogClose as-child>
                                <Button variant="outline" @click="closeModal" class="min-w-24">
                                    Annuler
                                </Button>
                            </DialogClose>
                            <Button 
                                type="submit" 
                                variant="destructive" 
                                :disabled="form.processing"
                                class="min-w-32 gap-2"
                            >
                                <Trash2 v-if="!form.processing" class="h-4 w-4" />
                                {{ form.processing ? 'Suppression...' : 'Supprimer définitivement' }}
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
        </div>
    </SettingsCard>
</template>
