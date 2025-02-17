<script setup lang="ts">
import { computed } from "vue";

const emit = defineEmits(["change"]);

const props = defineProps<{
  checked: boolean;
  value?: string;
}>();

const proxyChecked = computed({
  get() {
    return props.checked;
  },

  set() {
    emit("change", props.value);
  },
});
</script>

<template>
  <input
    v-model="proxyChecked"
    type="checkbox"
    :value="value"
    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 checked:bg-primary"
  />
</template>
