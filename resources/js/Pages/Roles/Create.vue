<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
ArrowLeftIcon,
CheckCircleIcon,
CheckIcon,
KeyIcon,
ShieldCheckIcon,
UserGroupIcon,
} from '@heroicons/vue/24/outline';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    permissionGroups: Array,
});

const form = useForm({
    name: '',
    description: '',
    permissions: [] as number[],
});

// Frontend validation rules
const validationRules = {
    name: [
        (v: string) => !!v || 'Name is required',
        (v: string) => v.length >= 3 || 'Name must be at least 3 characters',
        (v: string) => v.length <= 50 || 'Name must be less than 50 characters'
    ],
    description: [
        (v: string) => !!v || 'Description is required',
        (v: string) => v.length >= 10 || 'Description must be at least 10 characters',
        (v: string) => v.length <= 200 || 'Description must be less than 200 characters'
    ],
    permissions: [
        (v: number[]) => v.length > 0 || 'At least one permission must be selected'
    ]
};

// Validation errors
const validationErrors = ref({
    name: '',
    description: '',
    permissions: ''
});

// Validate single field
const validateField = (field: string, value: any) => {
    const rules = validationRules[field as keyof typeof validationRules];
    const error = rules.find(rule => typeof rule(value) === 'string');
    validationErrors.value[field as keyof typeof validationErrors.value] = error ? error(value) : '';
    return !error;
};

// Validate all fields
const validateForm = () => {
    const fields = ['name', 'description', 'permissions'];
    const validations = fields.map(field =>
        validateField(field, form[field as keyof typeof form])
    );
    return validations.every(v => v);
};

const selectAllInGroup = (groupPermissions: any[]) => {
    groupPermissions.forEach(permission => {
        if (!form.permissions.includes(permission.id)) {
            form.permissions.push(permission.id);
        }
    });
    validateField('permissions', form.permissions);
};

const deselectAllInGroup = (groupPermissions: any[]) => {
    form.permissions = form.permissions.filter(p =>
        !groupPermissions.some(gp => gp.id === p)
    );
    validateField('permissions', form.permissions);
};


// Add this for animation

// Add this for better UX
const isSubmitting = ref(false);

// Add form validation helpers
const hasErrors = computed(() =>
    Object.values(validationErrors.value).some(error => !!error) ||
    Object.keys(form.errors).length > 0
);

const getErrorMessage = (field: string) => {
    return validationErrors.value[field as keyof typeof validationErrors.value] || form.errors[field];
};

