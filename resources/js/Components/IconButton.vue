<script setup lang="ts">
const props = defineProps<{
  icon: string;
  color?: string;
  backgroundColor?: string;
  loading?: boolean;
}>();

defineEmits(["click"]);
</script>

<template>
  <div
    class="rounded-full cursor-pointer py-1 px-2 inline-flex hover:bg-gray-200"
    :class="`text-${props.color || 'primary'}`"
    @click="$emit('click')"
  >
    <span class="material-symbols-outlined text-xl"> {{ props.icon }} </span>
  </div>
</template>
