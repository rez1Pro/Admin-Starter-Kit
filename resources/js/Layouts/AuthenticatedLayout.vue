<script setup lang="ts">
import { ref } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { 
    HomeIcon, 
    UsersIcon, 
    KeyIcon,
    Bars3Icon,
    XMarkIcon,
    UserCircleIcon,
    ArrowLeftOnRectangleIcon,
    ChartBarIcon,
    Cog6ToothIcon
} from '@heroicons/vue/24/outline';
import FlashMessage from '@/Components/FlashMessage.vue';

const page = usePage();
const showingSidebar = ref(true);
const showingUserDropdown = ref(false);

const toggleSidebar = () => {
    showingSidebar.value = !showingSidebar.value;
};

const isCurrentRoute = (path: string) => {
    return page.url.startsWith(path);
};

const navigation = [
    { 
        name: 'Dashboard', 
        href: '/dashboard',
        icon: HomeIcon
    },
    { 
        name: 'User Management', 
        href: '/users',
        icon: UsersIcon,
        badge: '12'
    },
    { 
        name: 'Roles & Permissions', 
        href: '/roles',
        icon: KeyIcon 
    },
    { 
        name: 'Settings', 
        href: '/settings',
        icon: Cog6ToothIcon 
    },
];
</script>

<template>
    <div class="min-h-screen bg-gray-50/50">
        <FlashMessage />
        <!-- Sidebar -->
        <div
            :class="[
                'fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 ease-in-out',
                showingSidebar ? 'translate-x-0' : '-translate-x-full'
            ]"
        >
            <div class="h-full flex flex-col bg-white border-r border-gray-200 shadow-lg">
                <!-- Logo -->
                <div class="h-16 flex items-center gap-2 px-6 bg-gradient-to-r from-indigo-600 to-blue-500">
                    <div class="p-2 bg-white/10 rounded-lg">
                        <img src="/logo.png" alt="Logo" class="h-8 w-8" />
                    </div>
                    <span class="text-white font-bold text-xl">AdminHub</span>
                </div>

                <!-- User Profile Summary -->
                <div class="mt-6 px-6">
                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl">
                        <img
                            src="https://ui-avatars.com/api/?name=Admin+User&background=6366f1&color=fff"
                            alt="User"
                            class="h-12 w-12 rounded-lg ring-2 ring-indigo-500/30"
                        />
                        <div>
                            <h3 class="text-sm font-semibold text-slate-700">Admin User</h3>
                            <p class="text-xs text-slate-500">Super Admin</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="mt-6 px-3 flex-1">
                    <div class="space-y-1">
                        <Link
                            v-for="item in navigation"
                            :key="item.name"
                            :href="item.href"
                            class="group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-blue-50"
                            :class="[isCurrentRoute(item.href) ? 'text-indigo-600 bg-gradient-to-r from-indigo-50 to-blue-50' : 'text-slate-600']"
                        >
                            <div class="flex items-center gap-3">
                                <component 
                                    :is="item.icon" 
                                    :class="[isCurrentRoute(item.href) ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-600']"
                                    class="h-5 w-5 transition-colors duration-200"
                                />
                                {{ item.name }}
                            </div>
                            <span 
                                v-if="item.badge"
                                :class="[isCurrentRoute(item.href) ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-600']"
                                class="px-2 py-0.5 text-xs rounded-md transition-colors duration-200"
                            >
                                {{ item.badge }}
                            </span>
                        </Link>
                    </div>
                </nav>

                <!-- Bottom Section -->
                <div class="p-4 mt-auto">
                    <div class="p-4 bg-gradient-to-r from-indigo-500/10 to-blue-500/10 rounded-xl">
                        <p class="text-sm text-slate-600 font-medium">Need Help?</p>
                        <p class="text-xs text-slate-500 mt-1">Check our documentation</p>
                        <button class="mt-3 w-full px-4 py-2 text-sm text-white font-medium bg-gradient-to-r from-indigo-600 to-blue-500 rounded-lg hover:from-indigo-500 hover:to-blue-400 transition-all duration-200">
                            View Docs
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div
            :class="[
                'min-h-screen transition-all duration-300 ease-in-out',
                showingSidebar ? 'lg:pl-72' : ''
            ]"
        >
            <!-- Top Navigation -->
            <div class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-200">
                <div class="flex h-16 items-center justify-between px-6">
                    <button
                        @click="toggleSidebar"
                        class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 lg:hidden"
                    >
                        <Bars3Icon class="h-6 w-6" />
                    </button>

                    <!-- Search and Actions -->
                    <div class="flex items-center gap-4 ml-auto">
                        <div class="relative hidden md:block">
                            <input 
                                type="text" 
                                placeholder="Search..."
                                class="w-72 pl-10 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Notification -->
                        <button class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg relative">
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </button>

                        <!-- User Menu -->
                        <div class="relative">
                            <button
                                @click="showingUserDropdown = !showingUserDropdown"
                                class="flex items-center gap-2 p-2 hover:bg-slate-50 rounded-lg transition-colors duration-200"
                            >
                                <img
                                    src="https://ui-avatars.com/api/?name=Admin+User&background=6366f1&color=fff"
                                    alt="User"
                                    class="h-8 w-8 rounded-lg"
                                />
                                <span class="text-sm font-medium text-slate-700">Admin User</span>
                                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div
                                v-show="showingUserDropdown"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-150 py-1 animate-fade-in-down"
                            >
                                <Link
                                    href="/profile"
                                    class="flex items-center px-4 py-2 text-sm text-slate-600 hover:bg-slate-50"
                                >
                                    <UserCircleIcon class="h-5 w-5 mr-2 text-slate-400" />
                                    Profile
                                </Link>
                                <Link
                                    href="/logout"
                                    method="post"
                                    as="button"
                                    class="flex items-center px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 w-full"
                                >
                                    <ArrowLeftOnRectangleIcon class="h-5 w-5 mr-2 text-slate-400" />
                                    Logout
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
@keyframes fade-in-down {
    0% {
        opacity: 0;
        transform: translateY(-10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-down {
    animation: fade-in-down 0.2s ease-out;
}

.router-link-active {
    @apply text-indigo-600 bg-gradient-to-r from-indigo-50 to-blue-50;
}
</style>
