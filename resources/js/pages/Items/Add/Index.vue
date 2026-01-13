<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AppLayout from '@/layouts/AppLayout.vue';

// TypeScript type for Item
interface Item {
  id: number;
  name: string;
  unit: string;
  quantity: number;
  addQuantity?: number; // input for adding quantity
}

const items = ref<Item[]>([]);

// Fetch items from Laravel GET route
const fetchItems = async () => {
    try {
        const response = await axios.get<Item[]>('/get-items');
        items.value = response.data.map(item => ({ ...item, addQuantity: 0 }));
    } catch (error) {
        console.error('Failed to fetch items:', error);
    }
}

// Save all quantities at once
const saveAllQuantities = async () => {
    try {
        // Prepare payload: only items where addQuantity > 0
        const updates = items.value
            .filter(item => item.addQuantity && item.addQuantity > 0)
            .map(item => ({
                id: item.id,
                addQuantity: item.addQuantity
            }));

        if (updates.length === 0) {
            alert('No quantities to update!');
            return;
        }

        // Send POST request with all updates
        await axios.post('/update-multiple-quantities', { updates });

        // Update local table values
        updates.forEach(update => {
            const item = items.value.find(i => i.id === update.id);
            if (item) {
                item.quantity += update.addQuantity!;
                item.addQuantity = 0;
            }
        });

        alert('All quantities updated successfully!');
    } catch (error) {
        console.error('Failed to update quantities:', error);
        alert('Failed to update quantities.');
    }
}

onMounted(() => {
    fetchItems();
});
</script>

<template>
<AppLayout>
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <h2 class="text-xl font-semibold">Welcome to Add Items</h2>

        <!-- Items Table -->
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="px-4 py-2 border text-black">ID</th>
                        <th class="px-4 py-2 border text-black">Name</th>
                        <th class="px-4 py-2 border text-black">Unit</th>
                        <th class="px-4 py-2 border text-black">Quantity</th>
                        <th class="px-4 py-2 border text-black">Add Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items" :key="item.id" class="hover:bg-gray-800">
                        <td class="px-4 py-2 border">{{ item.id }}</td>
                        <td class="px-4 py-2 border">{{ item.name }}</td>
                        <td class="px-4 py-2 border">{{ item.unit }}</td>
                        <td class="px-4 py-2 border">{{ item.quantity }}</td>
                        <td class="px-4 py-2 border">
                            <input type="number" v-model.number="item.addQuantity" min="0" class="w-20 border px-2 py-1" />
                        </td>
                    </tr>
                    <tr v-if="items.length === 0">
                        <td class="px-4 py-2 border text-center" colspan="5">No items found</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Save All Button -->
        <div class="mt-4">
            <button @click="saveAllQuantities" class="bg-green-500 text-white px-4 py-2 rounded">Save All Quantities</button>
        </div>
    </div>
</AppLayout>
</template>
