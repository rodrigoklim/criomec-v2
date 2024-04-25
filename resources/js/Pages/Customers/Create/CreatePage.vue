<script setup lang="ts">
import Form from "@/Layouts/FormLayout.vue";
import { createCustomerMenu } from "@/Pages/Customers/Create/create-customer";
import AddContact from "@/Pages/Customers/Create/Partials/AddContact.vue";
import CompanyData from "@/Pages/Customers/Create/Partials/CompanyData.vue";
import { useCustomerStore } from "@/Pages/Customers/Create/Store/customer-store";
import { Head, useForm, Link } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";

const customerStore = useCustomerStore();

const errorMessage = ref("");
const selected = ref("test");
const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const step = computed(() => customerStore.step);

const submit = () => {
  if (!form.email || !form.password) {
    errorMessage.value = "Preencha todos os campos";
    return;
  }

  form.post(route("login"), {
    onFinish: () => {
      form.reset("password");
    },
  });
};

onMounted(() => {
  selected.value = window.location.pathname.split("/")[3];
});
</script>

<template>
  <div>
    <Head>
      <title>Adicionar Clientes</title>
    </Head>
    <Form
      :back-route="route('customers.index')"
      :loading="useForm.processing"
      :disabled="true"
      title="Adicionar um novo cliente"
    >
      <div class="w-full flex flex-row mt-8">
        <div class="w-1/4">
          <div class="flex flex-col border-2 border-primary p-6 rounded-2xl mr-4 bg-white">
            <div class="font-semibold text-lg">Cadastro de cliente</div>
            <div
              v-for="item in createCustomerMenu"
              :key="item.slug"
              class="guide-list"
              :class="step === item.slug ? 'selected' : 'not-selected'"
              @click="customerStore.setTab(item.slug)"
            >
              {{ item.label }}
            </div>
          </div>
        </div>
        <div class="w-3/4">
          <div class="flex flex-col border-2 border-primary p-6 rounded-2xl mr-4 bg-white">
            <company-data v-if="step === 'company-data'" />
            <add-contact v-if="step === 'contact'" />
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
</style>
