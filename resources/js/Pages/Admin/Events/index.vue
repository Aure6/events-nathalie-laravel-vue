<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import ActionMessage from "@/Components/ActionMessage.vue";
import DangerButton from "@/Components/DangerButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryLink from "@/Components/PrimaryLink.vue";
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
            <PrimaryLink :href="route('admin.events.create')">
                Nouveau
            </PrimaryLink>
            <h2 class="inline-block ml-4 text-xl font-semibold leading-tight text-gray-800">
                Événements
            </h2>
        </template>

        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-3">
                    <ul class="">
                        <h3 class="font-bold">Nouveau</h3>
                    </ul>
                    <ul class="">
                        <h3 class="font-bold">Annoncé</h3>
                        <Link :href="route('admin.events.edit', { id: event.id })" v-for="event in events"
                            :key="event.id" class="grid grid-cols-3 bg-white border hover:border-sky-900">
                        <div class="flex items-center col-span-1 p-2 text-white bg-sky-700">
                            <div>
                                <div>
                                    {{ event.start }}
                                    <!--  {{ event.start.substring(0, 16) }} -->
                                    {{ event.month_start }}
                                </div>
                                <div>
                                    -> {{ event.end.substring(0, 10) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2 p-2">
                            <h4 class="text-lg">
                                {{ event.name }}
                            </h4>
                            <div class="text-sm text-gray-600"><svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor" class="inline w-5 h-5 text-gray-600">
                                    <path fill-rule="evenodd" d=" m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975
                                16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25
                                8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975
                                0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                </svg>{{ event.place }}
                            </div>
                            <div class="text-sm text-gray-600"> n participants</div>
                        </div>
                        </Link>
                    </ul>
                    <ul class="">
                        <h3 class="font-bold">Terminé</h3>
                    </ul>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
