<script setup lang="ts">
defineProps<{
  title: string;
  subtitle?: string;
}>();

const goBack = () => {
  window.history.back();
};
</script>

<template>
  <section class="flex flex-col p-6 border border-gray-300 bg-white justify-center w-full rounded-lg">
    <div class="flex justify-between items-top">
      <div class="font-semibold text-lg">
        {{ title }}
      </div>
      <span class="text-primary cursor-pointer material-symbols-outlined" @click="goBack">close</span>
    </div>
    <div class="flex w-3/4 mt-2">
      <span class="text-sm">{{ subtitle }}</span>
    </div>

    <div class="flex w-full justify-center">
      <slot />
    </div>
  </section>
</template>

<style scoped></style>
