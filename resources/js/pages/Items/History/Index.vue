<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const items = ref<any[]>([]);
const pagination = ref<any>({});

// Fetch items from API
const fetchItems = async () => {
    const response = await axios.get('/get-items');
    items.value = response.data.data;
    pagination.value = response.data.pagination;
};

// Initial load
onMounted(() => {
    fetchItems();
});
</script>

<template>
    <AppLayout>
        <div class="space-y-6 p-6">
            <h2 class="text-xl font-semibold">Items List</h2>

            <table class="w-full border">
                <thead class="bg-gray-500">
                    <tr>
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Unit</th>
                        <th class="border p-2">Quantity</th>
                        <th class="border p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items" :key="item.id">
                        <td class="border p-2">{{ item.id }}</td>
                        <td class="border p-2">{{ item.name }}</td>
                        <td class="border p-2">{{ item.unit }}</td>
                        <td class="border p-2">{{ item.quantity }}</td>
                        <td class="border p-2">
                            <button
                                @click="
                                    router.get(
                                        `/items/history-data?item_id=${item.id}`,
                                    )
                                "
                                class="rounded bg-blue-600 px-3 py-1 text-white"
                            >
                                Show History
                            </button>
                        </td>
                    </tr>

                    <tr v-if="items.length === 0">
                        <td colspan="5" class="p-4 text-center">
                            No items found
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
