<script setup lang="ts">
import { AddressOption } from "@/types/customer";
import { PropType } from "vue";

defineProps({
  options: {
    type: Array as PropType<string[]>,
    required: true,
  },
});

const emit = defineEmits<{
  (event: "select", ncm: string): void;
}>();
</script>

<template>
  <div class="flex flex-col w-full bg-gray-50 rounded-xl mt-2 p-1 border-2 border-primary">
    <div
      v-for="option in options"
      :key="option"
      class="flex my-2 p-2 hover:bg-gray-200 hover:rounded-lg cursor-pointer border-b-2"
      @click="emit('select', option)"
    >
      <span class="text-sm">{{ option }}</span>
    </div>
  </div>
</template>

<style scoped></style>
