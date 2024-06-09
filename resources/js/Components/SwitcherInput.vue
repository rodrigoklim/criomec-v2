<script setup lang="ts">
import { onMounted, ref, watch } from "vue";

const props = defineProps<{
  modelValue: boolean;
}>();

const checked = ref(false);
const emit = defineEmits<{
  (event: "update:modelValue", value: boolean): void;
}>();

watch(
  () => props.modelValue,
  (value) => {
    checked.value = value;
  },
);

watch(checked, (value) => {
  setTimeout(() => {
    emit("update:modelValue", value);
  }, 400);
});

onMounted(() => {
  checked.value = props.modelValue;
});
</script>

<template>
  <div class="flex items-center cursor-pointer" @click.prevent.stop="checked = !checked">
    <div class="relative">
      <div class="w-10 h-4 bg-primary rounded-full shadow-inner" :class="checked ? 'opacity-100' : 'opacity-40'"></div>
      <div
        class="dot absolute w-6 h-6 bg-white rounded-full shadow border -top-1 transition-transform duration-300 ease-in-out"
        :class="checked ? 'transform translate-x-full' : 'transform translate-x-0'"
      />
    </div>
  </div>
</template>

<style scoped></style>
