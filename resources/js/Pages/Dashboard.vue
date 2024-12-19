<script setup lang="ts">
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {
    ChartBarIcon,
    UsersIcon,
    CurrencyDollarIcon,
    ShoppingCartIcon,
} from '@heroicons/vue/24/outline';

const stats = [
    {
        name: 'Total Revenue',
        value: '$45,231.89',
        change: '+20.1%',
        changeType: 'positive',
        icon: CurrencyDollarIcon,
    },
    {
        name: 'Active Users',
        value: '2,338',
        change: '+15.3%',
        changeType: 'positive',
        icon: UsersIcon,
    },
    {
        name: 'New Orders',
        value: '182',
        change: '-3.2%',
        changeType: 'negative',
        icon: ShoppingCartIcon,
    },
    {
        name: 'Growth Rate',
        value: '32.5%',
        change: '+2.4%',
        changeType: 'positive',
        icon: ChartBarIcon,
    },
];

const recentActivities = [
    {
        user: 'John Doe',
        action: 'created a new order',
        time: '2 minutes ago',
        avatar: 'https://ui-avatars.com/api/?name=John+Doe&background=6366f1&color=fff',
    },
    // Add more activities...
];

const topProducts = [
    {
        name: 'Product A',
        sales: 245,
        revenue: '$12,480',
        growth: '+28%',
    },
    // Add more products...
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Welcome Section -->
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Welcome back, Admin!</h1>
                    <p class="mt-1 text-sm text-gray-500">Here's what's happening with your business today.</p>
                </div>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    Download Report
                </button>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    v-for="stat in stats"
                    :key="stat.name"
                    class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ stat.name }}</p>
                            <p class="mt-2 text-3xl font-semibold text-gray-900">{{ stat.value }}</p>
                        </div>
                        <div :class="[
                            'p-3 rounded-lg',
                            stat.changeType === 'positive' ? 'bg-green-50' : 'bg-red-50'
                        ]">
                            <component
                                :is="stat.icon"
                                :class="[
                                    'w-6 h-6',
                                    stat.changeType === 'positive' ? 'text-green-600' : 'text-red-600'
                                ]"
                            />
                        </div>
                    </div>
                    <div class="mt-4 flex items-center">
                        <span
                            :class="[
                                'text-sm font-medium',
                                stat.changeType === 'positive' ? 'text-green-600' : 'text-red-600'
                            ]"
                        >
                            {{ stat.change }}
                        </span>
                        <span class="ml-2 text-sm text-gray-500">from last month</span>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Sales Chart -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900">Sales Overview</h2>
                    <div class="mt-4 h-80">
                        <!-- Add your chart component here -->
                        <div class="w-full h-full bg-gray-50 rounded-lg flex items-center justify-center">
                            <p class="text-gray-400">Chart Component Here</p>
                        </div>
                    </div>
                </div>

                <!-- Revenue Chart -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900">Revenue Analytics</h2>
                    <div class="mt-4 h-80">
                        <!-- Add your chart component here -->
                        <div class="w-full h-full bg-gray-50 rounded-lg flex items-center justify-center">
                            <p class="text-gray-400">Chart Component Here</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Activities -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Activities</h2>
                    <div class="mt-4 space-y-4">
                        <div
                            v-for="(activity, index) in recentActivities"
                            :key="index"
                            class="flex items-center space-x-4"
                        >
                            <img
                                :src="activity.avatar"
                                :alt="activity.user"
                                class="w-10 h-10 rounded-full"
                            />
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">
                                    <span class="font-medium">{{ activity.user }}</span>
                                    {{ activity.action }}
                                </p>
                                <p class="text-xs text-gray-500">{{ activity.time }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Products -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900">Top Products</h2>
                    <div class="mt-4">
                        <div class="space-y-4">
                            <div
                                v-for="(product, index) in topProducts"
                                :key="index"
                                class="flex items-center justify-between"
                            >
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ product.name }}</p>
                                    <p class="text-xs text-gray-500">{{ product.sales }} sales</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ product.revenue }}</p>
                                    <p class="text-xs text-green-600">{{ product.growth }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
