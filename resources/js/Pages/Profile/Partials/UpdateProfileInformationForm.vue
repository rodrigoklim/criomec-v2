<script setup lang="ts">
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SimpleForm from "@/Components/SimpleForm.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm, usePage } from "@inertiajs/vue3";

defineProps<{
  mustVerifyEmail?: boolean;
  status?: string;
}>();

const user = usePage().props.auth.user;

const form = useForm({
  name: user.name,
  last_name: user.last_name,
});
</script>

<template>
  <Modal :show="true" max-width="sm">
    <SimpleForm title="Informações Pessoais" subtitle="Atualize seu nome e sobrenome.">
      <form class="mt-6 space-y-6" @submit.prevent="form.patch(route('profile.update'))">
        <div>
          <InputLabel for="name" value="Nome" />

          <TextInput
            id="name"
            v-model="form.name"
            type="text"
            class="mt-1 block w-full"
            label="Nome"
            required
            autofocus
            autocomplete="name"
          />
        </div>

        <div>
          <InputLabel for="email" value="Sobrenome" />

          <TextInput
            id="email"
            v-model="form.last_name"
            type="text"
            class="mt-1 block w-full"
            label="Sobrenome"
            required
            autocomplete="username"
          />
        </div>

        <div>
          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="flex items-center gap-4 justify-center">
          <PrimaryButton type="submit" :loading="form.processing">Salvar</PrimaryButton>

          <Transition
            enter-active-class="transition ease-in-out"
            enter-from-class="opacity-0"
            leave-active-class="transition ease-in-out"
            leave-to-class="opacity-0"
          >
            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Salvo</p>
          </Transition>
        </div>
      </form>
    </SimpleForm>
  </Modal>
</template>
