<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>
    <Head title="Inventory Management">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="min-h-screen bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a]">
        <!-- Main Content -->
        <div class="flex min-h-screen items-center justify-center p-6 lg:p-8">
            <div class="w-full max-w-4xl">
                <!-- Features Grid -->
                <div class="mb-12">
                    <div class="mb-10 text-center">
                        <h1 class="text-4xl font-bold mb-4 lg:text-5xl text-gray-300">Inventory Management</h1>
                        <p class="text-lg text-gray-200 dark:text-gray-300 max-w-2xl mx-auto">
                            Track, manage, and optimize your inventory with our powerful management solution
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                        <div class="bg-white dark:bg-[#161615] rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-800">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                                <span class="text-xl">➕</span>
                            </div>
                            <h3 class="font-semibold text-lg mb-2 text-gray-300">Add Items</h3>
                            <p class="text-gray-200 dark:text-gray-300 text-sm">
                                Easily add new items to your inventory with detailed information
                            </p>
                        </div>

                        <div class="bg-white dark:bg-[#161615] rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-800">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                                <span class="text-xl">➖</span>
                            </div>
                            <h3 class="font-semibold text-lg mb-2 text-gray-300">Deduct Items</h3>
                            <p class="text-gray-200 dark:text-gray-300 text-sm">
                                Remove or deduct items from inventory with accurate tracking
                            </p>
                        </div>

                        <div class="bg-white dark:bg-[#161615] rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-800">
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                                <span class="text-xl">📜</span>
                            </div>
                            <h3 class="font-semibold text-lg mb-2 text-gray-300">Item History</h3>
                            <p class="text-gray-200 dark:text-gray-300 text-sm">
                                View complete history and audit trails for all inventory items
                            </p>
                        </div>

                        <div class="bg-white dark:bg-[#161615] rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-800">
                            <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mb-4">
                                <span class="text-xl">🔍</span>
                            </div>
                            <h3 class="font-semibold text-lg mb-2 text-gray-300">Search Items</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Quickly find any item in your inventory with powerful search
                            </p>
                        </div>
                    </div>

                    <!-- Central Info Card -->
                    <div class="flex justify-center">
                            <!-- Action Buttons Row -->
                            <div class="mt-1 flex flex-col sm:flex-row gap-4">
                                <template v-if="$page.props.auth.user">
                                    <Link 
                                        :href="dashboard()"
                                        class="flex-1 bg-black text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-800 transition-colors text-center dark:bg-white dark:text-black"
                                    >
                                        Go to Dashboard
                                    </Link>
                                </template>
                                <template v-else>
                                    <Link 
                                        :href="login()"
                                        class="flex-1 bg-black text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-800 transition-colors text-center dark:bg-white dark:text-black"
                                    >
                                        Log in
                                    </Link>
                                    <Link 
                                        v-if="canRegister"
                                        :href="register()"
                                        class="flex-1 border border-gray-300 dark:border-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors text-center text-white"
                                    >
                                        Register
                                    </Link>
                                </template>
                            </div>
                        </div>
                  
                </div>


            </div>
        </div>
    </div>
</template>
