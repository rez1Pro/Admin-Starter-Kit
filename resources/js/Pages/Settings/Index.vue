<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Settings" />

    <AuthenticatedLayout header="App Settings" description="You can change you app settings!">
        Hello world
    </AuthenticatedLayout>
</template>