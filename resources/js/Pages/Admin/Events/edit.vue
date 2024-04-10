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
import { ref, computed } from "vue";

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

// if (props.event.registrations_limit === null) {
//     const isLimitChecked = ref(false);
//     console.log(isLimitChecked.value);
//     console.log(isLimitChecked);
// } else {
//     // isLimitChecked.value = true;
//     const isLimitChecked = ref(true);
//     console.log(isLimitChecked.value);
//     console.log(isLimitChecked);
// };

const updateEvent = () => {
    // console.log(isLimitChecked.value);
    // console.log(isLimitChecked);
    // if (typeof isLimitChecked.value === 'undefined') {
    //     throw new Error('isLimitChecked is undefined. Typeof is ' + typeof isLimitChecked.value);
    //     // props.event.registrations_limit = null;
    //     throw new Error(typeof isLimitChecked.value);
    // }
    // if (isLimitChecked.value === true) {

    // } else {
    //     props.event.registrations_limit = null;
    // };

    formUpdateEvent.submit({
        preserveScroll: true,
        onSuccess: () => {
            //
        },
    });
};


// Ticket
const formCreateTicket = usePrecognitionForm("post", route("tickets.store"), {
    name: "",
    price: "",
    event_id: props.event.id,
});

formCreateTicket.setValidationTimeout(300);

const confirmingTicketCreation = ref(false);

const createTicket = () => {
    formCreateTicket.submit({
        preserveScroll: true,
        onSuccess: () => {
            formCreateTicket.name = "";
            formCreateTicket.price = "";
            confirmTicketCreation.value = false;
        },
    });
};

const confirmTicketCreation = () => {
    confirmingTicketCreation.value = true;
};



// const confirmingTicketUpdating = ref(false);
// const ticketIdToUpdate = ref(null);

// const formUpdateTicket = usePrecognitionForm("put", route("tickets.update", { ticket: ticketIdToUpdate.value, }), {
//     name: props.event.[ticketIdToUpdate.value].name,
//     price: '',
// });

// const confirmTicketUpdating = (id) => {
//     ticketIdToUpdate.value = id;
//     confirmingTicketUpdating.value = true;
// };

// const updateTicket = () => formUpdateTicket.submit({
//     preserveScroll: true,
//     onSuccess: () => formUpdateTicket.reset(),
// });



const confirmingTicketDeletion = ref(false);
const ticketIdToDelete = ref(null);
const formDeleteTicket = useForm("delete", {});
const confirmTicketDeletion = (id) => {
    ticketIdToDelete.value = id;
    confirmingTicketDeletion.value = true;
    deleteTicket();
};
const deleteTicket = () => {
    formDeleteTicket.delete(route("tickets.destroy", { ticket: ticketIdToDelete.value }), {
        preserveScroll: true,
        onSuccess: () => {
            confirmingTicketDeletion.value = false;
        },
    });
};

