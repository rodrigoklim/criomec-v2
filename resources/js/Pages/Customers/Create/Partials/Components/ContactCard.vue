<script setup lang="ts">
const props = withDefaults(
  defineProps<{
    name: string;
    position: string;
    email: string;
    phone: string;
  }>(),
  {
    name: "",
    position: "",
    email: "",
    phone: "",
  },
);
</script>

<template>
  <div class="flex flex-col bg-gray-100 p-4 rounded-2xl mt-4">
    <div class="flex flex-row justify-between items-start">
      <div class="font-semibold">{{ props.name }}</div>
      <q-btn class="hover:bg-white rounded-full" @click="$emit('edit')">
        <span class="material-symbols-outlined text-primary text-xl mx-1"> edit </span>
      </q-btn>
      <q-btn class="hover:bg-white rounded-full" @click="$emit('delete')">
        <span class="material-symbols-outlined text-negative text-xl mx-1"> delete </span>
      </q-btn>
    </div>
    <div class="text-sm mt-1">{{ props.position }}</div>
    <div class="flex flex-col mt-4">
      <div class="mt-2 text-sm overflow-hidden overflow-ellipsis">{{ props.email }}</div>
      <div class="mt-2 text-sm">{{ props.phone }}</div>
    </div>
  </div>
</template>

<style scoped></style>
