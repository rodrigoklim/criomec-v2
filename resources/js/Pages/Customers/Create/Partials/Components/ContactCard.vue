<script setup lang="ts">
defineProps({
  name: String,
  position: String,
  email: String,
  phone: String,
});
</script>

<template>
  <div class="flex flex-col bg-gray-100 p-4 rounded-2xl mt-4">
    <div class="flex flex-row justify-between items-center">
      <div class="font-semibold">{{ name }}</div>
      <q-btn class="hover:bg-white rounded-full">
        <span class="material-symbols-outlined text-negative text-xl mx-1"> delete </span>
      </q-btn>
    </div>
    <div class="text-sm mt-1">{{ position }}</div>
    <div class="flex flex-col mt-4">
      <div class="mt-2 text-sm">{{ email }}</div>
      <div class="mt-2 text-sm">{{ phone }}</div>
    </div>
  </div>
</template>

<style scoped></style>
