<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';
import { User } from '@/types';
import {
    ArrowRightOnRectangleIcon,
    Bars3Icon,
    BellIcon,
    ChartBarIcon,
    ChevronDownIcon,
    Cog6ToothIcon,
    CubeIcon,
    DocumentTextIcon,
    HomeIcon,
    MagnifyingGlassIcon, ShieldCheckIcon,
    UserGroupIcon,
    UserIcon,
    UsersIcon,
    XMarkIcon
} from '@heroicons/vue/24/outline';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';

const showingSidebar = ref(window.innerWidth >= 1024);
const showingUserMenu = ref(false);
const page = usePage();
const user = page.props.auth.user as User;

// Track expanded menu sections
const expandedMenus = ref<string[]>([]);

const navigation = [
    {
        name: 'Dashboard',
        href: route('dashboard'),
        icon: HomeIcon,
        current: route().current('dashboard')
    },
    {
        name: 'User Management',
        icon: UsersIcon,
        current: route().current('users.*') || route().current('roles.*'),
        submenu: [
            {
                name: 'Users',
                href: route('users.index'),
                icon: UserGroupIcon,
                current: route().current('users.index')
            },
            {
                name: 'Roles',
                href: route('roles.index'),
                icon: ShieldCheckIcon,
                current: route().current('roles.index')
            }
        ]
    },
    {
        name: 'Content',
        icon: DocumentTextIcon,
        current: false,
        submenu: [
            {
                name: 'Pages',
                href: '#',
                icon: DocumentTextIcon,
                current: false
            },
            {
                name: 'Media',
                href: '#',
                icon: CubeIcon,
                current: false
            }
        ]
    },
    {
        name: 'Analytics',
        href: '#',
        icon: ChartBarIcon,
        current: false
    },
    {
        name: 'Settings',
        href: '#',
        icon: Cog6ToothIcon,
        current: false
    }
];

const toggleMenu = (menuName: string) => {
    const index = expandedMenus.value.indexOf(menuName);
    if (index === -1) {
        expandedMenus.value.push(menuName);
    } else {
        expandedMenus.value.splice(index, 1);
    }
};

const isMenuExpanded = (menuName: string) => expandedMenus.value.includes(menuName);

const toggleSidebar = () => {
    showingSidebar.value = !showingSidebar.value;
};

const closeSidebar = () => {
    if (window.innerWidth < 1024) {
        showingSidebar.value = false;
    }
};

// Add this computed property for active menu highlighting
const currentPath = computed(() => {
    return route().current();
});

// Add this for menu hover effect
const hoveredMenu = ref<string | null>(null);

// Add these methods
const setHoveredMenu = (menuName: string | null) => {
    hoveredMenu.value = menuName;
};

const isActiveMenu = (item: any) => {
    if (item.submenu) {
        return item.submenu.some((subitem: any) => subitem.current);
    }
    return item.current;
};

// Add these new refs and functions
const showingNotifications = ref(false);
const searchQuery = ref('');
const searchResults = ref([]);
const isSearching = ref(false);

// Close dropdowns when clicking outside
const closeDropdowns = (event: MouseEvent) => {
    const target = event.target as HTMLElement;

    if (!target.closest('.user-menu-button')) {
        showingUserMenu.value = false;
    }

    if (!target.closest('.notifications-button')) {
        showingNotifications.value = false;
    }
};

// Handle search
const handleSearch = () => {
    if (searchQuery.value.length > 2) {
        isSearching.value = true;
        // Implement your search logic here
        // For example:
        // searchResults.value = await performSearch(searchQuery.value);
        isSearching.value = false;
    }
};

// Handle notifications
const markAllNotificationsAsRead = () => {
    // Implement your notification logic here
};

// Handle user menu actions
const handleProfileClick = () => {
    showingUserMenu.value = false;
};

const handleLogout = () => {
    // Additional logout logic if needed
};

// Add event listeners
onMounted(() => {
    document.addEventListener('click', closeDropdowns);
});

onUnmounted(() => {
    document.removeEventListener('click', closeDropdowns);
});
</script>

