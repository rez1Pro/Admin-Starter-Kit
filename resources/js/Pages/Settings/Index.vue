<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Settings" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Settings</h1>
                    <p class="mt-1 text-sm text-gray-500">Manage system settings</p>
                </div>
            </div>
            <!-- Add your settings content here -->
        </div>
    </AuthenticatedLayout>
</template>