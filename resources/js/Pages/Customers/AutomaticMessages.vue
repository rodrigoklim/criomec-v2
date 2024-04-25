<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
</script>

<template>
  <div>
    <Head>
      <title>Clientes</title>
    </Head>
    <AuthenticatedLayout>
      <div class="text-5xl text-center mt-20 p-2">Messages</div>
    </AuthenticatedLayout>
  </div>
</template>

<style scoped></style>
