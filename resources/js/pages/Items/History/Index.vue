<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';

// TypeScript type for Item
interface Item {
    id: number;
    name: string;
    unit: string;
    quantity: number;
    deductQuantity?: number; // input for deducting quantity
}

const items = ref<Item[]>([]);

// Flash messages
const flash = ref<{ success?: string; error?: string }>({});

// Fetch items from Laravel GET route
const fetchItems = async () => {
    try {
        const response = await axios.get<Item[]>('/get-items'); // same route
        items.value = response.data.map((item) => ({
            ...item,
            deductQuantity: 0,
        }));
    } catch (error) {
        console.error('Failed to fetch items:', error);
    }
};

const setFlash = (type: 'success' | 'error', message: string) => {
    flash.value = { [type]: message };
    setTimeout(() => {
        flash.value = {};
    }, 3000);
};

// Deduct all quantities at once
const deductAllQuantities = async () => {
    try {
        const updates = items.value
            .filter((item) => item.deductQuantity && item.deductQuantity > 0)
            .map((item) => ({
                id: item.id,
                deductQuantity: item.deductQuantity,
            }));

        if (updates.length === 0) {
            setFlash('error', 'No quantities to deduct!');
            return; // stop here
        }

        await axios.post('/deduct-multiple-quantities', { updates });

        // Update local quantities
        updates.forEach((update) => {
            const item = items.value.find((i) => i.id === update.id);
            if (item) {
                item.quantity -= update.deductQuantity!;
                if (item.quantity < 0) item.quantity = 0; // prevent negative
                item.deductQuantity = 0;
            }
        });

        setFlash('success', 'All quantities deducted successfully!');
    } catch (error) {
        console.error('Failed to deduct quantities:', error);
        setFlash('error', 'Failed to deduct quantities.');
    }
};

onMounted(() => {
    fetchItems();
});
</script>

<template>
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <!-- Success -->
            <div
                v-if="flash.success"
                class="mb-2 rounded bg-green-100 p-3 text-green-700"
            >
                {{ flash.success }}
            </div>

            <!-- Error -->
            <div
                v-if="flash.error"
                class="mb-2 rounded bg-red-100 p-3 text-red-700"
            >
                {{ flash.error }}
            </div>

            <h2 class="text-xl font-semibold">History Items</h2>

            <!-- Items Table -->
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="border px-4 py-2 text-black">ID</th>
                            <th class="border px-4 py-2 text-black">Name</th>
                            <th class="border px-4 py-2 text-black">Unit</th>
                            <th class="border px-4 py-2 text-black">
                                Quantity
                            </th>
                            <th class="border px-4 py-2 text-black">
                                Deduct Quantity
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in items"
                            :key="item.id"
                            class="hover:bg-gray-500"
                        >
                            <td class="border px-4 py-2">{{ item.id }}</td>
                            <td class="border px-4 py-2">{{ item.name }}</td>
                            <td class="border px-4 py-2">{{ item.unit }}</td>
                            <td class="border px-4 py-2">
                                {{ item.quantity }}
                            </td>
                            <td class="border px-4 py-2">
                                <input
                                    type="number"
                                    v-model.number="item.deductQuantity"
                                    min="0"
                                    :max="item.quantity"
                                    class="w-20 border px-2 py-1"
                                />
                            </td>
                        </tr>
                        <tr v-if="items.length === 0">
                            <td
                                class="border px-4 py-2 text-center"
                                colspan="5"
                            >
                                No items found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Deduct All Button -->
            <div class="mt-4">
                <button
                    @click="deductAllQuantities"
                    class="rounded bg-red-500 px-4 py-2 text-white"
                >
                    Deduct All Quantities
                </button>
            </div>
        </div>
    </AppLayout>
</template>
