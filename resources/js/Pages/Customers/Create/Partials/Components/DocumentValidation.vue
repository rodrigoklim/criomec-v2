<script setup lang="ts">
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useCustomerStore } from "@/Pages/Customers/Create/Store/customer-store";
import { computed, onBeforeMount, onMounted, ref } from "vue";

const customerStore = useCustomerStore();

const errorMessage = ref("");
const document = ref("");
const loading = ref(false);
const birthdate = ref("");
const showBirthdate = ref(false);
const submit = async () => {
  if (customerStore.companyData?.document === document.value) {
    return;
  }

  loading.value = true;
  await customerStore.getCompanyData(document.value, birthdate.value);
  loading.value = false;
};

const mask = computed(() => (document.value?.length <= 11 ? "###.###.###-###" : "##.###.###/####-##"));

onBeforeMount(() => {
  if (!customerStore.companyData) {
    return;
  }

  document.value = customerStore.companyData.document;
  if (customerStore.companyData.type === "pf" && "birthdate" in customerStore.companyData) {
    showBirthdate.value = true;
    birthdate.value = customerStore.companyData.birthdate;
  }
});
</script>

<template>
  <div class="flex flex-row w-full">
    <div class="flex flex-col w-full">
      <InputLabel for="document" value="Documento" />
      <TextInput
        id="document"
        v-model="document"
        class="mt-1 block w-full"
        custom-class="bg-gray-50"
        :mask="mask"
        :unmasked-value="true"
        type="text"
        required
        autofocus
        rules="required"
        label="Documento"
        @error-message="(val: string) => (errorMessage = val)"
        @blur="submit"
        @keyup.enter="submit"
      >
        <template v-if="loading" #append>
          <svg class="animate-spin h-5 w-5 mr-3 fill-primary" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#FFFFFF" stroke-width="4"></circle>
            <path
              class="opacity-75"
              fill="#FFFFF"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            ></path>
          </svg>
        </template>
      </TextInput>
    </div>
    <div v-if="showBirthdate" class="flex flex-col w-full mx-4">
      <InputLabel for="birthdate" value="Data de Nascimento" />
      <TextInput
        id="birthdate"
        v-model="birthdate"
        class="mt-1 block w-full"
        custom-class="bg-gray-50"
        mask="##/##/####"
        :unmasked-value="true"
        type="text"
        required
        autofocus
        rules="required"
        label="Data de Nascimento"
        @error-message="(val: string) => (errorMessage = val)"
        @blur="submit"
      />
    </div>
  </div>
</template>

<style scoped></style>
