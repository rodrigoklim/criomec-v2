<script setup lang="ts">
import { Address } from "@/types/customer";
import { PropType, ref } from "vue";

defineProps({
  address: {
    type: Object as PropType<Address>,
    required: true,
  },
});

defineEmits(["edit", "delete"]);

const apiKey = ref(import.meta.env.VITE_API_GOOGLE_MAPS_KEY);
</script>

<template>
  <div class="flex flex-col bg-gray-100 p-4 rounded-2xl mt-4">
    <iframe
      class="rounded-xl"
      width="auto"
      height="250"
      style="border: 0"
      referrerpolicy="no-referrer-when-downgrade"
      :src="`https://www.google.com/maps/embed/v1/place?key=${apiKey}&q=${address.formatted_address}`"
    ></iframe>
    <div class="flex flex-row justify-between items-start mt-4">
      <div class="font-semibold">{{ address.formatted_address }}</div>
      <q-btn class="hover:bg-white rounded-full" @click="$emit('edit')">
        <span class="material-symbols-outlined text-primary text-xl mx-1"> edit </span>
      </q-btn>
      <q-btn class="hover:bg-white rounded-full" @click="$emit('delete')">
        <span class="material-symbols-outlined text-negative text-xl mx-1"> delete </span>
      </q-btn>
    </div>
  </div>
</template>

<style scoped></style>
