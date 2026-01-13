<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import { StoreItem } from '@/page-routes/create-item'

// Form state
const form = useForm({
  name: '',
  unit: '',
  quantity: ''
})

// Define reactive flash messages
interface FlashProps {
  success?: string
  error?: string
}

const page = usePage()
const flash = ref<FlashProps>({
  success: (page.props.flash as FlashProps)?.success,
  error: (page.props.flash as FlashProps)?.error
})

// Auto-clear flash messages after 3 seconds
watch(() => flash.value.success, (msg) => {
  if (msg) setTimeout(() => flash.value.success = undefined, 3000)
})

watch(() => flash.value.error, (msg) => {
  if (msg) setTimeout(() => flash.value.error = undefined, 3000)
})

// Submit function
const submit = () => {
  form.post(StoreItem(), {
    onSuccess: (response) => {
      form.reset() // clear form after success

      // Update local flash from server response if available
      flash.value.success = (response.props.flash as FlashProps)?.success
      flash.value.error = (response.props.flash as FlashProps)?.error
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

      <!-- Success -->
      <div v-if="flash.success" class="bg-green-100 p-3 text-green-700 rounded">
        {{ flash.success }}
      </div>

      <!-- Error -->
      <div v-if="flash.error" class="bg-red-100 p-3 text-red-700 rounded">
        {{ flash.error }}
      </div>

      <form @submit.prevent="submit" class="max-w-md space-y-4 rounded-lg border p-4">
        <!-- Item Name -->
        <div>
          <label class="block text-sm font-medium">Item Name</label>
          <input v-model="form.name" type="text" class="w-full rounded border p-2" />
          <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
        </div>

        <!-- Unit -->
        <div>
          <label class="block text-sm font-medium">Unit</label>
          <select v-model="form.unit" class="w-full rounded border p-2">
            <option value="">Select unit</option>
            <option value="kg">kg</option>
            <option value="m">m</option>
            <option value="cm">cm</option>
            <option value="pcs">pcs</option>
          </select>
          <div v-if="form.errors.unit" class="text-red-500 text-sm">{{ form.errors.unit }}</div>
        </div>

        <!-- Quantity -->
        <div>
          <label class="block text-sm font-medium">Quantity</label>
          <input v-model="form.quantity" type="number" min="0" class="w-full rounded border p-2" />
          <div v-if="form.errors.quantity" class="text-red-500 text-sm">{{ form.errors.quantity }}</div>
        </div>

        <!-- Submit -->
        <button type="submit" class="rounded bg-black px-4 py-2 text-white" :disabled="form.processing">
          Save Item
        </button>
      </form>
    </div>
  </AppLayout>
</template>
