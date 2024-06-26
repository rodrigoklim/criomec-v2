<script setup lang="ts">
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import CreatePage from "@/Pages/Customers/Create/CreatePage.vue";
import ContactCard from "@/Pages/Customers/Create/Partials/Components/ContactCard.vue";
import { Contact, CustomerPf, CustomerPj } from "@/types/customer";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps<{
  customer: CustomerPf | CustomerPj;
  step: string;
  contacts?: Contact[];
}>();

const contacts = ref<Contact[]>(props.customer.contacts || []);
const contact = ref<Contact>({
  name: "",
  position: "",
  phone: "",
  email: "",
  customer_id: props.customer.id!,
});

const addContact = () => {
  contacts.value.push({ ...contact.value });
  contact.value = {
    name: "",
    position: "",
    phone: "",
    email: "",
    customer_id: props.customer.id!,
  };
};

const editContact = (person: Contact) => {
  contact.value = { ...person };
  contacts.value = contacts.value.filter((item) => item.email !== person.email);
};

const deleteContact = (person: Contact) => {
  contacts.value = contacts.value.filter((item) => item.email !== person.email);
};

const loading = ref(false);
const submit = () => {
  loading.value = true;
  const form = useForm({
    contacts: contacts.value,
  });

  form.post(route("customers.contact", { id: props.customer.id }));
  loading.value = false;
};
</script>

<template>
  <CreatePage :customer="props.customer" :step="props.step">
    <form class="flex flex-col w-full" @submit.prevent="submit">
      <div class="flex flex-col w-full">
        <div class="font-semibold text-lg">Contato</div>
        <div class="flex flex-row">
          <div class="flex flex-col text-sm mt-8">
            <div class="">
              <label for="name" class="font-semibold mr-4">Nome</label>
              <TextInput id="phone" v-model="contact.name" type="text" label="Nome" rules="required" />
            </div>
            <div class="mt-4">
              <label for="position" class="font-semibold mr-4">Cargo</label>
              <TextInput id="phone" v-model="contact.position" type="text" label="Cargo" rules="required" />
            </div>
          </div>
          <div class="flex flex-col text-sm mt-8 ml-6">
            <div>
              <label for="name" class="font-semibold mr-4">Email</label>
              <TextInput id="phone" v-model="contact.email" type="text" label="Email" rules="email" />
            </div>
            <div class="mt-4">
              <label for="position" class="font-semibold mr-4">Telefone</label>
              <TextInput
                id="phone"
                v-model="contact.phone"
                type="text"
                label="Telefone"
                mask="(##) #####-####"
                rules="phone"
              />
            </div>
          </div>
        </div>
        <SecondaryButton class="mt-8 w-1/4" type="button" color="primary" label="Adicionar" @click="addContact" />
        <div v-if="contacts.length > 0" class="font-regular mt-8 italic">Contatos cadastrados</div>
        <div class="grid grid-cols-3 gap-4 mt-4">
          <contact-card
            v-for="person in contacts"
            :key="person.email"
            :name="person.name"
            :position="person.position"
            :phone="person.phone"
            :email="person.email"
            @edit="editContact(person)"
            @delete="deleteContact(person)"
          />
        </div>
        <div v-if="contacts.length" class="flex justify-end mt-4 w-full">
          <secondary-button
            class="bg-primary text-white hover:opacity-70"
            type="submit"
            label="Salvar"
            width="w-[175px]"
            :loading="loading"
          />
        </div>
      </div>
    </form>
  </CreatePage>
</template>

<style scoped></style>
