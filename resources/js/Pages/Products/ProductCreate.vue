<script setup lang="ts">
import BaseNotify from "@/Components/BaseNotify.vue";
import Checkbox from "@/Components/Checkbox.vue";
import GenericRadioGroup from "@/Components/GenericRadioGroup.vue";
import TextInput from "@/Components/TextInput.vue";
import NcmPredictionSelect from "@/Pages/Products/components/NcmPredictionSelect.vue";
import service from "@/Pages/Products/Service";
import { Head, useForm } from "@inertiajs/vue3";
import FormLayout from "@/Layouts/FormLayout.vue";
import { filter, find } from "lodash";
import debounce from "lodash/debounce";
import map from "lodash/map";
import { computed, ref, watch } from "vue";
import { Product, productOperations, ProductUnit, productUnits } from "@/types/product";
import HistoryBox from "./components/HistoryBox.vue";
import PriceChange from "./components/PriceChange.vue";

const props = defineProps<{
  product?: Product;
}>();

const product = ref<Product>(
  props.product || {
    name: "",
    cest: "",
    ncm: "",
    sku: "",
    is_active: "",
    operation: "",
    units: [] as ProductUnit[],
  },
);

const loading = ref(false);
const units = productUnits;
const operation = productOperations;
const canCreateProduct = computed(() => {
  return (
    product.value.name !== "" &&
    product.value.ncm !== "" &&
    product.value.units &&
    product.value.units.length > 0 &&
    product.value.operation !== ""
  );
});

const createProduct = () => {
  try {
    loading.value = true;
    const form = useForm(product.value as Product);

    if (form.id) {
      form.put(route("products.update", { product: form.id }));
      return;
    }
    form.post(route("products.store"));
  } finally {
    loading.value = false;
  }
};

const updateUnit = (value: string) => {
  const unitCheckd = find(product.value.units, (unit: ProductUnit) => unit.unit === value);

  if (unitCheckd) {
    product.value.units = filter(product.value.units, (unit) => unit.unit !== value);
    return;
  }

  return product.value.units.push({ product_id: product.value.id, unit: value });
};

const ncms = ref<string[]>([]);
const isFocused = ref(false);

watch(
  () => product.value.ncm,
  (value) => {
    if (!value) {
      ncms.value = [];
      isFocused.value = false;
      return;
    }

    ncmPrediction(value);
  },
  { deep: true },
);

const ncmPrediction = debounce((ncm) => {
  if (!ncm) {
    return;
  }

  setTimeout(async () => {
    ncms.value = await service.getByNcm(ncm);
  }, 500);
}, 300);

const selectNcm = (ncm: string) => {
  product.value.ncm = ncm;
  ncms.value = [];
  isFocused.value = false;
};

const isUnitChecked = (unitValue: string) => {
  const units = map(product.value.units, (unit: ProductUnit) => unit.unit);
  return units.includes(unitValue);
};
</script>

<template>
  <div>
    <BaseNotify message="Produto criado com sucesso!" variant="positive" />
    <Head>
      <title>Adicionar Produto</title>
    </Head>
    <FormLayout
      :back-route="route('products.index')"
      :loading="loading"
      :disabled="!canCreateProduct"
      :title="`${product.id ? 'Editar' : 'Adicionar um novo'} produto`"
      :is-edit="!!product.id"
      @submit="createProduct"
    >
      <div class="w-full flex flex-row mt-8 flex-grow h-full">
        <div class="w-1/3">
          <HistoryBox :logs="product.logs" />
        </div>
        <div class="grid grid-cols-2 gap-4 border-2 border-primary p-6 rounded-2xl mr-4 bg-white relative w-full">
          <div class="col-span-2">
            <label class="font-semibold ml-1">Produto</label>
            <TextInput v-model="product.name" type="text" label="Produto" rules="required" />
          </div>
          <div class="flex flex-col">
            <div class="mt-4">
              <label class="font-semibold ml-1">Ncm</label>
              <TextInput v-model="product.ncm" type="text" label="NCM" rules="required" @focus="isFocused = true" />
              <transition name="fade">
                <NcmPredictionSelect
                  v-if="ncms.length && isFocused"
                  class="prediction-select"
                  :options="ncms"
                  @select="selectNcm"
                />
              </transition>
            </div>
            <div class="mt-4">
              <label class="font-semibold ml-1">Ean</label>
              <TextInput v-model="product.sku" type="text" label="EAN" rules="required" />
            </div>
            <div class="mt-4">
              <label class="font-semibold ml-1">Cest</label>
              <TextInput v-model="product.cest" type="text" label="CEST" />
            </div>
          </div>
          <div class="flex flex-row w-full gap-12 justify-around pt-6">
            <div class="flex flex-col ml-4">
              <div class="font-semibold ml-1">Unidade</div>
              <div v-for="unit in units" :key="unit.value" class="flex flex-row items-center mt-4 text-sm">
                <Checkbox :checked="isUnitChecked(unit.value)" :value="unit.value" @change="updateUnit" />
                <label class="font-semibold ml-2">{{ unit.text }}</label>
              </div>
            </div>
            <div class="flex flex-col">
              <label class="font-semibold ml-1">Operação</label>
              <GenericRadioGroup v-model="product.operation" :checked="product.operation" :parameters="operation" />
            </div>
          </div>
          <div v-if="product.id" class="flex justify-between mt-4 w-full col-span-2 items-center">
            <PriceChange :product-id="product.id" />
          </div>
        </div>
      </div>
    </FormLayout>
  </div>
</template>

<style scoped>
.prediction-select {
  @apply absolute z-10 w-full;
}
</style>
