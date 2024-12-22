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

    <AuthenticatedLayout>
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">User Management</h1>
                    <p class="mt-1 text-sm text-gray-500">Manage system users</p>
                </div>
            </div>
            <LaraTable :columns="columns" :items="props.users">
                <template #role="{ item }">
                    {{ item.role.name }}
                </template>

                <template #phone="{ item }">
                    {{ item.phone ? item.phone : 'N/A' }}
                </template>

                <template #actions="{ item }">
                    <div class="flex gap-2">
                        <Link class="px-4 py-2 bg-blue-500 text-white rounded-md" :href="route('users.edit', item.id)">
                        Edit</Link>
                        <Link class="px-4 py-2 bg-red-500 text-white rounded-md"
                            :href="route('users.destroy', item.id)">Delete</Link>
                    </div>
                </template>
            </LaraTable>
        </div>
    </AuthenticatedLayout>
</template>