<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col items-center justify-center p-6"
        >
            <div
                class="w-full max-w-lg rounded-xl border border-sidebar-border/70 bg-gray-50 p-8 text-center dark:border-sidebar-border dark:bg-gray-800"
            >
                <h1
                    class="mb-2 text-3xl font-bold text-gray-800 dark:text-gray-100"
                >
                    Welcome to the Dashboard
                </h1>
                <p class="text-gray-600 dark:text-gray-300">
                    You can manage your items, view history, and monitor
                    inventory from here.
                </p>
            </div>
        </div>
    </AppLayout>
</template>
