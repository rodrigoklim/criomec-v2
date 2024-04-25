<script setup lang="ts">
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SimpleForm from "@/Components/SimpleForm.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const passwordVisibility = ref([] as boolean[]);

const updatePassword = () => {
  form.put(route("password.update"), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    },
    onError: () => {
      if (form.errors.password) {
        form.reset("password", "password_confirmation");
        passwordInput.value?.focus();
      }
      if (form.errors.current_password) {
        form.reset("current_password");
        currentPasswordInput.value?.focus();
      }
    },
  });
};
</script>

<template>
  <Modal :show="true" max-width="sm">
    <SimpleForm title="Atualizar senha" subtitle="Utilize uma senha longa e aleatória para se manter seguro.">
      <form class="mt-6 space-y-6" @submit.prevent="updatePassword">
        <div>
          <InputLabel for="current_password" value="Senha Atual" />

          <TextInput
            id="current_password"
            ref="currentPasswordInput"
            v-model="form.current_password"
            type="password"
            label="Senha Atual"
            :show-password="passwordVisibility[0]"
            class="mt-1 block w-full"
            autocomplete="current-password"
            @change-visibility="() => (passwordVisibility[0] = !passwordVisibility[0])"
          />

          <InputError :message="form.errors.current_password" class="mt-2" />
        </div>

        <div>
          <InputLabel for="password" value="Nova Senha" />

          <TextInput
            id="password"
            ref="passwordInput"
            v-model="form.password"
            :show-password="passwordVisibility[1]"
            type="password"
            label="Nova Senha"
            class="mt-1 block w-full"
            autocomplete="new-password"
            @change-visibility="() => (passwordVisibility[1] = !passwordVisibility[1])"
          />

          <InputError :message="form.errors.password" class="mt-2" />
        </div>

        <div>
          <InputLabel for="password_confirmation" value="Confirme a senha" />

          <TextInput
            id="password_confirmation"
            v-model="form.password_confirmation"
            :show-password="passwordVisibility[2]"
            type="password"
            label="Confirmar Senha"
            class="mt-1 block w-full"
            autocomplete="new-password"
            @change-visibility="() => (passwordVisibility[2] = !passwordVisibility[2])"
          />

          <InputError :message="form.errors.password_confirmation" class="mt-2" />
        </div>

        <div class="flex items-center justify-center gap-4">
          <PrimaryButton :loading="form.processing" type="submit">Save</PrimaryButton>

          <Transition
            enter-active-class="transition ease-in-out"
            enter-from-class="opacity-0"
            leave-active-class="transition ease-in-out"
            leave-to-class="opacity-0"
          >
            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
          </Transition>
        </div>
      </form>
    </SimpleForm>
  </Modal>
</template>
