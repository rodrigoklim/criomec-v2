<script setup lang="ts">
import { computed } from "vue";

const props = defineProps<{
  type: "submit" | "button" | "reset";
  loading: boolean;
  width?: string;
  color?: "primary" | "secondary";
}>();

const buttonClasses = computed(() => {
  const classes = ["primary-btn"];
  if (props.width) {
    classes.push(props.width);
  }

  if (props.color) {
    classes.push(`bg-${props.color}`);
  }
  return classes.join(" ");
});
</script>

<template>
  <button class="primary-btn" :class="buttonClasses" :type="type || 'button'">
    <span v-if="loading" class="flex justify-center">
      <svg class="animate-spin h-5 w-5 mr-3 fill-gray-100" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#FFFFFF" stroke-width="4"></circle>
        <path
          class="opacity-75"
          fill="#FFFFF"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
      </svg>
    </span>
    <span v-else>
      <slot />
    </span>
  </button>
</template>

<style scoped>
.primary-btn {
  @apply w-1/2 inline-flex items-center px-4 py-2 bg-primary border border-transparent h-12;
  @apply justify-center rounded-md font-semibold text-white uppercase;
  @apply hover:opacity-70 transition ease-in-out duration-150;
}
</style>
