<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ActionMessage from "@/Components/ActionMessage.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm as usePrecognitionForm } from "laravel-precognition-vue-inertia";

const props = defineProps(["event", "registrations_number"]);

const formCreateRegistration = usePrecognitionForm("post", route("registrations.store", { event: props.event.id }), {
    name: "",
    phone: "",
    company_name: "",
    email: "",
    event_id: props.event.id, // on peut probablement enlever l'argument de la route et juste garder cette ligne pour identifier l'event
});

formCreateRegistration.setValidationTimeout(300);

const CreateRegistration = () => {
    formCreateRegistration.submit({
        preserveScroll: true,
        onSuccess: () => {
            formCreateRegistration.name = "";
            formCreateRegistration.email = "";
            formCreateRegistration.phone = "";
            formCreateRegistration.company_name = "";
        },
    });
};
</script>

<template>
    <GuestLayout :title="event.name">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ event.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 ">
                <div class="overflow-hidden bg-green-100 sm:p-6 sm:rounded-xl">
                    <div class="grid gap-6 py-6 md:grid-cols-3 sm:rounded-xl sm:px-6 lg:px-8">
                        <div class="space-y-4 md:col-span-2">
                            <img v-if="event.img_path" class="mx-auto sm:rounded-t-xl"
                                :src="'/storage/images/' + event.img_path" />
                            <img v-else class="mx-auto sm:rounded-t-xl" src="/storage/images/event_placeholder.jpg" />
                            <div class="max-w-4xl mx-auto space-y-4">
                                <h3 class="mb-2 text-xl">
                                    {{ event.name }}
                                </h3>
                                <div class="text-gray-600"> {{ event.description }}</div>
                                <div class="text-gray-600"> {{ event.body }}</div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <!--  <span v-if="registrations_limit">
                                    {{ registrations_number }} participant(s) inscrit(s) sur les {{
                                    event.registrations_limit }} places disponibles
                                </span>
                                <span v-else>
                                    {{ registrations_number }} participant(s) inscrit(s). Il n'y a pas de limite de
                                    participants.
                                </span> -->
                                <span v-if="event.registrations_sum === 1">{{ event.registrations_sum }} participant
                                    inscrit
                                </span>
                                <span v-else>{{ event.registrations_sum }} participants
                                    inscrits
                                </span>
                            </div>
                            <div class="">
                                <div class="flex flex-row items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="inline-block w-6 h-6 text-gray-600">
                                        <path
                                            d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                        <path fill-rule="evenodd"
                                            d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-600">Date</span>
                                </div>
                                <div v-if="event.start && event.end">
                                    <!-- {{ event.start.substring(0, 16) }} --> {{ event.start }}
                                    ->
                                    <!-- {{ event.end.substring(0, 16) }} --> {{ event.end }}
                                </div>
                                <div v-else>Date pas encore annoncée</div>
                            </div>
                            <div v-if="event.start && event.end" class="">
                                {{ event.start.substring(5, 7) }} <!-- {{ event.start }}  -->{{ event.month_start }}
                            </div>
                            <div class="">
                                <div class="flex flex-row items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="inline-block w-6 h-6 text-gray-600">
                                        <path fill-rule="evenodd"
                                            d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-600">Lieu</span>
                                </div>
                                <div>
                                    {{ event.place.contactable.name }}
                                </div>
                                <div class="text-sm">
                                    {{ event.place.country }}
                                    {{ event.place.city }}
                                    {{ event.place.street }}
                                </div>
                            </div>
                            <div class="">
                                <div class="flex flex-row items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="inline-block w-6 h-6 text-gray-600">
                                        <path
                                            d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                                        <path
                                            d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                                        <path
                                            d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                                    </svg>
                                    <span class="text-gray-600">Organisateur</span>

                                </div>
                                <div>
                                    {{ event.organizer.contactable.name }}
                                </div>
                                <!-- <div>
                                    {{ event.organizer.email }}
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <form @submit.prevent="CreateRegistration" class="max-w-2xl py-6 mx-auto space-y-4 sm:px-6 lg:px-8">
                        <h3 class="text-xl">Veuillez remplir ce formulaire afin d'être prévenu</h3>
                        <!-- <TextInput id="event_id" v-model="formCreateRegistration.event_id" type="hidden"
                            @input="formCreateRegistration.validate('event_id')" /> -->
                        <!-- name -->
                        <div class="">
                            <InputLabel for="name" value="Votre nom*" />
                            <TextInput id="name" v-model="formCreateRegistration.name" type="text"
                                class="block w-full mt-1" @input="formCreateRegistration.validate('name')" />
                            <InputError :message="formCreateRegistration.errors.name" class="mt-2" />
                        </div>
                        <!-- email -->
                        <div class="">
                            <InputLabel for="email" value="Votre adresse email*" />
                            <TextInput id="email" v-model="formCreateRegistration.email" type="text"
                                class="block w-full mt-1" @input="formCreateRegistration.validate('email')" />
                            <InputError :message="formCreateRegistration.errors.email" class="mt-2" />
                        </div>
                        <!-- phone -->
                        <div class="">
                            <InputLabel for="phone" value="Numéro de téléphone" />
                            <TextInput id="phone" v-model="formCreateRegistration.phone" type="text"
                                class="block w-full mt-1" @input="formCreateRegistration.validate('phone')" />
                            <InputError :message="formCreateRegistration.errors.phone" class="mt-2" />
                        </div>
                        <!-- company_name -->
                        <div class="">
                            <InputLabel for="company_name" value="Nom de la société" />
                            <TextInput id="company_name" v-model="formCreateRegistration.company_name" type="text"
                                class="block w-full mt-1" @input="formCreateRegistration.validate('company_name')" />
                            <InputError :message="formCreateRegistration.errors.company_name" class="mt-2" />
                        </div>

                        <div class="flex justify-center">
                            <ActionMessage :on="formCreateRegistration.recentlySuccessful" class="me-3">
                                Envoyée avec succès.
                            </ActionMessage>

                            <PrimaryButton :class="{ 'opacity-25': formCreateRegistration.processing }"
                                :disabled="formCreateRegistration.processing" class="mx-auto">
                                Envoyer
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
