<script lang="ts" setup>
import Checkbox from "../../Components/Checkbox.vue";
import InputLabel from "../../Components/InputLabel.vue";
import TextInput from "../../Components/TextInput.vue";
import GuestLayout from "../../Layouts/GuestLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import AuthCard from "../../Components/AuthCard.vue";
import { Link, Head } from "@inertiajs/vue3";

const errorMessage = ref("");
const form = useForm({
  email: "",
  password: "",
  remember: false,
});

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

const passwordVisibility = ref(false);

watch(
  form,
  () => {
    errorMessage.value = "";
  },
  { deep: true },
);
</script>

<template>
  <GuestLayout>
    <Head>
      <title>Login</title>
    </Head>
    <form class="w-full justify-center flex" @submit.prevent="submit">
      <auth-card
        :error-message="errorMessage || form.errors.email || ''"
        :loading="form.processing"
        primary-btn-title="Login"
        primary-btn-type="submit"
        secondary-btn-title="Não tem uma conta? Cadastre-se!"
        title="Login"
        secondary-link="/register"
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

          <div class="flex flex-row w-full items-center justify-between mt-1">
            <div>
              <Checkbox v-model="form.remember" class="mb-1" :checked="false" />
              <span class="ml-2 text-sm"> Lembrar de mim </span>
            </div>
            <Link class="text-primary text-sm cursor-pointer underline" href="/forgot-password">
              Esqueceu a senha?
            </Link>
          </div>
        </div>
      </auth-card>
    </form>
  </GuestLayout>
</template>

<style scoped></style>
