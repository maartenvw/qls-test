<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <v-app>
        <v-main>
            <v-container fluid class="h-100">
               <v-row align="center" justify="center" class="h-100">
                    <v-responsive class="flex-1-1 px-4" max-width="475px">
                        <div class="text-h3 text-center mb-8 font-weight-bold text-primary">QLS</div>
                        <div class="text-h5 text-center mb-8 font-weight-medium">Log into your account</div>
                        <v-card
                            density="default"
                            elevation="3"
                            rounded="lg"
                            variant="elevated"
                            class="pa-10 mb-8"
                        >
                            <v-card-text>
                                <v-form @submit.prevent="submit">
                                    <v-label class="text-subtitle-2">
                                        E-Mail
                                    </v-label>
                                    <v-text-field
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        variant="outlined"
                                        density="compact"
                                        rounded="lg"
                                        required
                                        autofocus
                                        autocomplete="username"
                                        :error-messages="form.errors.email"
                                    ></v-text-field>
                                    <v-label class="text-subtitle-2">
                                        Wachtwoord
                                    </v-label>
                                    <v-text-field
                                        id="password"
                                        v-model="form.password"
                                        type="password"
                                        class="mt-1 block w-full"
                                        variant="outlined"
                                        density="compact"
                                        rounded="lg"
                                        required
                                        autocomplete="current-password"
                                        :error-messages="form.errors.password"
                                    ></v-text-field>
                                    <div class="mb-4">
                                        <v-checkbox
                                            v-model="form.remember"
                                            label="Remember me"
                                        ></v-checkbox>
                                    </div>
                                    <v-btn
                                        color="secondary"
                                        block
                                        rounded="lg"
                                        variant="elevated"
                                        :loading="form.processing"
                                        @click="submit"
                                        class="text-none"
                                    >Login</v-btn>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-responsive>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
