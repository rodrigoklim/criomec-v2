<script setup lang="ts">
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { CustomerPj } from "@/types/customer";
import { defineProps, ref } from "vue";

const props = defineProps<{
  company: CustomerPj;
}>();

const form = ref<CustomerPj>(props.company);
</script>

<template>
  <div class="flex flex-col w-full">
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
    <div class="mt-4">
      <InputLabel for="corporate_name" value="Razão Social" />
      <TextInput
        id="corporate_name"
        v-model="form.corporateName"
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
