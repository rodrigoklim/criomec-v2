<script setup lang="ts">
import InputLabel from "@/Components/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SwitcherInput from "@/Components/SwitcherInput.vue";
import TextInput from "@/Components/TextInput.vue";
import { CustomerPj } from "@/types/customer";
import { useForm } from "@inertiajs/vue3";
import { cloneDeep } from "lodash";

const props = defineProps<{
  company: CustomerPj;
}>();

const form = useForm<CustomerPj>({
  ...cloneDeep(props.company),
  ...{
    company_name: props.company.company_name || "",
    email: props.company.email || "",
  },
});

const submit = () => {
  if (!form.ie) {
    form.errors.ie = "Documento é obrigatório";
    return;
  }

  if (!form.company_name) {
    form.errors.company_name = "Nome fantasia é obrigatório";
    return;
  }

  form.post(`/customers/company-data`);
};
</script>

<template>
  <form class="flex flex-col w-full" @submit.prevent="submit">
    <div class="flex flex-col w-full opacity-70 pointer-events-none">
      <InputLabel for="document" value="Documento" />
      <TextInput
        id="document"
        v-model="form.document"
        class="mt-1 block w-full"
        custom-class="bg-gray-50"
        mask="##.###.###/####-##"
        :unmasked-value="true"
        type="text"
        required
        autofocus
        rules="required"
        label="Documento"
      />
    </div>
    <div class="mt-4">
      <InputLabel for="ie" value="Inscrição Estadual" />
      <TextInput
        id="ie"
        v-model="form.ie"
        class="mt-1 block w-full"
        custom-class="bg-gray-50"
        type="text"
        required
        autofocus
        rules="required"
        label="Inscrição Estadual"
      />
    </div>
    <div class="mt-4 opacity-70 pointer-events-none">
      <InputLabel for="corporate_name" value="Razão Social" />
      <TextInput
        id="corporate_name"
        v-model="form.corporate_name"
        class="mt-1 block w-full"
        custom-class="bg-gray-50"
        type="text"
        required
        autofocus
        rules="required"
        label="Razão Social"
      />
    </div>
    <div class="mt-4">
      <InputLabel for="company_name" value="Nome Fantasia" />
      <TextInput
        id="company_name"
        v-model="form.company_name"
        class="mt-1 block w-full"
        custom-class="bg-gray-50"
        type="text"
        required
        rules="required"
        label="Nome Fantasia"
      />
    </div>
    <div class="mt-4">
      <div class="flex flex-row w-full gap-4">
        <div class="flex-none flex-col">
          <InputLabel for="email" value="Deseja receber Nota?" />
          <div class="flex flex-row gap-4 items-center mt-2">
            <SwitcherInput v-model="form.withNF" :value="true" />
            <span>{{ form.withNF ? "Sim" : "Não" }}</span>
          </div>
        </div>
        <div class="flex flex-col w-full">
          <InputLabel for="email" value="Email Fiscal" />
          <TextInput
            id="email"
            v-model="form.email"
            class="mt-1 block w-full"
            custom-class="bg-gray-50"
            type="email"
            label="Email Fiscal"
          />
        </div>
        <div class="flex flex-col w-full opacity-70 pointer-events-none">
          <InputLabel for="status" value="Status" />
          <TextInput
            id="status"
            v-model="form.status"
            class="mt-1 block w-full"
            custom-class="bg-gray-50"
            type="text"
            required
            rules="required"
            label="Status"
          />
        </div>
      </div>
    </div>
    <div class="mt-4">
      <InputLabel for="main_activity" value="Atividade Principal" />
      <TextInput
        id="main_activity"
        v-model="form.main_activity"
        class="mt-1 block w-full"
        custom-class="bg-gray-50"
        type="text"
        required
        rules="required"
        label="Atividade Principal"
      />
    </div>
    <div class="flex flex-row justify-between items-center w-full mt-8">
      <span class="text-negative">{{ form.errors.company_name || form.errors.ie }}</span>
      <secondary-button
        class="bg-primary text-white hover:opacity-70"
        label="Prosseguir"
        :loading="form.processing"
        type="submit"
        width="w-[175px]"
      />
    </div>
  </form>
</template>

<style scoped></style>
