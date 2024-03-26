<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ActionMessage from "@/Components/ActionMessage.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm as usePrecognitionForm } from "laravel-precognition-vue-inertia";

const props = defineProps(["event"]);

const formCreateRegistration = usePrecognitionForm("post", route("registrations.store", { event: props.event.id }), {
    first_name: "",
    last_name: "",
    email: "",
    /* event_id: event.id, */
});

formCreateRegistration.setValidationTimeout(300);

const CreateRegistration = () => {
    formCreateRegistration.submit({
        preserveScroll: true,
        onSuccess: () => form.reset(),
        // onSuccess: () => {
        //     // On vide le champ après avoir créé la tâche
        //     formCreateRegistration.name = "";
        // },
    });
};
</script>

<template>
    <GuestLayout title="Formations">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Formations
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 ">
                <div class="overflow-hidden bg-green-100 sm:p-6 sm:rounded-xl">
                    <div class="grid gap-2 py-6 md:grid-cols-3 sm:rounded-xl sm:px-6 lg:px-8">
                        <div class="space-y-4 md:col-span-2">
                            <img v-if="event.img_path" class="mx-auto sm:rounded-t-xl"
                                :src="'/storage/images/' + event.img_path" />
                            <img v-else class="mx-auto sm:rounded-t-xl" src="/storage/images/event_placeholder.jpg" />
                            <div class="max-w-4xl mx-auto">
                                <h3 class="mb-2 text-xl">
                                    {{ event.name }}
                                </h3>
                                <div class="text-gray-600"> {{ event.description }}</div>
                                <div class="text-gray-600"> {{ event.body }}</div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="text-gray-600">
                                {{ event.start.substring(0, 16) }}
                                ->
                                {{ event.end.substring(0, 16) }}
                            </div>
                            <div class=""> {{ event.start.substring(5, 7) }} {{ event.month_start }}</div>
                            <div class="text-sm text-gray-600"><svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor" class="inline w-5 h-5 text-gray-600">
                                    <path fill-rule="evenodd"
                                        d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                        clip-rule="evenodd" />
                                </svg>{{ event.place }}
                            </div>
                        </div>
                    </div>
                    <form @submit.prevent="CreateRegistration" class="max-w-2xl py-6 mx-auto space-y-4 sm:px-6 lg:px-8">
                        <h3 class="text-xl">Inscrivez-vous!</h3>
                        <!-- first_name -->
                        <div class="">
                            <InputLabel for="first_name" value="Prénom" />
                            <TextInput id="first_name" v-model="formCreateRegistration.first_name" type="text"
                                class="block w-full mt-1 text-lg"
                                @input="formCreateRegistration.validate('first_name')" />
                            <InputError :message="formCreateRegistration.errors.first_name" class="mt-2" />
                        </div>
                        <!-- last_name -->
                        <div class="">
                            <InputLabel for="last_name" value="Nom de famille" />
                            <TextInput id="last_name" v-model="formCreateRegistration.last_name" type="text"
                                class="block w-full mt-1 text-lg"
                                @input="formCreateRegistration.validate('last_name')" />
                            <InputError :message="formCreateRegistration.errors.last_name" class="mt-2" />
                        </div>
                        <!-- email -->
                        <div class="">
                            <InputLabel for="email" value="Adresse email" />
                            <TextInput id="email" v-model="formCreateRegistration.email" type="text"
                                class="block w-full mt-1 text-lg" @input="formCreateRegistration.validate('email')" />
                            <InputError :message="formCreateRegistration.errors.email" class="mt-2" />
                        </div>

                        <div class="flex justify-center">
                            <ActionMessage :on="formCreateRegistration.recentlySuccessful" class="me-3">
                                Envoyé.
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
