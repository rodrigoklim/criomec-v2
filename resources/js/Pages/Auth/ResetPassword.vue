<script setup lang="ts">
import AuthCard from "@/Components/AuthCard.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps<{
  email: string;
  token: string;
}>();

const errorMessage = ref("");
const passwordConfirmVisibility = ref(false);
const passwordVisibility = ref(false);

const form = useForm({
  token: props.token,
  email: props.email,
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("password.store"), {
    onFinish: () => {
      form.reset("password", "password_confirmation");
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

          <div class="mt-4">
            <InputLabel for="password" value="Password" />

            <TextInput
              id="password"
              v-model="form.password"
              type="password"
              class="mt-1 block w-full"
              required
              :show-password="passwordVisibility"
              autocomplete="current-password"
              rules="length"
              label="Senha"
              @change-visibility="passwordVisibility = !passwordVisibility"
              @error-message="(val: string) => (errorMessage = val)"
            />
          </div>

          <div class="mt-4">
            <InputLabel for="password" value="Confirme a senha" />

            <TextInput
              id="password"
              v-model="form.password_confirmation"
              type="password"
              class="mt-1 block w-full"
              required
              :show-password="passwordConfirmVisibility"
              autocomplete="current-password"
              rules="length"
              label="Senha"
              @change-visibility="passwordConfirmVisibility = !passwordConfirmVisibility"
              @error-message="(val: string) => (errorMessage = val)"
            />
          </div>
        </div>
      </auth-card>
    </form>
  </GuestLayout>
</template>
