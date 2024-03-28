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

const props = defineProps(["event", "contacts"]);

const formUpdateEvent = usePrecognitionForm("patch", route("admin.events.update", {
    event: props.event.id,
}), {
    organizer_id: props.event.organizer_id,
    name: props.event.name,
    description: props.event.description,
    place_id: props.event.place_id,
    start: props.event.start,
    end: props.event.end,
    body: props.event.body,
});

formUpdateEvent.setValidationTimeout(300);

const updateEvent = () => {
    formUpdateEvent.submit({
        preserveScroll: true,
        onSuccess: () => {
            //
        },
    });
};
</script>

<template>
    <AppLayout title="Événements">
        <template #header>
            <div class="flex">
                <div class="inline-block">
                    <SecondaryLink :href="route('admin.events.create')">
                        Nouveau
                    </SecondaryLink>
                    <Link :href="route('admin.events.index')">
                    <h2 class="inline-block ml-4 text-lg font-semibold leading-tight text-sky-800">
                        Événements
                    </h2>
                    </Link>
                </div>
                <div class="inline-block mx-auto ">
                    <SecondaryLink :href="route('registrations.index', event.id)">
                        Inscriptions
                    </SecondaryLink>
                </div>
            </div>
        </template>


        <div class="py-2 mx-auto bg-white border-t-2 max-w-7xl sm:px-6 lg:px-8">
            <form @submit.prevent="updateEvent">
                <div class="flex justify-center">
                    <ActionMessage :on="formUpdateEvent.recentlySuccessful" class="me-3">
                        Sauvegardé.
                    </ActionMessage>

                    <PrimaryButton :class="{ 'opacity-25': formUpdateEvent.processing }"
                        :disabled="formUpdateEvent.processing" class="mx-auto">
                        Sauvegarder
                    </PrimaryButton>
                </div>
                <!-- Name -->
                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="name" value="Nom de l'événement" class="text-lg" />
                    <TextInput id="name" v-model="formUpdateEvent.name" type="text" class="block w-full mt-1 text-lg"
                        @input="formUpdateEvent.validate('name')" />
                    <InputError :message="formUpdateEvent.errors.name" class="mt-2" />
                </div>
                <div class="">
                    <div class="grid grid-cols-2">
                        <!-- start -->
                        <div class="">
                            <InputLabel for="start" value="Début" />
                            <TextInput id="start" v-model="formUpdateEvent.start" type="datetime-local"
                                class="block w-full mt-1" @input="formUpdateEvent.validate('start')" />
                            <InputError :message="formUpdateEvent.errors.start" class="mt-2" />
                        </div>
                        <!-- end -->
                        <div class="">
                            <InputLabel for="end" value="Fin" />
                            <TextInput id="end" v-model="formUpdateEvent.end" type="datetime-local"
                                class="block w-full mt-1" @input="formUpdateEvent.validate('end')" />
                            <InputError :message="formUpdateEvent.errors.end" class="mt-2" />
                        </div>
                    </div>
                    <!-- place_id -->
                    <div class="">
                        <InputLabel for="organizer_id" value="Lieu" />
                        <select id="organizer_id" v-model="formUpdateEvent.place_id" class="block w-full mt-1 border-0"
                            @input="formUpdateEvent.validate('place_id')">
                            <option v-for="contact in contacts" :key="contact.id" :value="contact.id">
                                {{ contact.contactable.name }}
                            </option>
                        </select>
                        <InputError :message="formUpdateEvent.errors.place_id" class="mt-2" />
                    </div>
                    <!-- organizer_id -->
                    <div class="">
                        <InputLabel for="organizer_id" value="Organisateur" />
                        <select id="organizer_id" v-model="formUpdateEvent.organizer_id"
                            class="block w-full mt-1 border-0" @input="formUpdateEvent.validate('organizer_id')">
                            <option v-for="contact in contacts" :key="contact.id" :value="contact.id">
                                {{ contact.contactable.name }}
                            </option>
                        </select>
                        <InputError :message="formUpdateEvent.errors.organizer_id" class="mt-2" />
                    </div>
                    <!-- Limiter les inscriptions -->
                </div>
                <!-- description -->
                <div class="">
                    <InputLabel for="description" value="Brève description affiché dans la liste des évènements" />
                    <textarea id="description" v-model="formUpdateEvent.description" type="text"
                        class="block w-full mt-1" @input="formUpdateEvent.validate('description')" />
                    <InputError :message="formUpdateEvent.errors.description" class="mt-2" />
                </div>
                <!-- body -->
                <div class="">
                    <InputLabel for="body" value="Corps de texte de la page de l'événement" />
                    <textarea id="body" v-model="formUpdateEvent.body" rows="10" class="block w-full mt-1"
                        @input="formUpdateEvent.validate('body')" />
                    <InputError :message="formUpdateEvent.errors.body" class="mt-2" />
                </div>
            </form>
        </div>
    </AppLayout>
</template>
