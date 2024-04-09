<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
});

</script>

<template>
    <Link :href="href"
        class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest transition duration-150 ease-in-out border rounded border-sky-700 text-sky-700 hover:text-white focus:bg-sky-900 active:bg-sky-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 hover:bg-sky-900">
    <slot />
    </Link>
</template>
