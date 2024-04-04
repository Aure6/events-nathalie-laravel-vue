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

const props = defineProps(["events"]);

const confirmingCreateEvent = ref(false);
const confirmCreateEvent = () => {
    confirmingCreateEvent.value = true;
};

const closeModal = () => {
    confirmingCreateEvent.value = false;

    formCreateEvent.reset();
};

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
        onSuccess: () => closeModal(),
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
            <PrimaryButton @click="confirmCreateEvent" type="button">
                Nouveau
            </PrimaryButton>
            <h2 class="inline-block ml-4 text-lg font-semibold leading-tight text-gray-800 ">
                Événements
            </h2>
        </template>

        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-3 gap-6">
                    <ul class="">
                        <h3 class="font-bold">Nouveau</h3>
                    </ul>
                    <ul class="">
                        <h3 class="font-bold">Annoncé</h3>
                        <Link :href="route('admin.events.edit', { id: event.id })" v-for="event in events"
                            :key="event.id" class="grid grid-cols-3 bg-white border hover:border-sky-900">
                        <div class="flex items-center col-span-1 p-2 text-white bg-sky-700">
                            <div v-if="event.start && event.end">
                                <div>
                                    {{ event.start }}
                                    <!--  {{ event.start.substring(0, 16) }} -->
                                    {{ event.month_start }}
                                </div>
                                <div>
                                    -> <!-- {{ event.end.substring(0, 10) }} --> {{ event.end }}
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2 p-2">
                            <h4 class="">
                                {{ event.name }}
                            </h4>
                            <div class="text-sm text-gray-600"><svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor" class="inline-block w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                                </svg>
                                {{ event.registrations_number }} participants</div>
                            <div class="text-sm text-gray-600"><svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor" class="inline w-4 h-4 text-gray-600">
                                    <path fill-rule="evenodd" d=" m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975
                                16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25
                                8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975
                                0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                </svg> {{ event.place.contactable.name }}
                            </div>
                        </div>
                        </Link>
                    </ul>
                    <ul class="">
                        <h3 class="font-bold">Terminé</h3>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Create event modal -->
        <form @submit.prevent="CreateEvent">
            <DialogModal :show="confirmingCreateEvent" @close="closeModal">
                <template #title>
                    Créer un évènement
                </template>
                <!-- CreateEvent -->

                <template #content>
                    Pour créer un évènement, entrez le nom de l'évènement

                    <div class="mt-4">
                        <InputLabel for="name" value="Nom de l'événement" />
                        <TextInput id="name" v-model="formCreateEvent.name" type="text"
                            class="block w-full mt-1 text-lg" @input="formCreateEvent.validate('name')" />
                        <InputError :message="formCreateEvent.errors.name" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <!-- <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteUser">
                    Delete Account
                </DangerButton> -->

                    <PrimaryButton :class="{ 'opacity-25': formCreateEvent.processing }"
                        :disabled="formCreateEvent.processing" class="ms-3">
                        Créer
                    </PrimaryButton>
                </template>
            </DialogModal>
        </form>
    </AppLayout>
</template>
