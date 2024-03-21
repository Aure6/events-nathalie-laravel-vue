<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import ActionMessage from "@/Components/ActionMessage.vue";
import DangerButton from "@/Components/DangerButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm as usePrecognitionForm } from "laravel-precognition-vue-inertia";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps(["events"]);

const formCreateEvent = usePrecognitionForm("post", route("admin.events.store"), {
    organizer_id: "",
    name: "",
    description: "",
    address: "",
    start: "",
    end: "",
    body: "",
});

formCreateEvent.setValidationTimeout(300);

const CreateEvent = () => {
    formCreateEvent.submit({
        preserveScroll: true,
        onSuccess: () => form.reset(),
        // onSuccess: () => {
        //     // On vide le champ après avoir créé la tâche
        //     formCreateEvent.name = "";
        // },
    });
};
</script>

<template>
    <AppLayout title="Événements">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Événements
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- <Link :href="route('events.create')" class="p-6 transition bg-green-100 rounded-lg hover:bg-green-200">
                Nouveau
                </Link> -->
                <FormSection @submitted="CreateEvent">
                    <template #title>Nouvelle événement</template>

                    <template #description>
                        Ajouter un nouvel événement
                    </template>

                    <template #form>
                        <!-- Name -->
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Nom de l'événement" />
                            <TextInput id="name" v-model="formCreateEvent.name" type="text" class="block w-full mt-1"
                                @input="formCreateEvent.validate('name')" />
                            <InputError :message="formCreateEvent.errors.name" class="mt-2" />
                        </div>
                        <!-- description -->
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="description"
                                value="Brève description de l'événement affiché dans la liste" />
                            <TextInput id="description" v-model="formCreateEvent.description" type="text"
                                class="block w-full mt-1" @input="formCreateEvent.validate('description')" />
                            <InputError :message="formCreateEvent.errors.description" class="mt-2" />
                        </div>
                        <!-- address -->
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="address" value="Adresse de l'événement" />
                            <TextInput id="address" v-model="formCreateEvent.address" type="text"
                                class="block w-full mt-1" @input="formCreateEvent.validate('address')" />
                            <InputError :message="formCreateEvent.errors.address" class="mt-2" />
                        </div>
                        <!-- start -->
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="start" value="Début de l'événement" />
                            <TextInput id="start" v-model="formCreateEvent.start" type="datetime-local"
                                class="block w-full mt-1" @input="formCreateEvent.validate('start')" />
                            <InputError :message="formCreateEvent.errors.start" class="mt-2" />
                        </div>
                        <!-- end -->
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="end" value="Fin de l'événement" />
                            <TextInput id="end" v-model="formCreateEvent.end" type="datetime-local"
                                class="block w-full mt-1" @input="formCreateEvent.validate('end')" />
                            <InputError :message="formCreateEvent.errors.end" class="mt-2" />
                        </div>
                        <!-- organizer_id -->
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="organizer_id" value="Organisateur de l'événement" />
                            <select id="organizer_id" v-model="formCreateEvent.organizer_id" class="block w-full mt-1"
                                @input="formCreateEvent.validate('organizer_id')">
                                <option value="Chien">Chien</option>
                                <option value="chat">Chat</option>
                            </select>
                            <InputError :message="formCreateEvent.errors.organizer_id" class="mt-2" />
                        </div>
                        <!-- body -->
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="body" value="Corps de la page de l'événement" />
                            <TextInput id="body" v-model="formCreateEvent.body" type="textarea" rows="5"
                                class="block w-full mt-1" @input="formCreateEvent.validate('body')" />
                            <InputError :message="formCreateEvent.errors.body" class="mt-2" />
                        </div>
                    </template>

                    <template #actions class="flex justify-center">
                        <ActionMessage :on="formCreateEvent.recentlySuccessful" class="me-3">
                            Sauvegardé.
                        </ActionMessage>

                        <PrimaryButton :class="{ 'opacity-25': formCreateEvent.processing }"
                            :disabled="formCreateEvent.processing" class="mx-auto">
                            Sauvegarder
                        </PrimaryButton>
                    </template>
                </FormSection>
                <div class="p-6 overflow-hidden sm:rounded-lg">
                    <SectionTitle>
                        <template #title> Évènements </template>
                        <!-- <template #description>
                            Marquez vos tâches comme terminées ou supprimez-les.
                        </template> -->
                    </SectionTitle>
                    <ul class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
                        <!-- <Link v-for="event in events" :key="event.id" :href="route('events.show', event.id)"
                            class="p-4 duration-150 bg-green-100 rounded-xl hover:scale-105"> -->
                        <Link :href="route('events.show', { id: event.id })" v-for="event in events" :key="event.id"
                            class="p-6 transition bg-green-100 rounded-lg hover:bg-green-200">
                        <h3 class="mb-2 text-xl">
                            {{ event.name }}
                        </h3>
                        <div class="mb-2 text-gray-600"> {{ event.description }}</div>
                        <div class="mb-2"> {{ event.start.substring(5, 7) }} {{ event.month_start }}</div>
                        <!-- <div class="text-gray-600"> {{ event.start.substring(0, 16) }} -> {{ event.end.substring(0,
                                16) }}</div> -->
                        <div class="text-sm text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor" class="inline w-5 h-5 text-gray-600">
                                <path fill-rule="evenodd"
                                    d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                    clip-rule="evenodd" />
                            </svg>{{ event.address }}
                        </div>
                        </Link>
                        <!-- </Link> -->
                    </ul>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
