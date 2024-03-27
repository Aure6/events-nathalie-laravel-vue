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

const props = defineProps(["contacts"]);

// console.log(props.contacts.value);
// console.log(props);
// console.log(props.value);
</script>

<template>
    <AppLayout title="Contacts">
        <template #header>
            <!-- <PrimaryLink :href="route('admin.contacts.create')">
                Nouveau
            </PrimaryLink> -->
            <h2 class="inline-block ml-4 text-lg font-semibold leading-tight text-gray-800">
                Contacts
            </h2>
        </template>

        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <ul class="grid grid-cols-3 min-h-32">
                    <Link :href="route('admin.contacts.edit', { contact: contact.id })" v-for="contact in contacts"
                        :key="contact.id" class="grid grid-cols-3 bg-white border hover:border-sky-900">
                    <div class="flex items-center col-span-1 p-2">
                        <!-- TODO : Image placeholder for contacts without picture -->
                        <img v-if="contact.img_path" :src="contact.img_path" alt="" />
                    </div>
                    <div class="col-span-2 p-2">
                        <h3 class="font-semibold">
                            {{ contact.contactable.name }}
                        </h3>
                        <div class="text-sm">
                            <span v-if="contact.city">contact.city</span>
                            <span v-if="contact.city && contact.country">, </span>
                            <span v-if="contact.country">contact.country</span>
                        </div>
                        <div class="text-sm ">
                            {{ contact.email }}
                        </div>
                    </div>
                    </Link>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>
