<script lang="ts" setup>
import { Link } from "@inertiajs/vue3";

defineProps<{
  hasHeader?: boolean;
  hideEditButton?: boolean;
  title?: string;
  to?: string;
}>();
</script>

<template>
  <div class="flex flex-col w-full rounded-lg shadow bg-white">
    <template v-if="hasHeader">
      <div class="poppins-semibold p-6 flex w-full justify-between items-center">
        <span class="text-lg">{{ title }}</span>
        <Link v-if="!hideEditButton" class="text-primary cursor-pointer" :href="to">Editar</Link>
      </div>
      <div class="poppins-regular p-6 flex w-full justify-between border-t border-gray-200">
        <slot></slot>
      </div>
    </template>
    <div v-else class="p-6 flex w-full justify-between items-center">
      <slot></slot>
    </div>
  </div>
</template>

<style scoped></style>
