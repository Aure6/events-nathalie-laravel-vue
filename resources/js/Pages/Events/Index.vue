<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(["events"]);
</script>

<template>
    <GuestLayout title="Formations">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Formations
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-6 overflow-hidden sm:rounded-lg">
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
                            </svg>{{ event.place }}
                        </div>
                        </Link>
                        <!-- </Link> -->
                    </ul>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
