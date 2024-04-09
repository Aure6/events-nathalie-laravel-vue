<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(["events"]);
</script>

<template>
    <GuestLayout title="Futures formations">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Futures formations
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="space-y-6 overflow-hidden sm:p-6 sm:rounded-xl">
                    <div class="p-6 text-white rounded-xl">
                        Pour être prévenu de la date lorsqu'une formation future est fixée, choisissez la formation qui
                        vous intéresse et vous pourrez remplir un formulaire avec votre adresse e-mail afin d'être
                        prévenu. <!-- 😀 -->
                    </div>
                    <ul class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
                        <Link :href="route('future.show', { id: event.id })" v-for="event in events" :key="event.id"
                            class="transition bg-white sm:rounded-xl hover:bg-green-100">
                        <!-- stored in storage/app/public/images -->
                        <img v-if="event.img_path" class="sm:rounded-t-xl" :src="'/storage/images/' + event.img_path" />
                        <img v-else class="sm:rounded-t-xl" src="/storage/images/event_placeholder.jpg" />
                        <div class="p-6">
                            <h3 class="mb-2 text-xl">
                                {{ event.name }}
                            </h3>
                            <div class="mb-2 text-gray-600"> {{ event.description }}</div>
                            <div v-if="event.start && event.end" class="mb-2">
                                {{ event.start.substring(5, 7) }} {{ event.month_start }}
                            </div>
                            <!-- <div class="text-gray-600"> {{ event.start.substring(0, 16) }} -> {{ event.end.substring(0,
                                16) }}</div> -->
                            <div class="flex flex-row items-center gap-1 text-sm text-gray-600"><svg
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="inline-block w-5 h-5 text-gray-600">
                                    <path fill-rule="evenodd"
                                        d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>{{ event.place.contactable.name }}</div>
                            </div>
                            {{ registrations_number }} participant(s) inscrit(s).
                        </div>
                        </Link>
                    </ul>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
