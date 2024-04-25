<script setup lang="ts">
import ContactCard from "@/Pages/Customers/Create/Partials/Components/ContactCard.vue";
</script>

<template>
  <div class="flex flex-col w-full">
    <div class="font-semibold text-lg">Contato</div>
    <div class="font-regular mt-8 underline">Contatos cadastrados</div>
    <div class="grid grid-cols-4 gap-4 mt-4">
      <contact-card name="Nome" position="Cargo" phone="(13)99203-0290" email="rodrigo@teste.com" />
    </div>
  </div>
</template>

<style scoped></style>
