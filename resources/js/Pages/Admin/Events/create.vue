<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import ActionMessage from "@/Components/ActionMessage.vue";
import DangerButton from "@/Components/DangerButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryLink from "@/Components/PrimaryLink.vue";
import SecondaryLink from "@/Components/SecondaryLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm as usePrecognitionForm } from "laravel-precognition-vue-inertia";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps(["organizers"]);

const formCreateEvent = usePrecognitionForm("post", route("admin.events.store"), {
    organizer_id: "",
    name: "",
    description: "",
    place: "",
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
            <SecondaryLink :href="route('admin.events.create')">
                Nouveau
            </SecondaryLink>
            <h2 class="inline-block ml-4 text-xl font-semibold leading-tight text-gray-800">
                Événements
            </h2>
        </template>

        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <form @submit.prevent="CreateEvent">

                    <div class="flex justify-center">
                        <ActionMessage :on="formCreateEvent.recentlySuccessful" class="me-3">
                            Sauvegardé.
                        </ActionMessage>

                        <PrimaryButton :class="{ 'opacity-25': formCreateEvent.processing }"
                            :disabled="formCreateEvent.processing" class="mx-auto">
                            Sauvegarder
                        </PrimaryButton>
                    </div>
                    <!-- Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="name" value="Nom de l'événement" />
                        <TextInput id="name" v-model="formCreateEvent.name" type="text"
                            class="block w-full mt-1 text-lg" @input="formCreateEvent.validate('name')" />
                        <InputError :message="formCreateEvent.errors.name" class="mt-2" />
                    </div>
                    <div class="grid grid-cols-2">
                        <!-- start -->
                        <div class="">
                            <InputLabel for=" start" value="Début" />
                            <TextInput id="start" v-model="formCreateEvent.start" type="datetime-local"
                                class="block w-full mt-1" @input="formCreateEvent.validate('start')" />
                            <InputError :message="formCreateEvent.errors.start" class="mt-2" />
                        </div>
                        <!-- end -->
                        <div class="">
                            <InputLabel for="end" value="Fin" />
                            <TextInput id="end" v-model="formCreateEvent.end" type="datetime-local"
                                class="block w-full mt-1" @input="formCreateEvent.validate('end')" />
                            <InputError :message="formCreateEvent.errors.end" class="mt-2" />
                        </div>
                        <!-- place -->
                        <div class="">
                            <InputLabel for="place" value="Lieu" />
                            <TextInput id="place" v-model="formCreateEvent.place" type="text" class="block w-full mt-1"
                                @input="formCreateEvent.validate('place')" />
                            <InputError :message="formCreateEvent.errors.place" class="mt-2" />
                        </div>
                        <!-- organizer_id -->
                        <div class="">
                            <InputLabel for="organizer_id" value="Organisateur de l'événement" />
                            <select id="organizer_id" v-model="formCreateEvent.organizer_id" class="block w-full mt-1"
                                @input="formCreateEvent.validate('organizer_id')">
                                <option v-for="organizer in organizers" :key="organizer.id" value="organizer.id">
                                    {{ organizer.first_name }}
                                </option>
                            </select>
                            <InputError :message="formCreateEvent.errors.organizer_id" class="mt-2" />
                        </div>
                    </div>
                    <!-- description -->
                    <div class="">
                        <InputLabel for="description" value="Brève description affiché dans la liste des évènements" />
                        <TextInput id="description" v-model="formCreateEvent.description" type="text"
                            class="block w-full mt-1" @input="formCreateEvent.validate('description')" />
                        <InputError :message="formCreateEvent.errors.description" class="mt-2" />
                    </div>
                    <!-- body -->
                    <div class="">
                        <InputLabel for="body" value="Corps de texte de la page de l'événement" />
                        <textarea id="body" v-model="formCreateEvent.body" rows="5" class="block w-full mt-1"
                            @input="formCreateEvent.validate('body')" />
                        <InputError :message="formCreateEvent.errors.body" class="mt-2" />
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
