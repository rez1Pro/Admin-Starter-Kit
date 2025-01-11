<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface FlashProps {
    success?: string;
    error?: string;
}

const page = usePage();
const flash = computed<FlashProps>(() => page.props.flash as FlashProps);
</script>

<template>
    <div v-if="flash.success || flash.error" class="fixed top-4 right-4 z-50 max-w-sm">
        <div v-if="flash.success" class="bg-green-50 text-green-800 p-4 rounded-lg shadow-lg border border-green-200">
            {{ flash.success }}
        </div>
        <div v-if="flash.error" class="bg-red-50 text-red-800 p-4 rounded-lg shadow-lg border border-red-200">
            {{ flash.error }}
        </div>
    </div>
</template>