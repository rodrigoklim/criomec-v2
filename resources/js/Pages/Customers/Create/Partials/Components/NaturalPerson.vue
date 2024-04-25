<script setup lang="ts">
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { CustomerPf } from "@/types/customer";
import { defineProps, ref } from "vue";

const props = defineProps<{
  company: CustomerPf;
}>();

const form = ref<CustomerPf>(props.company);
</script>

<template>
  <div class="flex flex-col w-full">
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
        v-model="form.companyName"
        class="mt-1 block w-full"
        custom-class="bg-gray-50"
        type="text"
        required
        rules="required"
        label="Nome Fantasia"
      />
    </div>
    <div class="mt-4">
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
    <div class="mt-4">
      <InputLabel for="main_activity" value="Atividade Principal" />
      <TextInput
        id="main_activity"
        v-model="form.mainActivity"
        class="mt-1 block w-full"
        custom-class="bg-gray-50"
        type="text"
        required
        rules="required"
        label="Atividade Principal"
      />
    </div>
  </div>
</template>

<style scoped></style>
