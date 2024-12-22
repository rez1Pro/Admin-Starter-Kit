<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { PlusIcon } from '@heroicons/vue/24/outline';
import { Head, Link } from '@inertiajs/vue3';
import { PropType } from 'vue';
// @ts-ignore
import type { PaginatedResponse } from 'vue3-lara-table';

const props = defineProps({
    roles: Object as PropType<PaginatedResponse<App.Data.RoleData>>,
});

const columns = [
    { label: 'Name', key: 'name' },
    { label: 'Description', key: 'description' },
    { label: 'Permissions', key: 'permissions_count' },
    { label: 'Users', key: 'users_count' },
    { label: 'Created At', key: 'created_at' },
    { label: 'Actions', key: 'actions' },
];
</script>

<template>

    <Head title="Role Management" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Role Management</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage user roles and their permissions</p>
                </div>
                <Link :href="route('users.roles.create')"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                <PlusIcon class="w-5 h-5" />
                Create Role
                </Link>
            </div>

            <!-- Roles List -->
            <LaraTable :columns="columns" :items="props.roles" search-key="name">
                <template #actions="{ item }">
                    <div class="flex gap-2">
                        <Link class="px-4 py-2 bg-emerald-500 text-white rounded-md"
                            :href="route('users.roles.edit', item.id)">
                        Edit</Link>
                        <Link class="px-4 py-2 bg-red-500 text-white rounded-md"
                            :href="route('users.roles.destroy', item.id)">Delete</Link>
                    </div>
                </template>
            </LaraTable>
        </div>
    </AuthenticatedLayout>
</template>
