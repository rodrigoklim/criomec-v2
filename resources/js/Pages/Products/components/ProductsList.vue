<script setup lang="ts">
import IconButton from "@/Components/IconButton.vue";
import { Product } from "@/types/product";
import { Link } from "@inertiajs/vue3";

const props = defineProps<{
  products?: Product[];
}>();

const handleEdit = (productId: number) => {
  Inertia.get();
};
</script>

<template>
  <div class="flex flex-col w-full p-4 rounded-lg bg-white h-[65vh]">
    <div class="flex flex-row w-full text-sm font-semibold justify-between border-b border-b-gray-400">
      <div class="basis-1/12"></div>
      <div class="basis-5/12">Produto</div>
      <div class="basis-2/12">NCM</div>
      <div class="basis-2/12">Operação</div>
      <div class="basis-2/12"></div>
    </div>
    <div v-if="!props.products" class="flex justify-center items-center mt-8">
      <span class="material-symbols-outlined text-4xl mr-6"> sentiment_dissatisfied </span>
      <span>Nenhum produto cadastrado até o momento.</span>
    </div>

    <div v-else class="">
      <template v-for="product in props.products" :key="product.id">
        <div class="flex flex-row w-full py-2 justify-between border-b border-b-gray-400/30 items-center">
          <div class="basis-1/12"></div>
          <div class="basis-5/12">{{ product.name }}</div>
          <div class="basis-2/12">{{ product.ncm }}</div>
          <div class="basis-2/12">{{ product.operation }}</div>
          <div class="basis-2/12">
            <Link :href="route('products.edit', { id: product.id })">
              <IconButton class="mr-4" icon="edit" />
            </Link>
            <IconButton icon="delete" color="negative" />
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<style scoped></style>
