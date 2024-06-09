<script setup lang="ts">
import { emailValidation, lengthValidation, requiredValidation } from "@/Composables/validation";
import { ref, watch } from "vue";

const props = defineProps<{
  customClass?: string;
  mask?: string;
  label: string;
  type: "text" | "password" | "email";
  showPassword?: boolean;
  rules?: "required" | "email" | "phone" | "length";
  unmaskedValue?: boolean;
  error?: boolean;
  autocomplete?: string;
}>();

const emit = defineEmits<{
  (e: "change-visibility"): void;
  (e: "error-message", message: string): void;
  (e: "blur"): void;
  (e: "focus"): void;
}>();

const model = defineModel<string | undefined>({ required: true });
const hasError = ref(false);
const input = ref<HTMLInputElement | null>(null);

defineExpose({ focus: () => input.value?.focus() });

const validateField = (rule: string) => {
  if (model.value === undefined) {
    model.value = "";
  }

  switch (rule) {
    case "required": {
      requiredValidation(model.value, props.label, showErrorMessage);
      break;
    }

    case "email": {
      emailValidation(model.value, props.label, showErrorMessage);
      break;
    }

    case "length": {
      lengthValidation(model.value, props.label, 8, showErrorMessage);
      break;
    }
  }
};

const onBlur = () => {
  if (!props.rules) {
    return;
  }

  validateField(props.rules);
  emit("blur");
};

const showErrorMessage = (message: string) => {
  hasError.value = true;
  emit("error-message", message);
};

watch(model, () => {
  hasError.value = false;
  emit("error-message", "");
});

watch(
  () => props.error,
  (value) => {
    hasError.value = value;
  },
  { deep: true },
);
</script>

<template>
  <div class="flex flex-row items-center w-full">
    <q-input
      v-if="props.mask"
      ref="input"
      v-model="model"
      :mask="props.mask"
      :unmasked-value="unmaskedValue"
      class="w-full rounded-md focus:ring-primary focus:ring-2 focus:border-opacity-0"
      input-class="flex w-full border-gray-300 rounded-md shadow-sm"
      :class="[{ 'ring-2 ring-red-400': hasError }, props.customClass]"
      :type="props.showPassword ? 'text' : props.type"
      :autocomplete="autocomplete"
      @blur="onBlur"
      @focus="emit('focus')"
    />
    <input
      v-else
      ref="input"
      v-model="model"
      class="border-gray-300 w-full focus:ring-primary focus:ring-2 focus:border-opacity-0 rounded-md shadow-sm"
      :class="[{ 'ring-2 ring-red-400': hasError }, props.customClass]"
      :autocomplete="autocomplete"
      :type="props.showPassword ? 'text' : props.type"
      @blur="onBlur"
      @focus="emit('focus')"
    />
    <span
      v-if="type === 'password'"
      class="-ml-8 cursor-pointer material-symbols-outlined"
      @click="$emit('change-visibility')"
    >
      {{ props.showPassword ? "visibility_off" : "visibility" }}
    </span>
    <span class="-ml-8">
      <slot name="append" />
    </span>
  </div>
</template>
