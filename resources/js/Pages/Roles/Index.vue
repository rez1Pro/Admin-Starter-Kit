<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { 
    PlusIcon, 
    PencilSquareIcon, 
    TrashIcon,
    ShieldCheckIcon 
} from '@heroicons/vue/24/outline';

const props = defineProps<{
    roles: {
        data: Array<{
            id: number;
            name: string;
            description: string;
            permissions_count: number;
            created_at: string;
        }>;
        links: Array<any>;
    };
}>();

const deleteRole = (id: number) => {
    if (confirm('Are you sure you want to delete this role?')) {
        router.delete(route('roles.destroy', id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                // Show success message
            },
        });
    }
};
</script>

<template>
    <Head title="Roles Management" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Roles Management</h1>
                    <p class="mt-1 text-sm text-gray-500">Manage user roles and their permissions</p>
                </div>
                <Link
                    :href="route('roles.create')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
                >
                    <PlusIcon class="w-5 h-5 mr-2" />
                    Create Role
                </Link>
            </div>

            <!-- Roles List -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Permissions
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created At
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="role in roles.data" :key="role.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <ShieldCheckIcon class="h-5 w-5 text-indigo-500 mr-2" />
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ role.name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500">
                                        {{ role.description || 'No description' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                        {{ role.permissions_count }} Permissions
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ new Date(role.created_at).toLocaleDateString() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <Link
                                            :href="route('roles.edit', role.id)"
                                            class="text-indigo-600 hover:text-indigo-900"
                                        >
                                            <PencilSquareIcon class="h-5 w-5" />
                                        </Link>
                                        <button
                                            @click="deleteRole(role.id)"
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            <TrashIcon class="h-5 w-5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 