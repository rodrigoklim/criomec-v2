<script setup lang="ts">
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import AuthCard from "@/Components/AuthCard.vue";

const errorMessage = ref("");
const successMessage = ref("");

const form = useForm({
  email: "",
});

const submit = () => {
  if (!form.email) {
    errorMessage.value = "Preencha o seu e-mail";
    return;
  }

  form.post(route("password.email"), {
    onFinish: () => {
      if (form.errors.email) {
        errorMessage.value = "Não conseguimos encontrar um usuário com esse endereço de e-mail.";
      } else {
        successMessage.value = "Email enviado com sucesso! Por favor, verifique sua caixa de entrada.";
      }
    },
  });
};
</script>

<template>
  <GuestLayout>
    <Head>
      <title>Esqueci a Senha</title>
    </Head>
    <form class="w-full justify-center flex" @submit.prevent="submit">
      <auth-card
        :error-message="errorMessage || form.errors.email"
        :success-message="successMessage"
        :loading="form.processing"
        primary-btn-title="Recuperar senha"
        primary-btn-type="submit"
        title="Esqueceu a senha?"
        secondary-link="/forgot-password"
      >
        <div class="p-6">
          <div>
            <InputLabel for="email" value="Email" />
            <TextInput
              id="email"
              v-model="form.email"
              class="mt-1 block w-full"
              type="email"
              required
              autofocus
              autocomplete="username"
              rules="email"
              label="Email"
              @error-message="(val: string) => (errorMessage = val)"
            />
          </div>
          <div class="flex flex-row w-full items-center justify-between mt-1">
            <Link class="text-secondary text-sm cursor-pointer underline" href="/login"> Voltar para login?</Link>
          </div>
        </div>
      </auth-card>
    </form>
  </GuestLayout>
</template>

<style scoped></style>
