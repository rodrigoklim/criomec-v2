<script setup lang="ts">
import { GenericObject } from "@/types";
import { computed } from "vue";

const props = defineProps<{
  parameters: GenericObject[];
  title?: string;
  modelValue?: string;
}>();

const emit = defineEmits<{
  (event: "select", id: string): void;
  (event: "update:modelValue", value: string): void;
}>();

const selectedValue = computed({
  get: () => props.modelValue || "",
  set: (value: string) => {
    emit("update:modelValue", value);
  },
});
</script>

<template>
  <div>
    <div v-if="title" class="flex mt-8 underline">{{ title }}</div>
    <div class="flex flex-col mt-2">
      <div v-for="parameter in props.parameters" :key="parameter.value" class="flex flex-row items-center gap-4 my-2">
        <input
          id="payment_term"
          v-model="selectedValue"
          type="radio"
          :value="parameter.value"
          @change="() => emit('select', parameter.value)"
        />
        <label for="payment_term" class="text-sm font-semibold">{{ parameter.label }}</label>
      </div>
    </div>
  </div>
</template>
