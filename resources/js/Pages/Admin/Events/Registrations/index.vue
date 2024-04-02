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
import { computed, ref } from "vue";

const props = defineProps(["registrations", "event"]);

// console.log(props.registrations);
const formDeleteRegistration = useForm("delete", {});
const deleteRegistration = (registrationId) => {
    formDeleteRegistration.delete(route("registrations.destroy", registrationId), {
        preserveScroll: true,
        onSuccess: () => {
            confirmingTaskDeletion.value = false;
        },
    });
};
console.log(props.registrations.length);
const IsRegistrationEmpty = computed(() => {
    return props.registrations.length === 0 ? true : false;
});
</script>

<template>
    <AppLayout title="Inscriptions">
        <template #header>
            <!-- <PrimaryButton @click="confirmCreateEvent" type="button">
                Nouveau
            </PrimaryButton> -->
            <Link :href="route('admin.events.index')"
                class="inline-block ml-4 text-lg font-semibold leading-tight text-sky-800">
            Événements
            </Link>
            >
            <Link :href="route('admin.events.edit', { id: event.id })"
                class="inline-block text-lg font-semibold leading-tight text-sky-800">
            {{ event.name }}
            </Link>
            >
            <h2 class="inline-block text-lg font-semibold leading-tight text-gray-800 ">
                Inscriptions
            </h2>
        </template>

        <div class="border-t-2">
            <div class="mx-auto">
                <!-- TODO data table from PrimeVue? -->
                <table class="w-full bg-white">
                    <!-- <Link :href="route('admin.events.edit', { id: event.id })" v-for="event in events"
                            :key="event.id" class="grid grid-cols-3 bg-white border hover:border-sky-900">
                        </Link> -->
                    <thead>
                        <tr>
                            <th scope="col">Date d'inscription</th>
                            <th scope="col">Nom du participant</th>
                            <th scope="col">Email</th>
                            <th scope="col">Téléphone</th>
                            <!-- <th scope="col">Ticket d'évènement</th> -->
                            <!-- <th scope="col">Activités</th> -->
                            <!-- <th scope="col">Statut</th> -->
                            <!-- <th scope="col">Statut de la vente</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <div v-if="IsRegistrationEmpty">Aucune inscription trouvée.</div>
                        <tr v-for="registration in registrations" :key="registration.id"
                            class="border hover:bg-sky-200">
                            <td>{{ registration.date }}</td>
                            <td>{{ registration.name }}</td>
                            <td>{{ registration.email }}</td>
                            <td>{{ registration.phone }}</td>
                            <td class="text-red-500"><button
                                    class="transition-all rounded hover:ring-red-500 hover:ring-2 hover:text-white hover:bg-red-500"
                                    @click="deleteRegistration(registration.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="inline-block w-6 h-6">
                                        <path fill-rule="evenodd"
                                            d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Annuler</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
