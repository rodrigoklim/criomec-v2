<script lang="ts" setup>
import Form from "@/Layouts/FormLayout.vue";
import { createCustomerMenu } from "@/Pages/Customers/Create/create-customer";
import { CustomerPf, CustomerPj } from "@/types/customer";
import { Link, Head } from "@inertiajs/vue3";
import map from "lodash/map";
import { computed, ref } from "vue";

const props = withDefaults(
  defineProps<{
    customer: CustomerPf | CustomerPj;
    step: string;
  }>(),
  {
    step: "company-data",
  },
);

const loading = ref(false);
const showTooltip = ref(false);

const setHref = (step: string) => {
  switch (step) {
    case "company-data":
      return route("customers.company_data", {
        document: typeof props.customer !== "undefined" ? props.customer.document : "",
        type: typeof props.customer !== "undefined" ? props.customer.type : "",
      });
    case "contact":
      return route("customers.contact", { id: typeof props.customer !== "undefined" ? props.customer.id : "" });
    case "address":
      return route("customers.address", { id: typeof props.customer !== "undefined" ? props.customer.id : "" });
    case "payment":
      return route("customers.payment", { id: typeof props.customer !== "undefined" ? props.customer.id : "" });
    default:
      return route("customers.create", { step: "company-products" });
  }
};

const customerMenu = computed(() => {
  return map(createCustomerMenu, (menuItem) => {
    return {
      ...menuItem,
      customClass: itemStatus(menuItem.slug),
      href: setHref(menuItem.slug),
    };
  });

  function itemStatus(slug: string) {
    if (!props.customer || (!props.customer.id && slug !== "company-data")) {
      return "disabled";
    }

    return props.step === slug ? "selected" : "not-selected";
  }
});
</script>

<template>
  <div>
    <Head>
      <title>Adicionar Clientes</title>
    </Head>
    <Form :back-route="route('customers.index')" :disabled="true" :loading="loading" title="Adicionar um novo cliente">
      <div class="w-full flex flex-row mt-8">
        <div class="w-1/4">
          <div class="flex flex-col border-2 border-primary p-6 rounded-2xl mr-4 bg-white">
            <div class="font-semibold text-lg">Cadastro de cliente</div>
            <Link
              v-for="item in customerMenu"
              :key="item.slug"
              :class="item.customClass"
              class="guide-list"
              :href="setHref(item.slug)"
            >
              {{ item.label }}
            </Link>
          </div>
        </div>
        <div class="w-3/4">
          <div class="flex flex-col border-2 border-primary p-6 rounded-2xl mr-4 bg-white relative">
            <q-btn class="absolute right-6" round @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
              <span class="material-symbols-outlined ml-1 text-primary text-3xl hover:opacity-70"> info </span>
            </q-btn>
            <transition mode="out-in" name="fade">
              <span
                v-if="showTooltip"
                class="absolute right-0 -top-6 tooltip whitespace-nowrap bg-gray-600 text-white text-lg py-2 px-4 left-16 rounded-md ml-2 z-10 w-[43%]"
              >
                Tudo certo, já pode adicionar o seu cliente!
              </span>
            </transition>

            <slot />
          </div>
        </div>
      </div>
    </Form>
  </div>
</template>

<style scoped>
.not-selected {
  @apply hover:bg-primary hover:opacity-60 hover:text-white;
}

.selected {
  @apply bg-primary text-white;
}

.guide-list {
  @apply transition-all duration-150 ease-in-out mt-4 cursor-pointer rounded-lg p-2;
}

.disabled {
  @apply cursor-not-allowed opacity-50;
}

.tooltip {
  transform: translateX(calc(100% + 30px));
}
</style>
