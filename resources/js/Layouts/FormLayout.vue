<script setup lang="ts">
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps<{
  loading: boolean;
  backRoute: string;
  title: string;
  disabled?: boolean;
}>();

const goBack = () => {
  window.location.href = props.backRoute;
};

const emit = defineEmits<{
  (event: "submit"): void;
}>();
</script>

<template>
  <div class="flex flex-col w-full max-h-screen overflow-y-auto">
    <div class="flex max-w-7xl w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <form class="flex w-full flex-col justify-center flex" @submit.prevent="emit('submit')">
        <div class="flex flex-row w-full justify-end">
          <secondary-button class="mr-4 hover:bg-white" type="button" label="Fechar" @click="goBack" />
          <secondary-button
            class="hover:opacity-80 text-white"
            :class="{ 'bg-primary': !props.disabled }"
            type="button"
            :loading="props.loading"
            :disabled="props.disabled"
            label="Adicionar"
            @click="emit('submit')"
          />
        </div>
        <div class="flex flex-col w-full mt-8">
          <div class="text-4xl font-bold">
            {{ title }}
          </div>
          <slot class="mt-8" />
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped></style>
