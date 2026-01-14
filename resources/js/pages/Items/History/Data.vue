<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue';

// Props from Inertia (READ ONLY)
const props = defineProps<{
    item: any;
    transactions?: any[];
    pagination?: any;
}>();

// Local reactive state (editable)
const transactions = ref<any[]>(props.transactions ?? []);
const pagination = ref<any>(props.pagination ?? {});

// Filters
const filters = ref({
    type: '',
    from: '',
    to: '',
    last_7_days: false,
});

const fetchHistory = async (url: string | null = null) => {
    const response = await axios.get(
        url ?? `/items/${props.item.id}/history/data`,
        { params: filters.value },
    );

    transactions.value = response.data.data;
    pagination.value = response.data.pagination;
};

// Apply filters
const applyFilters = () => {
    fetchHistory();
};

// Initial load
onMounted(() => {
    fetchHistory();
});
</script>

<template>
    <AppLayout>
        <div class="space-y-6 p-6">
            <!-- Item Summary -->
            <div class="rounded bg-gray-500 p-4">
                <h2 class="text-xl font-semibold">{{ item.name }} History</h2>
                <p>Unit: {{ item.unit }}</p>
                <p>Current Stock: {{ item.quantity }}</p>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap gap-4">
                <select v-model="filters.type" class="border p-2">
                    <option value="">All</option>
                    <option value="add">Add</option>
                    <option value="deduct">Deduct</option>
                </select>

                <input type="date" v-model="filters.from" class="border p-2" />
                <input type="date" v-model="filters.to" class="border p-2" />

                <label class="flex items-center gap-2">
                    <input type="checkbox" v-model="filters.last_7_days" />
                    Last 7 days
                </label>

                <button
                    @click="applyFilters"
                    class="rounded bg-blue-600 px-4 py-2 text-white"
                >
                    Apply
                </button>
            </div>

            <!-- History Table -->
            <table class="w-full border">
                <thead class="bg-gray-500">
                    <tr>
                        <th class="border p-2">Date</th>
                        <th class="border p-2">Action</th>
                        <th class="border p-2">Quantity</th>
                        <th class="border p-2">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="tx in transactions" :key="tx.id">
                        <td class="border p-2">{{ tx.created_at }}</td>

                        <td class="border p-2">
                            <span
                                :class="
                                    tx.type === 'add'
                                        ? 'font-semibold text-green-600'
                                        : 'font-semibold text-red-600'
                                "
                            >
                                {{
                                    tx.type === 'add'
                                        ? '➕ Added'
                                        : '➖ Deducted'
                                }}
                            </span>
                        </td>

                        <td class="border p-2">
                            {{ tx.type === 'add' ? '+' : '-' }}{{ tx.quantity }}
                        </td>

                        <td class="border p-2 font-semibold">
                            {{ tx.balance }}
                        </td>
                    </tr>

                    <tr v-if="transactions.length === 0">
                        <td colspan="4" class="p-4 text-center">
                            No history found
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="flex gap-2">
                <button
                    v-for="link in pagination.links"
                    :key="link.label"
                    v-html="link.label"
                    :disabled="!link.url"
                    @click="router.get(link.url)"
                    class="rounded border px-3 py-1"
                    :class="{ 'bg-gray-300': link.active }"
                />
            </div>
        </div>
    </AppLayout>
</template>
