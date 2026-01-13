<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { StoreItem } from '@/page-routes/create-item'

// Reactive messages
const successMessage = ref('')
const errorMessage = ref('')

// Form state
const form = useForm({
    name: '',
    unit: '',
    quantity: ''
})

// Function to show message and auto clear after 3 seconds
const showMessage = (messageRef: any, message: string) => {
    messageRef.value = message
    setTimeout(() => {
        messageRef.value = ''
    }, 3000) // 3000ms = 3 seconds
}

// Submit function
const submit = () => {
    // reset messages first
    successMessage.value = ''
    errorMessage.value = ''

    form.post(StoreItem(), {
        onSuccess: () => {
            form.reset() // clear form
            showMessage(successMessage, 'Item created successfully!')
        },
        onError: () => {
            showMessage(errorMessage, 'Something went wrong. Please check the form!')
        }
    })
}
</script>

<template>
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h2 class="text-xl font-semibold">
                Welcome to Create Items
            </h2>

            <!-- Success message -->
            <div v-if="successMessage" class="rounded bg-green-100 p-3 text-green-700">
                {{ successMessage }}
            </div>

            <!-- Error message -->
            <div v-if="errorMessage" class="rounded bg-red-100 p-3 text-red-700">
                {{ errorMessage }}
            </div>

            <form
                @submit.prevent="submit"
                class="max-w-md space-y-4 rounded-lg border p-4"
            >
                <!-- Item Name -->
                <div>
                    <label class="block text-sm font-medium">Item Name</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full rounded border p-2"
                    />
                    <div v-if="form.errors.name" class="text-red-500 text-sm">
                        {{ form.errors.name }}
                    </div>
                </div>

                <!-- Unit -->
                <div>
                    <label class="block text-sm font-medium">Unit</label>
                    <select
                        v-model="form.unit"
                        class="w-full rounded border p-2"
                    >
                        <option value="">Select unit</option>
                        <option value="kg">kg</option>
                        <option value="m">m</option>
                        <option value="cm">cm</option>
                        <option value="pcs">pcs</option>
                    </select>
                    <div v-if="form.errors.unit" class="text-red-500 text-sm">
                        {{ form.errors.unit }}
                    </div>
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-medium">Quantity</label>
                    <input
                        v-model="form.quantity"
                        type="number"
                        min="0"
                        class="w-full rounded border p-2"
                    />
                    <div v-if="form.errors.quantity" class="text-red-500 text-sm">
                        {{ form.errors.quantity }}
                    </div>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="rounded bg-black px-4 py-2 text-white"
                    :disabled="form.processing"
                >
                    Save Item
                </button>
            </form>
        </div>
    </AppLayout>
</template>

