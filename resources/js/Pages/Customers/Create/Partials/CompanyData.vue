<script setup lang="ts">
import SecondaryButton from "@/Components/SecondaryButton.vue";
import NaturalPerson from "@/Pages/Customers/Create/Partials/Components/NaturalPerson.vue";
import { useCustomerStore } from "@/Pages/Customers/Create/Store/customer-store";
import { CustomerPf, CustomerPj } from "@/types/customer";
import { computed } from "vue";
import DocumentValidation from "../Partials/Components/DocumentValidation.vue";
import LegalEntity from "../Partials/Components/LegalEntity.vue";

const customer = computed(() => customerStore.companyData);
const customerStore = useCustomerStore();

const validateDocument = (document: string, birthdate: string = "") => {
  customerStore.getCompanyData(document, birthdate);
};

const gotoContacts = () => {
  customerStore.setTab("contact");
};
</script>

<template>
  <div>
    <div class="font-semibold text-lg mb-10">Dados da empresa</div>
    <DocumentValidation @documents="validateDocument" />
    <legal-entity
      v-if="customer && customer.type === 'pj'"
      :company="customer as CustomerPj"
      @submit-company="customerStore.setCompanyData"
    />
    <natural-person
      v-if="customer && customer.type === 'pf'"
      :company="customer as CustomerPf"
      @submit-company="customerStore.setCompanyData"
    />
    <div class="flex justify-end mt-4 w-full">
      <secondary-button
        class="bg-primary text-white hover:opacity-70"
        type="button"
        label="Prosseguir"
        @click="gotoContacts"
      />
    </div>
  </div>
</template>

<style scoped></style>
