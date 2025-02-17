<script setup lang="ts">
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ProductsList from "@/Pages/Products/components/ProductsList.vue";
import { GenericPaginatedResponse } from "@/types";
import { Product } from "@/types/product";
import { Head } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";

const props = defineProps<{
  products?: GenericPaginatedResponse<Product>;
}>();

const loading = ref(false);

const addCustomer = () => {
  window.location.href = route("products.create");
};

onMounted(() => {
  console.log("Products", props.products);
});
</script>

<template>
  <div>
    <Head>
      <title>Produtos</title>
    </Head>
    <AuthenticatedLayout>
      <template #header>
        <div class="flex w-full justify-between items-center">
          <div>
            <div class="font-semibold text-dark text-4xl text-gray-800 leading-tight">Produtos</div>
            <div class="mt-2">Visualizar, adicionar, editar e excluir dados do seu produto.</div>
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
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <ProductsList :products="products?.data" />
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>

<style scoped></style>
