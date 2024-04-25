<script setup lang="ts">
import PrimaryButton from "./PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";

defineProps<{
  primaryBtnTitle: string;
  secondaryBtnTitle?: string;
  errorMessage: string;
  successMessage?: string;
  loading: boolean;
  title: string;
  secondaryLink?: string;
  primaryBtnType: "submit" | "button";
}>();
</script>

<template>
  <div class="w-1/2 rounded-xl bg-white">
    <div class="p-6 rounded-t-xl full flex items-center border-2 border-b-primary">
      <div class="text-2xl blacker-extrabold uppercase text-primary">
        {{ title }}
      </div>
    </div>

    <slot />

    <div class="mb-8 mx-4">
      <div v-if="successMessage" class="text-positive text-center text-sm">
        {{ successMessage }}
      </div>
      <div v-else class="text-negative text-center text-sm" :class="{ 'opacity-0': !errorMessage }">
        {{ errorMessage || "placeholder" }}
      </div>
    </div>

    <div class="flex flex-col justify-center mb-4">
      <primary-button :loading="loading" class="mx-auto" :type="primaryBtnType" color="primary" width="w-1/2">
        {{ primaryBtnTitle }}
      </primary-button>
      <Link v-if="secondaryBtnTitle" :href="secondaryLink || ''" class="w-full items-center text-center mt-2 mb-4">
        <span class="text-primary text-sm cursor-pointer underline" @click="$emit('secondaryBtnClick')">
          {{ secondaryBtnTitle }}
        </span>
      </Link>
    </div>
  </div>
</template>

<style scoped></style>
