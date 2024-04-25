<script setup lang="ts">
import { computed } from "vue";

const props = withDefaults(
  defineProps<{
    type: "submit" | "button" | "reset";
    loading?: boolean;
    width?: string;
    color?: "primary" | "secondary";
    label?: string;
    disabled?: boolean;
  }>(),
  {
    disabled: false,
  },
);

const buttonClasses = computed(() => {
  let classes = ["primary-btn"];
  if (props.width) {
    classes.push(props.width);
  }

  if (props.color && !props.disabled) {
    classes.push(`border-${props.color}`);
    classes.push(`text-${props.color}`);
    classes.push(`hover:bg-${props.color}-100`);
  }

  if (props.disabled) {
    classes = ["pointer-events-none bg-gray-500 text-black"];
  }

  return classes.join(" ");
});
</script>

<template>
  <button class="secondary-btn" :class="buttonClasses" :type="type || 'button'">
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
      <div v-if="label">{{ label }}</div>
      <slot v-else />
    </span>
  </button>
</template>

<style scoped>
.secondary-btn {
  @apply inline-flex items-center px-4 py-2 border-2 h-12;
  @apply justify-center rounded-md font-semibold uppercase;
  @apply transition ease-in-out duration-150;
}
</style>
