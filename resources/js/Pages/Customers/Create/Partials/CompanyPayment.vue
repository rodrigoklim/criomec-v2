<script setup lang="ts">
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import CreatePage from "@/Pages/Customers/Create/CreatePage.vue";
import {
  bankAccounts,
  paymentTerms,
  cashPayment,
  installmentsPayment,
} from "@/Pages/Customers/Create/Partials/Components/company-payment";
import GenericRadioGroup from "@/Components/GenericRadioGroup.vue";
import { GenericObject } from "@/types";
import { CompanyPaymentResponse, CustomerPf, CustomerPj, Payment, PaymentDetails } from "@/types/customer";
import { useForm } from "@inertiajs/vue3";
import { computed, onMounted, ref, watch } from "vue";

interface PaymentParameters {
  upfront: GenericObject[];
  cash: GenericObject[];
}

interface PaymentTitles {
  upfront: string;
  cash: string;
  installments: string;
}

const props = defineProps<{
  customer: CustomerPf | CustomerPj;
  step: string;
  customerPayment?: CompanyPaymentResponse;
}>();

const mapPaymentResponse = (paymentResponse: CompanyPaymentResponse) => {
  console.log(paymentResponse);
  switch (paymentResponse.type) {
    // case "installments":
    //   response.parameters = paymentResponse.parameters;
    //   response.details = {
    //     bank: paymentResponse.details.bank,
    //     installments: paymentResponse.details.installments,
    //     contract_number: paymentResponse.details.contract_number,
    //     due_date: paymentResponse.details.due_date,
    //   };
    //   break;
    // case "cash":
    //   response.parameters = paymentResponse.parameters;
    //   break;
    case "cash":
    case "upfront":
      payment.value.type = paymentResponse.type;
      paymentTerm.value = paymentResponse.type;
      payment.value.parameters =
        paymentResponse.type === "upfront" ? paymentResponse.bank_account : paymentResponse.parameters;
      break;

    default:
      payment.value.type = paymentResponse.type;
      paymentTerm.value = paymentResponse.type!;
      payment.value.parameters = paymentResponse.parameters;
      if (!payment.value.details) {
        return;
      }

      if (paymentResponse.installments) {
        payment.value.details.installments = paymentResponse.installments?.split(",").map(Number);
      }

      paymentBank.value = paymentResponse.bank_account;
      paymentContractNumber.value = paymentResponse.contract_number;
      paymentDueDate.value = paymentResponse.due_date;
      paymentCommitmentNumber.value = paymentResponse.commitment_number;
      break;
  }
};

const payment = ref<Payment>({
  parameters: "",
  type: "",
  customer_id: props.customer.id!,
  details: {
    bank: "",
    installments: [],
    contract_number: "",
    due_date: "",
  } as PaymentDetails,
});

const paymentTerm = ref<keyof PaymentParameters>();
const paymentParameters = ref({
  upfront: bankAccounts as GenericObject[],
  cash: cashPayment as GenericObject[],
  installments: installmentsPayment as GenericObject[],
});

const paymentTitles = ref<PaymentTitles>({
  upfront: "Banco",
  cash: "Modalidade",
  installments: "Modalidade",
});

const paymentTermDays = ref<string>();
const paymentContractNumber = ref<string>();
const paymentCommitmentNumber = ref<string>();
const paymentBank = ref<string>();
const paymentDueDate = ref<string>();

const updatePaymentInfo = () => {
  if (payment.value.details) {
    payment.value.details.installments = [];
  }

  paymentTermDays.value = "";
  paymentContractNumber.value = "";
  paymentBank.value = "";
  paymentDueDate.value = "";
};

watch(paymentTerm, (paymentType) => {
  if (paymentType === payment.value.type) {
    return;
  }

  payment.value.type = paymentType!;
  payment.value.parameters = "";
  paymentTermDays.value = "";
  paymentContractNumber.value = "";
  paymentBank.value = "";
  paymentDueDate.value = "";
});

const onKeyDown = (event: KeyboardEvent) => {
  if (["Enter", " ", ",", ";"].includes(event.key)) {
    event.preventDefault();
    if (!paymentTermDays.value || payment.value.details?.installments?.includes(+paymentTermDays.value)) {
      return;
    }

    payment.value.details?.installments?.push(+paymentTermDays.value);
    payment.value.details?.installments?.sort((a, b) => a - b);
    paymentTermDays.value = undefined;
  }
};

const removePaymentTermDays = (index: number) => {
  payment.value.details?.installments?.splice(index, 1);
};

const validatePaymentDueDate = () => {
  if (!paymentDueDate.value) {
    return;
  }

  const dueDate = +paymentDueDate.value;
  if (dueDate < 1 || dueDate > 30 || isNaN(dueDate)) {
    paymentDueDate.value = "";
  }
};

watch(paymentDueDate, validatePaymentDueDate);

