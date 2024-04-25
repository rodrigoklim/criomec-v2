<script setup lang="ts">
import { onMounted, ref } from "vue";
import { Child } from "../menu";
import { Link } from "@inertiajs/vue3";

const route = ref("");

defineProps<{
  title: string;
  children: Child[];
}>();

onMounted(() => {
  route.value = window.location.pathname;
});
</script>

<template>
  <div>
    <div class="flex font-bold text-xl">
      {{ title }}
    </div>
    <div class="flex flex-col w-full mt-8 space-y-6">
      <Link
        v-for="child in children"
        :key="child.label"
        :href="child.path"
        :class="route === child.path ? 'p-4 bg-secondary rounded-lg text-white' : 'p-4'"
      >
        {{ child.label }}
      </Link>
    </div>
  </div>
</template>

<style scoped></style>
