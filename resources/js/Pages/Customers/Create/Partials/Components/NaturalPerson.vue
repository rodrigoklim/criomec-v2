<script setup lang="ts">
import InputLabel from "@/Components/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { CustomerPf } from "@/types/customer";
import { useForm } from "@inertiajs/vue3";

const props = defineProps<{
  company: CustomerPf;
}>();

const form = useForm<CustomerPf>(props.company);
</script>

<template>
  <form class="flex flex-col w-full" method="post" :action="`/customers/company-data/`">
    <div class="mt-4">
      <InputLabel for="name" value="Nome" />
      <TextInput
        id="name"
        v-model="form.name"
        class="mt-1 block w-full"
        custom-class="bg-gray-50"
        type="text"
        required
        autofocus
        rules="required"
        label="Nome"
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
        <div class="flex flex-col w-full">
          <InputLabel for="email" value="Email Fiscal" />
          <TextInput
            id="email"
            v-model="form.email"
            class="mt-1 block w-full"
            custom-class="bg-gray-50"
            type="email"
            required
            rules="required"
            label="Email Fiscal"
          />
        </div>
        <div class="flex flex-col w-full">
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
    <div class="flex justify-end mt-8 w-full">
      <secondary-button
        class="bg-primary text-white hover:opacity-70"
        label="Prosseguir"
        type="submit"
        width="w-[175px]"
      />
    </div>
  </form>
</template>

<style scoped></style>
