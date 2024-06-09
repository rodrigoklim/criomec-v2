<script lang="ts" setup>
import CreatePage from "@/Pages/Customers/Create/CreatePage.vue";
import NaturalPerson from "@/Pages/Customers/Create/Partials/Components/NaturalPerson.vue";
import { GenericErrorResponse } from "@/types";
import { CustomerPf, CustomerPj } from "@/types/customer";
import { onMounted } from "vue";
import LegalEntity from "../Partials/Components/LegalEntity.vue";

const props = defineProps<{
  customer: CustomerPf | CustomerPj;
  error: GenericErrorResponse;
}>();

onMounted(() => {
  console.log(props.customer);
});
</script>

<template>
  <CreatePage :customer="props.customer">
    <div class="font-semibold text-lg mb-10">Dados da empresa</div>
    <legal-entity v-if="props.customer && props.customer.type === 'pj'" :company="props.customer as CustomerPj" />
    <natural-person v-if="props.customer && props.customer.type === 'pf'" :company="props.customer as CustomerPf" />
  </CreatePage>
</template>

<style scoped></style>
