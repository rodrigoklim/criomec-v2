<script setup lang="ts">
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";

const loading = ref(false);

const addCustomer = () => {
  window.location.href = route("customers.create");
};
</script>

<template>
  <div>
    <Head>
      <title>Clientes</title>
    </Head>
    <AuthenticatedLayout>
      <template #header>
        <div class="flex w-full justify-between items-center">
          <div>
            <div class="font-semibold text-dark text-4xl text-gray-800 leading-tight">Clientes</div>
            <div class="mt-2">Visualizar, adicionar, editar e excluir dados do seu cliente.</div>
          </div>
          <div>
            <secondary-button
              class="bg-primary text-white"
              type="button"
              :loading="loading"
              label="Adicionar"
              @click="addCustomer"
            />
          </div>
        </div>
      </template>
    </AuthenticatedLayout>
  </div>
</template>

<style scoped></style>