<template>
    <div class="min-h-screen bg-gray-50/50 dark:bg-gray-900">
        <FlashMessage />

        <!-- Sidebar Backdrop -->
        <div
            v-if="showingSidebar"
            class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden"
            @click="closeSidebar"
        ></div>

        <!-- Sidebar -->
        <aside
            :class="[
                'fixed inset-y-0 left-0 z-50 w-72 transform transition-transform duration-300 ease-in-out lg:translate-x-0',
                showingSidebar ? 'translate-x-0' : '-translate-x-full'
            ]"
        >
            <div class="flex h-full flex-col bg-white dark:bg-gray-800 shadow-xl">
                <!-- Logo Section with Gradient Border -->
                <div class="relative">
                    <div class="flex h-16 items-center gap-2 px-6 bg-white dark:bg-gray-800">
                        <Link href="/" class="flex items-center gap-2 group">
                            <div class="relative">
                                <div class="absolute -inset-1.5 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg blur-sm group-hover:blur transition-all"></div>
                                <ApplicationLogo class="relative h-8 w-8 text-emerald-600 dark:text-emerald-500 transition-colors" />
                            </div>
                            <span class="text-lg font-bold bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">
                                {{ page.props.app_name }}
                            </span>
                        </Link>
                    </div>
                    <!-- Decorative Bottom Border -->
                    <div class="absolute bottom-0 left-0 right-0 h-[1px] bg-gradient-to-r from-transparent via-emerald-500/20 to-transparent"></div>
                </div>

                <!-- User Profile Section with Hover Effect -->
                <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="group relative p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="absolute inset-0 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 animate-pulse group-hover:opacity-100 opacity-0 blur transition-opacity"></div>
                                <img
                                    :src="`https://ui-avatars.com/api/?name=${user.name}&background=10B981&color=fff`"
                                    :alt="user.name"
                                    class="relative h-10 w-10 rounded-full border-2 border-emerald-200 dark:border-emerald-800"
                                >
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ user.name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                    {{ user.email }}
                                </p>
                            </div>
                            <div class="h-8 w-8 rounded-full flex items-center justify-center bg-gray-100 dark:bg-gray-700 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/30 transition-colors">
                                <Cog6ToothIcon class="h-4 w-4 text-gray-500 dark:text-gray-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation with Enhanced Active States -->
                <nav class="flex-1 px-3 py-4 overflow-y-auto">
                    <!-- Navigation Menu -->
                    <div class="space-y-1">
                        <template v-for="item in navigation" :key="item.name">
                            <!-- Menu Item with Submenu -->
                            <div v-if="item.submenu" class="relative">
                                <!-- Menu Group Header -->
                                <button
                                    @click="toggleMenu(item.name)"
                                    @mouseenter="setHoveredMenu(item.name)"
                                    @mouseleave="setHoveredMenu(null)"
                                    class="group relative flex w-full items-center justify-between rounded-xl px-4 py-3 text-sm font-medium transition-all duration-200"
                                    :class="[
                                        isActiveMenu(item)
                                            ? 'bg-emerald-500 text-white dark:bg-emerald-500'
                                            : 'text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/30',
                                        isMenuExpanded(item.name) && !isActiveMenu(item)
                                            ? 'bg-gray-50 dark:bg-gray-700/50'
                                            : ''
                                    ]"
                                >
                                    <!-- Hover Effect Background -->
                                    <div
                                        class="absolute inset-0 rounded-xl bg-gradient-to-r from-emerald-500/10 to-teal-500/10 opacity-0 transition-opacity duration-300"
                                        :class="{ 'opacity-100': hoveredMenu === item.name && !isActiveMenu(item) }"
                                    ></div>

                                    <!-- Content -->
                                    <div class="relative flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-lg"
                                            :class="[
                                                isActiveMenu(item)
                                                    ? 'bg-emerald-600 text-white'
                                                    : 'bg-gray-50 text-gray-600 dark:bg-gray-700 dark:text-gray-400 group-hover:bg-emerald-500/10 group-hover:text-emerald-600 dark:group-hover:text-emerald-400'
                                            ]"
                                        >
                                            <component
                                                :is="item.icon"
                                                class="h-5 w-5 transition-colors duration-200"
                                            />
                                        </div>
                                        <div class="flex flex-col">
                                            <span>{{ item.name }}</span>
                                            <span class="text-xs font-normal opacity-60">
                                                {{ item.submenu.length }} items
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Dropdown Arrow -->
                                    <ChevronDownIcon
                                        class="h-5 w-5 transition-transform duration-300"
                                        :class="[
                                            isMenuExpanded(item.name) ? 'rotate-180' : '',
                                            isActiveMenu(item) ? 'text-white' : 'text-gray-400 group-hover:text-emerald-600 dark:text-gray-500'
                                        ]"
                                    />
                                </button>

                                <!-- Submenu -->
                                <div
                                    v-show="isMenuExpanded(item.name)"
                                    class="mt-1 space-y-1"
                                >
                                    <Link
                                        v-for="subitem in item.submenu"
                                        :key="subitem.name"
                                        :href="subitem.href"
                                        @mouseenter="setHoveredMenu(subitem.name)"
                                        @mouseleave="setHoveredMenu(null)"
                                        class="group relative flex items-center gap-2 rounded-xl py-3 pl-14 pr-4 text-sm font-medium transition-all duration-200"
                                        :class="[
                                            subitem.current
                                                ? 'bg-emerald-500 text-white'
                                                : 'text-gray-600 hover:bg-emerald-50 dark:text-gray-400 dark:hover:bg-emerald-900/30'
                                        ]"
                                    >
                                        <!-- Hover Effect Background -->
                                        <div
                                            class="absolute inset-0 rounded-xl bg-gradient-to-r from-emerald-500/10 to-teal-500/10 opacity-0 transition-opacity duration-300"
                                            :class="{ 'opacity-100': hoveredMenu === subitem.name && !subitem.current }"
                                        ></div>

                                        <!-- Content -->
                                        <div class="relative flex items-center gap-2">
                                            <component
                                                :is="subitem.icon"
                                                :class="[
                                                    'h-4 w-4 transition-colors duration-200',
                                                    subitem.current
                                                        ? 'text-white'
                                                        : 'text-gray-400 group-hover:text-emerald-600 dark:text-gray-500'
                                                ]"
                                            />
                                            {{ subitem.name }}
                                        </div>
                                    </Link>
                                </div>
                            </div>

                            <!-- Regular Menu Item -->
                            <Link
                                v-else
                                :href="item.href"
                                @mouseenter="setHoveredMenu(item.name)"
                                @mouseleave="setHoveredMenu(null)"
                                class="group relative flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all duration-200"
                                :class="[
                                    item.current
                                        ? 'bg-emerald-500 text-white'
                                        : 'text-gray-700 hover:bg-emerald-50 dark:text-gray-300 dark:hover:bg-emerald-900/30'
                                ]"
                            >
                                <!-- Hover Effect Background -->
                                <div
                                    class="absolute inset-0 rounded-xl bg-gradient-to-r from-emerald-500/10 to-teal-500/10 opacity-0 transition-opacity duration-300"
                                    :class="{ 'opacity-100': hoveredMenu === item.name && !item.current }"
                                ></div>

                                <!-- Content -->
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg"
                                    :class="[
                                        item.current
                                            ? 'bg-emerald-600 text-white'
                                            : 'bg-gray-50 text-gray-600 dark:bg-gray-700 dark:text-gray-400 group-hover:bg-emerald-500/10 group-hover:text-emerald-600 dark:group-hover:text-emerald-400'
                                    ]"
                                >
                                    <component
                                        :is="item.icon"
                                        class="h-5 w-5 transition-colors duration-200"
                                    />
                                </div>
                                <span class="relative">{{ item.name }}</span>
                            </Link>
                        </template>
                    </div>
                </nav>

                <!-- Bottom Section with Gradient Card -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 p-4 dark:from-emerald-900/30 dark:to-teal-900/30">
                        <!-- Decorative Elements -->
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-16 w-16 rounded-full bg-emerald-500/10 blur-2xl"></div>
                        <div class="absolute bottom-0 left-0 -mb-4 -ml-4 h-16 w-16 rounded-full bg-teal-500/10 blur-2xl"></div>

                        <div class="relative">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-emerald-500/10 to-teal-500/10 flex items-center justify-center">
                                    <BellIcon class="h-5 w-5 text-emerald-600 dark:text-emerald-400" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Need Help?</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Check documentation</p>
                                </div>
                            </div>
                            <button class="mt-3 w-full px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-emerald-600 to-teal-500 rounded-lg hover:from-emerald-500 hover:to-teal-400 transition-all duration-200 dark:from-emerald-500 dark:to-teal-400 dark:hover:from-emerald-400 dark:hover:to-teal-300 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                View Documentation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div
            :class="[
                'min-h-screen transition-all duration-300 ease-in-out',
                showingSidebar ? 'lg:pl-72' : ''
            ]"
        >
            <!-- Top Navigation -->
            <header class="sticky top-0 z-40 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700">
                <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                    <!-- Left Side -->
                    <div class="flex items-center gap-4">
                        <!-- Mobile Menu Button -->
                        <button
                            @click="toggleSidebar"
                            class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 lg:hidden"
                        >
                            <Bars3Icon v-if="!showingSidebar" class="h-6 w-6" />
                            <XMarkIcon v-else class="h-6 w-6" />
                        </button>

                        <!-- Breadcrumb -->
                        <nav class="hidden sm:flex items-center gap-2">
                            <Link
                                href="/dashboard"
                                class="text-sm font-medium text-gray-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400"
                            >
                                Dashboard
                            </Link>
                            <span v-if="route().current() !== 'dashboard'" class="text-gray-400 dark:text-gray-600">/</span>
                            <span v-if="route().current() !== 'dashboard'" class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ route().current()?.split('.')[0]?.charAt(0).toUpperCase() + route().current()?.split('.')[0]?.slice(1) }}
                            </span>
                        </nav>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center gap-4">
                        <!-- Search -->
                        <div class="relative hidden md:block">
                            <div class="relative">
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Search..."
                                    @input="handleSearch"
                                    class="w-64 pl-10 pr-4 py-2 text-sm bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:text-gray-300 dark:placeholder-gray-400 transition-colors"
                                >
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <MagnifyingGlassIcon
                                        class="h-5 w-5"
                                        :class="isSearching ? 'text-emerald-500' : 'text-gray-400 dark:text-gray-500'"
                                    />
                                </div>
                            </div>

                            <!-- Search Results Dropdown -->
                            <div v-if="searchQuery.length > 2 && searchResults.length > 0"
                                class="absolute mt-2 w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2">
                                <!-- Add your search results here -->
                            </div>
                        </div>

                        <!-- Theme Switcher -->
                        <ThemeSwitcher />

                        <!-- Notifications -->
                        <div class="relative">
                            <button
                                type="button"
                                @click="showingNotifications = !showingNotifications"
                                class="notifications-button relative inline-flex h-9 w-9 items-center justify-center rounded-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors"
                            >
                                <BellIcon class="h-5 w-5 text-gray-600 dark:text-gray-400" />
                                <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-emerald-500"></span>
                            </button>

                            <!-- Notifications Dropdown -->
                            <div v-if="showingNotifications"
                                class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
                                        <button
                                            @click="markAllNotificationsAsRead"
                                            class="text-xs text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 dark:hover:text-emerald-300"
                                        >
                                            Mark all as read
                                        </button>
                                    </div>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <!-- Add your notifications list here -->
                                    <div class="p-4 text-sm text-gray-500 dark:text-gray-400 text-center">
                                        No new notifications
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div class="relative">
                            <button
                                @click="showingUserMenu = !showingUserMenu"
                                class="user-menu-button flex items-center gap-2 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            >
                                <img
                                    :src="`https://ui-avatars.com/api/?name=${user.name}&background=10B981&color=fff`"
                                    :alt="user.name"
                                    class="h-8 w-8 rounded-full"
                                >
                                <span class="hidden sm:block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ user.name }}
                                </span>
                                <ChevronDownIcon
                                    class="h-5 w-5 text-gray-400 dark:text-gray-500 transition-transform duration-200"
                                    :class="{ 'rotate-180': showingUserMenu }"
                                />
                            </button>

                            <!-- User Dropdown -->
                            <div v-show="showingUserMenu"
                                class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                                <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ user.name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ user.email }}</p>
                                </div>
                                <div class="py-1">
                                    <Link
                                        :href="route('profile.edit')"
                                        @click="handleProfileClick"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                    >
                                        <UserIcon class="h-4 w-4 text-gray-400" />
                                        Profile
                                    </Link>
                                    <Link
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        @click="handleLogout"
                                        class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/50"
                                    >
                                        <ArrowRightOnRectangleIcon class="h-4 w-4" />
                                        Log Out
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
