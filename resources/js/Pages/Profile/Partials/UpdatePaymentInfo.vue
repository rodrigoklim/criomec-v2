<script setup lang="ts">
import Modal from "@/Components/Modal.vue";
import PlanOption from "@/Components/PlanOption.vue";
import SimpleForm from "@/Components/SimpleForm.vue";
import { Plan } from "@/types/plan";
import { useForm } from "@inertiajs/vue3";
import { onMounted, ref, watch } from "vue";

const props = defineProps<{
  plans: Plan[];
}>();

const form = useForm({
  stripe_plan: "",
  slug: "",
  price: 0,
});

const recurrence = ref("");
const selectedPlan = ref<Plan>();

const onSubmit = () => {
  window.location.href = `/subscriptions?stripe_plan=${form.stripe_plan}`;
};

onMounted(() => {
  recurrence.value = "month";
});

watch(recurrence, (r) => {
  selectedPlan.value = props.plans.find((p) =>
    r === "month" ? p.slug === "premium-mensal" : p.slug === "premium-anual",
  );

  if (selectedPlan.value) {
    form.stripe_plan = selectedPlan.value.stripe_plan;
    form.slug = selectedPlan.value.slug;
    form.price = selectedPlan.value.price;
  }
});
</script>

<template>
  <Modal :show="true" max-width="4xl">
    <SimpleForm title="Atualizar Assinatura">
      <div class="flex flex-row items-center mb-8">
        <PlanOption title="Free" type="free" :loading="form.processing" :recurrence="recurrence" />
        <PlanOption
          title="Premium"
          type="premium"
          :value="form.price"
          :recurrence="recurrence"
          :loading="form.processing"
          @click="onSubmit"
          @recurrence-change="recurrence = $event"
        />
      </div>
    </SimpleForm>
  </Modal>
</template>