const closeModal = () => {
    confirmingTicketCreation.value = false;
    // confirmingTicketUpdating.value = false;
    confirmingTicketDeletion.value = false;
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
                    > ID: {{ event.id }}
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
                    <ActionMessage :on="formUpdateEvent.recentlySuccessful" class="text-green-500 me-3">
                        Événement sauvegardé.
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
                <div class="mt-5 space-y-5">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-1">
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
                        <div>
                            <!-- place_id -->
                            <div class="">
                                <InputLabel for="organizer_id" value="Lieu" />
                                <select id="organizer_id" v-model="formUpdateEvent.place_id"
                                    class="block w-full mt-1 border-0" @input="formUpdateEvent.validate('place_id')">
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
                                    class="block w-full mt-1 border-0"
                                    @input="formUpdateEvent.validate('organizer_id')">
                                    <option v-for="contact in contacts" :key="contact.id" :value="contact.id">
                                        {{ contact.contactable.name }}
                                    </option>
                                </select>
                                <InputError :message="formUpdateEvent.errors.organizer_id" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Limiter les inscriptions -->
                    <!-- <div class="space-x-2">
                        <InputLabel for="limit" value="Limiter les inscriptions" class="inline-block" />
                        <input type="checkbox" id="limit" name="limit" v-model="isLimitChecked" />
                        <span v-if="isLimitChecked">
                            jusqu'à
                            <TextInput id="registrations_limit" v-model="formUpdateEvent.registrations_limit"
                                type="number" class="inline-block w-32 p-0"
                                @input="formUpdateEvent.validate('registrations_limit')" />
                            participants
                            <InputError :message="formUpdateEvent.errors.registrations_limit" class="mt-2" />
                        </span>
                    </div> -->
                    <!-- TODO statut de l'event brouillon, RSVP, annoncé avec tag radio. Pour le moment on vérifié la date start pour déterminer si un event est dans les futurs formations -->
                    <div class="mx-auto w-fit">
                        <h3 class="block text-sm font-medium text-gray-700">Tickets</h3>
                        <table>
                            <thead>
                                <tr class="text-left border">
                                    <th class="p-2 px-2 pl-4">Nom</th>
                                    <th class="p-2 px-2 text-right">Prix</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="ticket in event.tickets" :key="ticket.id"
                                    class="border hover:bg-gray-200 even:bg-gray-100 odd:bg-white">
                                    <td class="pl-4 pr-3">{{ ticket.name }}</td>
                                    <td class="">{{ ticket.price }} €</td>
                                    <td class=""><a
                                            class="inline-block px-2 text-yellow-500 transition-all rounded cursor-pointer hover:ring-yellow-500 hover:ring-2 hover:text-white hover:bg-yellow-500"
                                            @click="confirmTicketUpdating(ticket.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="inline-block w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                            </svg>
                                        </a></td>
                                    <td class="pr-4"><a
                                            class="inline-block px-2 text-red-500 transition-all rounded cursor-pointer hover:ring-red-500 hover:ring-2 hover:text-white hover:bg-red-500"
                                            @click="confirmTicketDeletion(ticket.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="inline-block w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg></a></td>
                                </tr>
                                <tr class="border">
                                    <td class=""><a @click="confirmTicketCreation"
                                            class="inline-block w-full text-center transition-all rounded cursor-pointer hover:ring-sky-500 hover:ring-2 hover:text-white hover:bg-sky-500"><svg
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="inline-block w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- description -->
                <div class="max-w-3xl mx-auto mt-5 ">
                    <InputLabel for="description" value="Brève description affiché dans la liste des évènements" />
                    <textarea id="description" v-model="formUpdateEvent.description" type="text"
                        class="block w-full mt-1" @input="formUpdateEvent.validate('description')" />
                    <InputError :message="formUpdateEvent.errors.description" class="mt-2" />
                </div>
                <!-- body -->
                <div class="max-w-3xl mx-auto mt-5">
                    <InputLabel for="body" value="Corps de texte de la page de l'événement" />
                    <textarea id="body" v-model="formUpdateEvent.body" rows="10" class="block w-full mt-1"
                        @input="formUpdateEvent.validate('body')" />
                    <InputError :message="formUpdateEvent.errors.body" class="mt-2" />
                </div>
            </form>
        </div>
    </AppLayout>

    <DialogModal :show="confirmingTicketCreation" @close="closeModal">
        <template #title> Créer un ticket pour cet évènement </template>

        <template #content>
            <form @submit.prevent="createTicket">
                <div class="space-y-3">
                    <div class="w-full">
                        <InputLabel for="name" value="Nom du ticket (Ex: VIP; Particulier; Entreprise)"
                            class="text-lg" />
                        <TextInput id="name" type="text" class="block w-full mt-1 text-lg"
                            v-model="formCreateTicket.name" @input="formCreateTicket.validate('name')" />
                        <InputError :message="formCreateTicket.errors.name" class="mt-2" />
                    </div>
                    <div class="w-full">
                        <InputLabel for="price" value="Prix du ticket (Ex: 25.00)" class="text-lg" />
                        <TextInput id="price" type="number" class="block w-full mt-1 text-lg"
                            v-model="formCreateTicket.price" @input="formCreateTicket.validate('price')" />
                        <InputError :message="formCreateTicket.errors.price" class="mt-2" />
                    </div>
                </div>
            </form>
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal"> Annuler </SecondaryButton>

            <div class="flex justify-center">
                <ActionMessage :on="formCreateTicket.recentlySuccessful" class="text-green-500 me-3 ms-3">
                    Ticket sauvegardé.
                </ActionMessage>

                <PrimaryButton :class="{ 'opacity-25': formCreateTicket.processing }"
                    :disabled="formCreateTicket.processing" @click="createTicket" class="mx-auto">
                    Sauvegarder
                </PrimaryButton>
            </div>
        </template>
    </DialogModal>

    <DialogModal :show="confirmingTicketUpdating" @close="closeModal">
        <template #title> Éditer un ticket pour cet évènement </template>

        <template #content>
            <form @submit.prevent="updateTicket">
                <div class="space-y-3">
                    <div class="w-full">
                        <InputLabel for="name" value="Nom du ticket (Ex: VIP; Particulier; Entreprise)"
                            class="text-lg" />
                        <TextInput id="name" type="text" class="block w-full mt-1 text-lg"
                            v-model="formUpdateTicket.name" @input="formUpdateTicket.validate('name')" />
                        <InputError :message="formUpdateTicket.errors.name" class="mt-2" />
                    </div>
                    <div class="w-full">
                        <InputLabel for="price" value="Prix du ticket (Ex: 25.00)" class="text-lg" />
                        <TextInput id="price" type="number" class="block w-full mt-1 text-lg"
                            v-model="formUpdateTicket.price" @input="formUpdateTicket.validate('price')" />
                        <InputError :message="formUpdateTicket.errors.price" class="mt-2" />
                    </div>
                </div>
            </form>
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal"> Annuler </SecondaryButton>

            <div class="flex justify-center">
                <ActionMessage :on="formUpdateTicket.recentlySuccessful" class="text-green-500 me-3 ms-3">
                    Ticket sauvegardé.
                </ActionMessage>

                <PrimaryButton :class="{ 'opacity-25': formUpdateTicket.processing }"
                    :disabled="formUpdateTicket.processing" @click="updateTicket" class="mx-auto">
                    Sauvegarder
                </PrimaryButton>
            </div>
        </template>
    </DialogModal>
</template>
