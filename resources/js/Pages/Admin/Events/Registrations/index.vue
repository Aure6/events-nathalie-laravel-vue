<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import ActionMessage from "@/Components/ActionMessage.vue";
import DangerButton from "@/Components/DangerButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryLink from "@/Components/PrimaryLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm as usePrecognitionForm } from "laravel-precognition-vue-inertia";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps(["registrations", "event"]);
</script>

<template>
    <AppLayout title="Inscriptions">
        <template #header>
            <!-- <PrimaryButton @click="confirmCreateEvent" type="button">
                Nouveau
            </PrimaryButton> -->
            {{ event.name }}
            <h2 class="inline-block ml-4 text-lg font-semibold leading-tight text-gray-800 ">
                Inscriptions
            </h2>
        </template>

        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <!-- TODO data table from PrimeVue? -->
                <table class="w-full">
                    <!-- <Link :href="route('admin.events.edit', { id: event.id })" v-for="event in events"
                            :key="event.id" class="grid grid-cols-3 bg-white border hover:border-sky-900">
                        </Link> -->
                    <tr v-for="registration in registrations" :key="registration.id"
                        class="bg-white border hover:border-sky-900">
                        <td>{{ registration.created_at }}</td>
                        <td>{{ registration.first_name }} {{ registration.last_name }}</td>
                        <td>{{ registration.email }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
