<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { PropType, reactive } from 'vue';
// @ts-ignore
import type { PaginatedResponse } from 'vue3-lara-table';

const props = defineProps({
    users: Object as PropType<PaginatedResponse<App.Data.UserData>>,
});

const columns = reactive([
    { label: 'Name', key: 'name' },
    { label: 'Email', key: 'email' },
    { label: 'Phone', key: 'phone' },
    { label: 'Role', key: 'role' },
    { label: 'Actions', key: 'actions' },
]);
</script>

<template>

    <Head title="User Management" />

    <AuthenticatedLayout header="User Management" description="Manage system users">
        <div class="space-y-6 p-3 rounded-lg bg-white dark:bg-gray-800 shadow-md dark:shadow-gray-900/50">
            <LaraTable :columns="columns" :items="props.users" enableAddItem>
                <template #add-item>
                    <div class="flex justify-end items-center">
                        <Link :href="route('users.create')"
                            class="px-4 py-2 text-sm font-medium bg-gray-900 text-white rounded-md hover:bg-gray-800 dark:bg-gray-900 dark:hover:bg-gray-800">
                        Create User
                        </Link>
                    </div>
                </template>

                <template #role="{ item }">
                    {{ item.role.name }}
                </template>

                <template #phone="{ item }">
                    {{ item.phone ? item.phone : 'N/A' }}
                </template>

                <template #actions="{ item }">
                    <div class="flex gap-2">
                        <Link
                            class="px-4 py-2 text-sm font-medium bg-gray-900 text-white rounded-md hover:bg-gray-800 dark:bg-gray-900 dark:hover:bg-gray-800"
                            :href="route('users.edit', item.id)">
                        Edit</Link>
                        <Link
                            class="px-4 py-2 text-sm font-medium bg-red-500 text-white rounded-md hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500"
                            :href="route('users.destroy', item.id)">Delete</Link>
                    </div>
                </template>
            </LaraTable>
        </div>
    </AuthenticatedLayout>
</template>