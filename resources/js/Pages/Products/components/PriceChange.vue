<script setup lang="ts">
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps<{
  productId?: string;
}>();

const amountRaise = ref("");
const canHover = computed(() => !showInput.value && props.productId);
const form = useForm({ amount_raise: amountRaise.value });
const showInput = ref(false);
const showAlert = ref(false);

const showInputIfAvailable = () => {
  if (props.productId && !showInput.value) {
    showInput.value = !showInput.value;
  }
};

const saveChanges = () => {
  showAlert.value = false;
  form.post(route("products.price-change", { productId: props.productId }));
};
</script>

<template>
  <div
    ref="createButton"
    class="create-button"
    :class="[
      props.productId ? ' bg-primary/70' : 'no-cursor-events bg-gray-500',
      canHover ? 'hover:bg-gray-400 py-[1rem]' : 'py-2',
    ]"
    @click="showInputIfAvailable"
  >
    <div class="flex flex-row items-center w-full">
      <div class="material-symbols-outlined">currency_exchange</div>
      <div class="flex mx-4">Alterar Preço</div>
      <div class="width-transition" :style="[showInput ? 'width: 175px' : 'width: 0']">
        <div v-if="showInput && props.productId" class="flex-grow text-black flex flex-row items-center">
          <TextInput
            id="amountRaise"
            v-model="amountRaise"
            fill-mask="0"
            label="Alterar Preço"
            mask="##.##%"
            rules="required"
            type="text"
            style="border-bottom-right-radius: 0 !important; border-top-right-radius: 0 !important"
            @keydown.esc="showInput = false"
          />
          <div
            class="flex rounded-xl bg-transparent hover:text-primary/70 p-2 ml-4 text-white w-20 justify-center"
            @click="showAlert = true"
          >
            <span v-if="form.processing" class="flex justify-center">
              <svg class="animate-spin h-5 w-5 mr-3 fill-gray-100" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#FFFFFF" stroke-width="4"></circle>
                <path
                  class="opacity-75"
                  fill="#FFFFF"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
              </svg>
            </span>
            <div v-else>
              <span>Salvar</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Modal :show="showAlert" max-width="sm">
      <div class="flex flex-col justify-center items-center p-4">
        <div class="flex items-center gap-4 mt-2">
          <span class="material-symbols-outlined text-yellow-500 text-3xl">warning</span>
          <span class="text-3xl">Atenção!</span>
        </div>
        <div class="text-center mt-8 mb-4">Você está prestes a alterar o preço de um produto em todos os clientes.</div>
        <div class="text-center mt-4 mb-4">Deseja continuar?</div>
        <div class="flex flex-row w-full mt-4 justify-around">
          <div class="flex py-4 px-8 bg-negative rounded-xl text-white cursor-pointer" @click="showAlert = false">
            Não
          </div>
          <div class="flex py-4 px-8 bg-primary rounded-xl text-white cursor-pointer" @click="saveChanges">Sim</div>
        </div>
      </div>
    </Modal>
  </div>
</template>

<style scoped>
.create-button {
  @apply cursor-pointer text-white px-4 flex items-center mr-2;
  @apply rounded;
  @apply flex items-center;
}

.width-transition {
  transition: width 0.5s;
}
</style>