const canSavePayment = computed(() => {
  if (!paymentTerm.value) {
    return false;
  }

  if (["upfront", "cash"].includes(payment.value.type)) {
    return payment.value.parameters !== "";
  }

  if (payment.value.type === "installments") {
    if (payment.value.parameters === "monthly-closing") {
      return paymentDueDate.value !== "";
    }

    if (payment.value.parameters === "tender-payment" && paymentContractNumber.value === "") {
      return false;
    }

    if (
      payment.value.parameters &&
      ["tender-payment", "bank-transfer"].includes(payment.value.parameters) &&
      paymentBank.value === ""
    ) {
      return false;
    }

    if (payment.value.parameters !== "monthly-closing") {
      return payment.value.details?.installments && payment.value.details?.installments?.length > 0;
    }
  }

  return true;
});

const loading = ref(false);
const savePaymentData = () => {
  if (!canSavePayment.value) {
    return;
  }

  payment.value.id = props.customerPayment?.id;
  payment.value.details = {
    bank: paymentBank.value,
    installments: payment.value.details?.installments,
    contract_number: paymentContractNumber.value,
    commitment_number: paymentCommitmentNumber.value,
    due_date: paymentDueDate.value,
  };

  loading.value = true;

  const form = useForm(payment.value);

  form.post(route("customers.payment", { id: props.customer.id }));
  loading.value = false;
};

onMounted(() => {
  if (!props.customerPayment) {
    return;
  }
  mapPaymentResponse(props.customerPayment);
});
</script>

<template>
  <CreatePage :customer="props.customer" :step="props.step">
    <div class="flex flex-col w-full">
      <div class="font-semibold text-lg">Dados de pagamento</div>
      <div class="grid grid-cols-4 gap-4 w-full">
        <div>
          <div class="flex mt-8 underline">Tipo</div>
          <div class="flex flex-col mt-2">
            <div v-for="item in paymentTerms" :key="item.value" class="flex flex-row items-center gap-4 my-2">
              <input id="payment_term" v-model="paymentTerm" type="radio" :value="item.value" />
              <label for="payment_term" class="text-sm font-semibold">{{ item.label }}</label>
            </div>
          </div>
        </div>
        <GenericRadioGroup
          v-if="paymentTerm"
          v-model="payment.parameters"
          :parameters="paymentParameters[paymentTerm]"
          :title="paymentTitles[paymentTerm]"
          @select="updatePaymentInfo"
        />
        <div v-if="payment.type === 'installments' && payment.parameters !== ''">
          <div class="flex mt-8 underline">Complemento</div>
          <div class="flex flex-col mt-2">
            <div v-if="payment.parameters && payment.parameters !== 'monthly-closing'">
              <label for="installments" class="text-sm">Pazos de pagamento</label>
              <TextInput
                id="installments"
                v-model="paymentTermDays"
                type="text"
                label="Prazo"
                mask="##"
                @keydown="onKeyDown"
              />
            </div>
            <div v-if="payment.parameters === 'tender-payment'" class="mt-4 flex flex-col w-full">
              <div>
                <label for="contract_number" class="text-sm">Número do contrato</label>
                <TextInput
                  id="contract_number"
                  v-model="paymentContractNumber"
                  type="text"
                  label="Número do contrato"
                />
              </div>
              <div class="mt-4">
                <label for="contract_number" class="text-sm">Número do empenho</label>
                <TextInput
                  id="contract_number"
                  v-model="paymentCommitmentNumber"
                  type="text"
                  label="Número do contrato"
                />
              </div>
            </div>
            <div
              v-if="payment.parameters && ['tender-payment', 'bank-transfer'].includes(payment.parameters)"
              class="mt-4"
            >
              <span class="text-sm">Conta para crédito</span>
              <GenericRadioGroup v-model="paymentBank" :parameters="paymentParameters['upfront']" />
            </div>
            <div v-if="payment.parameters === 'monthly-closing'" class="mt-4">
              <label for="due_date" class="text-sm">Dia de pagamento</label>
              <TextInput id="due_date" v-model="paymentDueDate" mask="##" type="text" label="Dia de pagamento" />
            </div>
          </div>
        </div>
        <div v-if="payment.details?.installments" class="grid grid-cols-3 my-4 gap-4 mt-[86px]">
          <div
            v-for="(term, index) in payment.details?.installments"
            :key="index"
            class="flex items-center justify-between text-sm bg-primary text-white p-1 rounded-2xl max-h-10"
          >
            <span class="ml-1">{{ term }}</span>

            <q-btn class="border-l border-white ml-2 mr-1" @click="removePaymentTermDays(index)">
              <span class="material-symbols-outlined ml-1 text-white text-sm hover:text-negative"> clear </span>
            </q-btn>
          </div>
        </div>
      </div>
      <div class="flex justify-end mt-4 w-full">
        <secondary-button
          :class="{ 'bg-primary text-white hover:opacity-70': canSavePayment }"
          :disabled="!canSavePayment"
          label="Salvar"
          type="button"
          width="w-32"
          @click="savePaymentData"
        />
      </div>
    </div>
  </CreatePage>
</template>

<style scoped></style>
