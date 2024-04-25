<script setup lang="ts">
import { ref, watch } from "vue";

const checked = ref(false);
const emit = defineEmits<{
  (event: "checked", value: boolean): void;
}>();

watch(checked, (value) => {
  setTimeout(() => {
    emit("checked", value);
  }, 400);
});
</script>

<template>
  <div class="flex items-center cursor-pointer" @click.prevent.stop="checked = !checked">
    <div class="relative">
      <div class="w-10 h-4 bg-primary opacity-40 rounded-full shadow-inner"></div>
      <div
        class="dot absolute w-6 h-6 bg-white rounded-full shadow border -top-1 transition-transform duration-300 ease-in-out"
        :style="checked ? 'transform: translateX(100%);' : 'transform: translateX(0);'"
      />
    </div>
  </div>
</template>

<style scoped></style>
