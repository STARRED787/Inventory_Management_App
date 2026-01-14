<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import axios from 'axios';
import { ref, watch } from 'vue';

const search = ref('');
const items = ref<any[]>([]);
const loading = ref(false);

const fetchItems = async () => {
    loading.value = true;

    try {
        const response = await axios.get('/items/search/data', {
            params: { search: search.value },
        });

        items.value = response.data.data;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
};

// Auto search while typing
watch(search, () => {
    fetchItems();
});
</script>

<template>
    <AppLayout>
        <div class="space-y-6 p-6">
            <!-- Search Bar -->
            <input
                v-model="search"
                type="text"
                placeholder="Search items..."
                class="w-full rounded border p-3"
            />

            <!-- Loading -->
            <p v-if="loading" class="text-gray-500">Searching...</p>

            <!-- Cards -->
            <div
                v-if="items.length"
                class="grid grid-cols-1 gap-4 md:grid-cols-3"
            >
                <div
                    v-for="item in items"
                    :key="item.id"
                    class="rounded bg-gray-500 p-4 shadow"
                >
                    <h3 class="text-lg font-semibold">{{ item.name }}</h3>
                    <p>Unit: {{ item.unit }}</p>
                    <p class="font-semibold">Stock: {{ item.quantity }}</p>
                </div>
            </div>

            <!-- No Data -->
            <p
                v-if="!loading && items.length === 0"
                class="text-center text-gray-500"
            >
                No items found
            </p>
        </div>
    </AppLayout>
</template>