const submit = () => {
    if (!validateForm()) {
        return;
    }

    isSubmitting.value = true;
    form.post(route('roles.store'), {
        onSuccess: () => {
            isSubmitting.value = false;
        },
        onError: () => {
            isSubmitting.value = false;
        },
    });
};
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Create Role" />

        <div class="space-y-8 max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Steps -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm py-5 px-6">
                <div class="flex items-center py-2 justify-start gap-2">
                    <div>
                        <Link :href="route('users.roles.index')"
                            class="group flex items-center justify-center h-10 w-10 rounded-lg bg-gray-50 dark:bg-gray-700/50 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-all duration-200">
                        <ArrowLeftIcon
                            class="h-5 w-5 text-gray-500 dark:text-gray-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400" />
                        </Link>
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create Role</h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Configure role details</p>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-12 gap-6" style="margin: 50px 0 50px 0;">
                <!-- Role Information -->
                <div class="col-span-6 lg:col-span-4">
                    <div class="space-y-6 sticky top-20">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                            <!-- Card Header -->
                            <div
                                class="bg-gradient-to-r from-emerald-500/10 via-emerald-500/5 to-transparent dark:from-emerald-900/30 dark:via-emerald-900/10 dark:to-transparent px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-lg bg-emerald-500/10 dark:bg-emerald-400/10 flex items-center justify-center">
                                        <ShieldCheckIcon class="h-5 w-5 text-emerald-600 dark:text-emerald-400" />
                                    </div>
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Role Information</h2>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6 space-y-6">
                                <div class="space-y-4">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                            Role Name
                                        </label>
                                        <div class="relative">
                                            <input v-model="form.name" type="text"
                                                class="block w-full rounded-lg border-gray-200 pl-4 pr-10 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:text-gray-300"
                                                :class="{ 'border-red-500': getErrorMessage('name') }"
                                                placeholder="e.g., Admin, Editor"
                                                @input="validateField('name', form.name)"
                                                @blur="validateField('name', form.name)" />
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <ShieldCheckIcon class="h-5 w-5"
                                                    :class="getErrorMessage('name') ? 'text-red-500' : 'text-gray-400'" />
                                            </div>
                                        </div>
                                        <p v-if="getErrorMessage('name')" class="mt-1 text-sm text-red-600">{{
                                            getErrorMessage('name') }}</p>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                            Description
                                        </label>
                                        <textarea v-model="form.description" rows="4"
                                            class="block w-full rounded-lg border-gray-200 text-sm dark:border-gray-700 dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500 dark:text-gray-300"
                                            :class="{ 'border-red-500': getErrorMessage('description') }"
                                            placeholder="Describe the role's responsibilities and access levels..."
                                            @input="validateField('description', form.description)"
                                            @blur="validateField('description', form.description)"></textarea>
                                        <p v-if="getErrorMessage('description')" class="mt-1 text-sm text-red-600">{{
                                            getErrorMessage('description') }}</p>
                                    </div>
                                </div>

                                <!-- Role Preview Card -->
                                <div
                                    class="space-y-4 mt-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Role Preview</h3>

                                    <!-- Role Badge -->
                                    <div class="flex items-center gap-2">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-8 w-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                                                <ShieldCheckIcon
                                                    class="h-4 w-4 text-emerald-600 dark:text-emerald-400" />
                                            </div>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-900 dark:text-white">
                                                {{ form.name || 'Role Name' }}
                                            </span>
                                            <span class="block text-xs text-gray-500 dark:text-gray-400">
                                                {{ form.description || 'Role description will appear here' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Role Statistics -->
                                <div class="mt-6 grid grid-cols-2 gap-4">
                                    <div
                                        class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-8 w-8 rounded-lg bg-blue-500/10 flex items-center justify-center">
                                                <UserGroupIcon class="h-4 w-4 text-blue-600 dark:text-blue-400" />
                                            </div>
                                            <div>
                                                <span
                                                    class="block text-2xl font-semibold text-gray-900 dark:text-white">0</span>
                                                <span
                                                    class="block text-xs text-gray-500 dark:text-gray-400">Users</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-8 w-8 rounded-lg bg-purple-500/10 flex items-center justify-center">
                                                <KeyIcon class="h-4 w-4 text-purple-600 dark:text-purple-400" />
                                            </div>
                                            <div>
                                                <span
                                                    class="block text-2xl font-semibold text-gray-900 dark:text-white">
                                                    {{ form.permissions.length }}
                                                </span>
                                                <span
                                                    class="block text-xs text-gray-500 dark:text-gray-400">Permissions</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Role Guidelines -->
                                <div
                                    class="mt-6 bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Role Guidelines
                                    </h3>
                                    <ul class="space-y-3">
                                        <li class="flex items-start gap-3">
                                            <div class="flex-shrink-0 mt-1">
                                                <div
                                                    class="h-5 w-5 rounded-full bg-emerald-500/10 flex items-center justify-center">
                                                    <CheckIcon class="h-3 w-3 text-emerald-600 dark:text-emerald-400" />
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                Use descriptive names that reflect the role's responsibilities
                                            </p>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <div class="flex-shrink-0 mt-1">
                                                <div
                                                    class="h-5 w-5 rounded-full bg-emerald-500/10 flex items-center justify-center">
                                                    <CheckIcon class="h-3 w-3 text-emerald-600 dark:text-emerald-400" />
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                Assign minimum required permissions following the principle of least
                                                privilege
                                            </p>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <div class="flex-shrink-0 mt-1">
                                                <div
                                                    class="h-5 w-5 rounded-full bg-emerald-500/10 flex items-center justify-center">
                                                    <CheckIcon class="h-3 w-3 text-emerald-600 dark:text-emerald-400" />
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                Document the role's purpose and scope in the description
                                            </p>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Quick Tips -->
                                <div class="rounded-lg bg-gray-50 dark:bg-gray-700/50 p-4">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Quick Tips</h3>
                                    <ul class="space-y-2">
                                        <li class="flex gap-2 text-xs text-gray-600 dark:text-gray-400">
                                            <div class="flex-shrink-0 mt-1">•</div>
                                            Use clear, descriptive names for roles
                                        </li>
                                        <li class="flex gap-2 text-xs text-gray-600 dark:text-gray-400">
                                            <div class="flex-shrink-0 mt-1">•</div>
                                            Include the role's scope in the description
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissions Section -->
                <div class="col-span-6 lg:col-span-8">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                        <!-- Permissions Header -->
                        <div
                            class="bg-gradient-to-r from-emerald-500/10 via-emerald-500/5 to-transparent dark:from-emerald-900/30 dark:via-emerald-900/10 dark:to-transparent px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-10 w-10 rounded-lg bg-emerald-500/10 dark:bg-emerald-400/10 flex items-center justify-center">
                                    <KeyIcon class="h-5 w-5 text-emerald-600 dark:text-emerald-400" />
                                </div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Permissions</h2>
                            </div>
                        </div>

                        <!-- Permissions Content -->
                        <div class="p-8">
                            <div class="space-y-6">
                                <div v-for="group in props.permissionGroups" :key="group?.name" class="space-y-5">
                                    <!-- Group Header -->
                                    <div
                                        class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="h-8 w-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                                                <ShieldCheckIcon
                                                    class="h-4 w-4 text-emerald-600 dark:text-emerald-400" />
                                            </div>
                                            <div>
                                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{
                                                    group.name }}</h3>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ group.permissions.length }} permissions available
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <button @click="selectAllInGroup(group.permissions)"
                                                class="text-xs font-medium text-emerald-600 hover:text-emerald-500 dark:text-emerald-400">
                                                Select All
                                            </button>
                                            <button @click="deselectAllInGroup(group.permissions)"
                                                class="text-xs font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                                Deselect All
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Permissions Grid -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div v-for="permission in group.permissions" :key="permission.id"
                                            class="group relative flex items-center p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-emerald-500 dark:hover:border-emerald-500 transition-all hover:shadow-sm">
                                            <div
                                                class="absolute inset-0 rounded-lg bg-gradient-to-r from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity dark:from-emerald-900/20">
                                            </div>
                                            <div class="relative flex items-center w-full">
                                                <input :id="permission.id" v-model="form.permissions"
                                                    :value="permission.id" type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-900"
                                                    @change="validateField('permissions', form.permissions)">
                                                <label :for="permission.id" class="ml-3 flex-1 cursor-pointer">
                                                    <span class="block font-medium text-gray-900 dark:text-white">{{
                                                        permission.name }}</span>
                                                    <span class="block text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                        Allow user to {{ permission.name.toLowerCase() }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p v-if="getErrorMessage('permissions')" class="mt-4 text-sm text-red-600">{{
                                getErrorMessage('permissions') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div
                class="fixed bottom-0 left-[280px] right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-4 px-8">
                <div class="max-w-[1600px] mx-auto flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="h-8 w-8 rounded-full bg-emerald-500/10 flex items-center justify-center">
                            <KeyIcon class="h-4 w-4 text-emerald-600 dark:text-emerald-400" />
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            {{ form.permissions.length }} permissions selected
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        <Link :href="route('users.roles.index')"
                            class="px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                        Cancel
                        </Link>
                        <button @click="submit"
                            class="relative inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all disabled:opacity-50"
                            :disabled="isSubmitting || hasErrors">
                            <div v-if="isSubmitting"
                                class="absolute inset-0 flex items-center justify-center bg-emerald-600 rounded-lg">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                            <span :class="{ 'invisible': isSubmitting }">
                                <CheckCircleIcon class="h-5 w-5" />
                            </span>
                            <span :class="{ 'invisible': isSubmitting }">
                                Create Role
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
