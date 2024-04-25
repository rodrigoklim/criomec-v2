<script setup lang="ts">
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Switcher from "@/Components/SwitcherInput.vue";

defineProps<{
  loading: boolean;
  width?: string;
  title: string;
  recurrence?: "month" | "year";
  type: "free" | "premium";
  nextPayment?: string;
  value?: string;
}>();

const emit = defineEmits<{ (event: "recurrenceChange", value: string): void }>();

const recurrenceChange = (value: boolean) => {
  emit("recurrenceChange", value ? "year" : "month");
};
</script>

<template>
  <div
    class="flex flex-col rounded-lg mt-16 w-[300px]"
    :class="type !== 'free' ? 'shadow-xl z-10 bg-white' : 'shadow-md z-0 -mr-2'"
  >
    <div
      class="rounded-t-lg w-full p-4 text-2xl text-white uppercase text-center"
      :class="type === 'free' ? 'bg-gray-500' : 'bg-primary'"
    >
      {{ title }}
    </div>
    <div v-if="type === 'premium'" class="flex flex-row p-4 justify-end w-full">
      <Switcher class="mr-4" @checked="recurrenceChange" />
      <span class="w-1/4 pl-2">{{ recurrence === "month" ? "mensal" : "anual" }}</span>
    </div>
    <div class="flex flex-col p-6">
      <div class="font-semibold text-2xl mt-6 text-center" :class="type === 'free' ? 'text-secondary' : 'text-primary'">
        R$ <span class="text-4xl">{{ value || "0,00" }}</span>
        <span>&nbsp;/{{ recurrence === "month" ? "Mês" : "Ano" }}</span>
      </div>
      <div class="flex flex-col mt-8 justify-center items-center w-full">
        <SecondaryButton
          :color="type === 'free' ? 'gray-500' : 'primary'"
          width="w-3/4"
          type="button"
          :loading="false"
          @click="$emit('click')"
        >
          Começar Agora
        </SecondaryButton>
      </div>
      <div class="flex flex-col mt-10">
        <div class="font-semibold text-2xl">Assinatura</div>
        <div v-if="recurrence" class="font-regular mt-2 text-sm">
          {{ recurrence === "month" ? "Plano Mensal" : "Plano Anual" }}
        </div>
        <div v-else class="font-regular mt-2 text-sm opacity-0">placeholder</div>
      </div>
      <div class="flex flex-col mt-8">
        <div class="font-semibold text-2xl">Cobrança</div>
        <div class="font-regular mt-2 text-sm">Cartão de Crédito</div>
      </div>
      <div v-if="type !== 'free'" class="flex flex-col mt-8">
        <div class="font-semibold text-2xl">Próximo Pagamento</div>
        <div class="font-regular mt-2 text-sm">10/10/2021</div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
