<script setup lang="ts">
defineProps<{
  message: string;
  variant: "positive" | "negative" | "warning" | "info";
}>();
</script>

<template>
  <div class="flex flex-row items-center w-[17%] rounded-lg p-4 absolute top-20 right-2" :class="variant">
    <span class="material-symbols-outlined mr-4 border-2 rounded-full border-white p-1"> check </span>
    <span>{{ message }}</span>
  </div>
</template>

<style scoped>
.positive {
  @apply bg-positive text-positive bg-opacity-20 font-semibold;
}

.negative {
  @apply bg-negative text-negative bg-opacity-20 font-semibold;
}

.warning {
  @apply bg-warning text-warning bg-opacity-20 font-semibold;
}

.info {
  @apply bg-info text-info bg-opacity-20 font-semibold;
}
</style>
