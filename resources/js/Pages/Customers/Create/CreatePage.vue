<script lang="ts" setup>
import Form from "@/Layouts/FormLayout.vue";
import { createCustomerMenu } from "@/Pages/Customers/Create/create-customer";
import CompanyAddresses from "@/Pages/Customers/Create/Partials/CompanyAddresses.vue";
import CompanyContacts from "@/Pages/Customers/Create/Partials/CompanyContacts.vue";
import CompanyData from "@/Pages/Customers/Create/Partials/CompanyData.vue";
import CompanyPayment from "@/Pages/Customers/Create/Partials/CompanyPayment.vue";
import CompanyProducts from "@/Pages/Customers/Create/Partials/CompanyProducts.vue";
import { useCustomerStore } from "@/Pages/Customers/Create/Store/customer-store";
import { Head } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";

const customerStore = useCustomerStore();

const selected = ref("test");
const loading = ref(false);
const showTooltip = ref(false);
const step = computed(() => customerStore.step);

onMounted(() => {
  selected.value = window.location.pathname.split("/")[3];
});
</script>

<template>
  <div>
    <Head>
      <title>Adicionar Clientes</title>
    </Head>
    <Form :back-route="route('customers.index')" :disabled="true" :loading="loading" title="Adicionar um novo cliente">
      <div class="w-full flex flex-row mt-8">
        <div class="w-1/4">
          <div class="flex flex-col border-2 border-primary p-6 rounded-2xl mr-4 bg-white">
            <div class="font-semibold text-lg">Cadastro de cliente</div>
            <div
              v-for="item in createCustomerMenu"
              :key="item.slug"
              :class="step === item.slug ? 'selected' : 'not-selected'"
              class="guide-list"
              @click="customerStore.setTab(item.slug)"
            >
              {{ item.label }}
            </div>
          </div>
        </div>
        <div class="w-3/4">
          <div class="flex flex-col border-2 border-primary p-6 rounded-2xl mr-4 bg-white relative">
            <q-btn class="absolute right-6" round @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
              <span class="material-symbols-outlined ml-1 text-primary text-3xl hover:opacity-70"> info </span>
            </q-btn>
            <transition mode="out-in" name="fade">
              <span
                v-if="showTooltip"
                class="absolute right-0 -top-6 tooltip whitespace-nowrap bg-gray-600 text-white text-lg py-2 px-4 left-16 rounded-md ml-2 z-10 w-[43%]"
              >
                Tudo certo, já pode adicionar o seu cliente!
              </span>
            </transition>
            <company-data v-if="step === 'company-data'" />
            <company-contacts v-if="step === 'contact'" />
            <company-products v-if="step === 'products'" />
            <company-addresses v-if="step === 'address'" />
            <company-payment v-if="step === 'payment'" />
          </div>
        </div>
      </div>
    </Form>
  </div>
</template>

<style scoped>
.not-selected {
  @apply hover:bg-primary hover:opacity-60 hover:text-white;
}

.selected {
  @apply bg-primary text-white;
}

.guide-list {
  @apply transition-all duration-150 ease-in-out mt-4 cursor-pointer rounded-lg p-2;
}

.tooltip {
  transform: translateX(calc(100% + 30px));
}
</style>
