<script setup lang="ts">
import ContentCard from "@/Components/ContentCard.vue";
import DangerButton from "@/Components/DangerButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UpdateContactInfo from "@/Pages/Profile/Partials/UpdateContactInfo.vue";
import UpdatePaymentInfo from "@/Pages/Profile/Partials/UpdatePaymentInfo.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";
import { User } from "@/types";
import { Plan } from "@/types/plan";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps<{
  fullName: string;
  user: User;
  mustVerifyEmail?: boolean;
  status?: string;
  from?: string;
  plans?: Plan[];
  token?: string;
  clientSecret?: string;
}>();
</script>

<template>
  <div>
    <Head>
      <title>Minha Conta</title>
    </Head>

    <AuthenticatedLayout>
      <template #header>
        <h6 class="text-2xl font-semibold text-gray-800">Minha Conta</h6>
        <span class="text-sm mt-4 text-gray-600"
          >Deixe sua conta segura e controle suas informações pessoais, acessos pelas redes sociais e pagamentos.</span
        >
      </template>
      <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="grid grid-cols-4 gap-4">
            <div class="col-span-3 flex flex-col w-full space-y-6">
              <ContentCard has-header title="Informações Pessoais" to="my-account/edit-personal-info">
                <div class="flex flex-col">
                  <div class="font-semibold text-sm">Nome Completo</div>
                  <div class="font-regular mt-2 text-sm">{{ fullName || "-" }}</div>
                </div>
              </ContentCard>

              <ContentCard has-header title="Informações de Contato" to="my-account/edit-contact-info">
                <div class="flex flex-col">
                  <div class="flex flex-col">
                    <div class="font-semibold text-sm">Email</div>
                    <div class="font-regular mt-2 text-sm">{{ user.email }}</div>
                  </div>
                  <div class="flex flex-col mt-6">
                    <div class="font-semibold text-sm">Celular</div>
                    <div class="font-regular mt-2 text-sm">{{ user.phone || "-" }}</div>
                  </div>
                </div>
              </ContentCard>

              <ContentCard>
                <div class="poppins-semibold flex w-full justify-between items-center">
                  <span class="text-lg">Alterar Senha</span>
                  <Link class="text-primary cursor-pointer" href="my-account/change-password">Editar</Link>
                </div>
              </ContentCard>

              <ContentCard has-header title="Informações sobre Assinatura" to="my-account/edit-payment-info">
                <div class="flex flex-col">
                  <div class="flex flex-col">
                    <div class="font-semibold text-sm">Plano</div>
                    <div class="font-regular mt-2 text-sm">{{ user.email }}</div>
                  </div>
                  <div class="flex flex-col mt-6">
                    <div class="font-semibold text-sm">Histórico de Pagamento</div>
                    <div class="font-regular mt-2 text-sm">{{ user.phone || "-" }}</div>
                  </div>
                </div>
              </ContentCard>

              <ContentCard has-header hide-edit-button title="Apagar conta" to="my-account/delete">
                <div class="flex flex-col">
                  <div class="flex flex-col">
                    <p class="text-sm mb-8">
                      Uma vez que sua conta é apagada, todos os recursos e dados serão permanentemente apagados. Antes
                      de apagar sua conta, por favor, faça o download de qualquer dado ou informação que deseja reter.
                    </p>
                  </div>
                  <Link class="cursor-pointer" href="my-account/delete">
                    <DangerButton>Apagar Conta</DangerButton>
                  </Link>
                </div>
              </ContentCard>
            </div>
            <div class="col-span-1">
              <ContentCard class="w-[60%]">
                <div class="w-full flex flex-col p-6">
                  <span class="material-symbols-outlined text-7xl text-primary"> verified_user </span>
                  <span class="text-lg mt-4 poppins-semibold">Informações Pessoais</span>
                  <span class="poppins-regular flex w-full mt-4">
                    O dados são particulares e sigilosos. Ocultamos alguns dados da conta para proteger sua identidade.
                  </span>

                  {{ from }}
                </div>
              </ContentCard>
            </div>
          </div>
        </div>
      </div>
      <DeleteUserForm v-if="from === 'delete'" />
      <UpdatePasswordForm v-if="from === 'change-password'" />
      <UpdateContactInfo v-if="from === 'edit-contact-info'" />
      <UpdateProfileInformationForm v-if="from === 'edit-personal-info'" />
      <UpdatePaymentInfo v-if="from === 'edit-payment-info'" :plans="plans" />
    </AuthenticatedLayout>
  </div>
</template>
