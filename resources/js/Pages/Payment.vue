<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ActionMessage from "@/Components/ActionMessage.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryLink from "@/Components/PrimaryLink.vue";
import SecondaryLink from "@/Components/SecondaryLink.vue";
import { useForm as usePrecognitionForm } from "laravel-precognition-vue-inertia";

const props = defineProps(["product", "price"]);
</script>

<template>
    <GuestLayout :title="Paiement">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ Paiement }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 ">
                <div class="overflow-hidden bg-green-100 sm:p-6 sm:rounded-xl">



                </div>
            </div>
        </div>
    </GuestLayout>
</template>
