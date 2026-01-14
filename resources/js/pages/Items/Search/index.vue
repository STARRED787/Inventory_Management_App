<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { HistoryItem } from '@/page-routes/history-item';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';

const goBack = () => {
    router.visit(HistoryItem());
};

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
    if (!props.item?.id) return;

    const endpoint = url ?? `/items/${props.item.id}/history/data`;

    const response = await axios.get(endpoint, {
        params: filters.value,
    });

    transactions.value = response.data.data;
    pagination.value = response.data.pagination;
};

// Apply filters
const applyFilters = () => {
    fetchHistory();
};

// Watch for item prop to be available
watch(
    () => props.item,
    (newItem) => {
        if (newItem?.id) {
            fetchHistory();
        }
    },
    { immediate: true },
);

// Initial load - only if item is already available
onMounted(() => {
    if (props.item?.id) {
        fetchHistory();
    }
});
</script>

<template>
    <AppLayout>
        <div class="space-y-6 p-6"></div>
        <h2>This</h2>
    </AppLayout>
</template>
