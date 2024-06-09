<script setup lang="ts">
import InputLabel from "@/Components/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import CreatePage from "@/Pages/Customers/Create/CreatePage.vue";
import { GenericErrorResponse } from "@/types";
import { CustomerPf, CustomerPj } from "@/types/customer";
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps<{
  customer: CustomerPf | CustomerPj;
  error?: GenericErrorResponse;
}>();

const form = useForm({
  document: "",
  birthdate: "",
});

const showBirthdate = ref(false);

const mask = computed(() => (form.document?.length <= 11 ? "###.###.###-###" : "##.###.###/####-##"));

const submit = () => {
  if (![11, 14].includes(form.document.length)) {
    form.errors.document = "Documento inválido";
    return;
  }

  if (form.document.length === 11 && !showBirthdate.value) {
    showBirthdate.value = true;
    return;
  }

  if (form.document.length === 11 && !form.birthdate) {
    form.errors.birthdate = "Data de nascimento é obrigatória";
    return;
  }

  form.post(`/customers/document-validation`);
};
</script>

<template>
  <CreatePage :customer="props.customer">
    <div class="font-semibold text-lg mb-10">Dados da empresa</div>
    <form class="flex w-full" @submit.prevent="submit">
      <div class="flex flex-col w-full gap-4">
        <div class="flex flex-row w-full gap-4" :class="{ 'opacity-70 pointer-events-none': !!props.customer }">
          <div class="flex flex-col w-full">
            <InputLabel for="document" value="Documento" />
            <TextInput
              id="document"
              v-model="form.document"
              class="mt-1 block w-full"
              custom-class="bg-gray-50"
              :mask="mask"
              :unmasked-value="true"
              type="text"
              required
              autofocus
              rules="required"
              label="Documento"
              :error="!!form.errors.document"
              @error-message="(val: string) => (form.errors.document = val)"
              @blur="submit"
              @keyup.enter="submit"
            />
          </div>
          <div v-if="showBirthdate" class="flex flex-col w-full">
            <InputLabel for="birthdate" value="Data de Nascimento" />
            <TextInput
              id="birthdate"
              v-model="form.birthdate"
              class="mt-1 block w-full"
              custom-class="bg-gray-50"
              mask="##/##/####"
              :unmasked-value="true"
              type="text"
              required
              autofocus
              rules="required"
              label="Data de Nascimento"
              :error="!!form.errors.birthdate"
              @error-message="(val: string) => (form.errors.birthdate = val)"
              @blur="submit"
            />
          </div>
        </div>
        <div class="flex flex-row justify-between items-center w-full">
          <span class="text-negative">{{ form.errors.birthdate || form.errors.document }}</span>
          <secondary-button
            class="bg-primary text-white hover:opacity-70"
            label="Prosseguir"
            :loading="form.processing"
            type="submit"
            width="w-[175px]"
          />
        </div>
      </div>
    </form>
  </CreatePage>
</template>

<style scoped></style>
