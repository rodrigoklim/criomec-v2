<script setup lang="ts">
import GoogleMaps from "@/Components/GoogleMaps/GoogleMaps.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import CreatePage from "@/Pages/Customers/Create/CreatePage.vue";
import AddressCard from "@/Pages/Customers/Create/Partials/Components/AddressCard.vue";
import AddressPredictionSelect from "@/Pages/Customers/Create/Partials/Components/AddressPredictionSelect.vue";
import service from "@/Pages/Customers/Create/Partials/Service";
import { Address, AddressOption, CustomerPf, CustomerPj } from "@/types/customer";
import { useForm } from "@inertiajs/vue3";
import debounce from "lodash/debounce";
import map from "lodash/map";
import { ref, watch } from "vue";

const props = defineProps<{
  customer: CustomerPf | CustomerPj;
  step: string;
  addresses?: Address[];
}>();

const addresses = ref<Address[]>(props.addresses || []);
const address = ref<Address>({
  street: "",
  number: "",
  district: "",
  city: "",
  state: "",
  zip: "",
  details: "",
  lat: parseFloat(import.meta.env.VITE_DEFAULT_LAT),
  lng: parseFloat(import.meta.env.VITE_DEFAULT_LNG),
  customer_id: props.customer.id!,
});

const addAddress = () => {
  addresses.value.push(address.value);
  address.value = {
    street: "",
    number: "",
    district: "",
    city: "",
    state: "",
    zip: "",
    details: "",
    lat: parseFloat(import.meta.env.VITE_DEFAULT_LAT),
    lng: parseFloat(import.meta.env.VITE_DEFAULT_LNG),
    customer_id: props.customer.id!,
  };
  isEditing.value = false;
};

const addressOptions = ref<AddressOption[]>([]);

const isEditing = ref(false);
const isFocused = ref(false);

const editAddress = (index: number) => {
  isEditing.value = true;
  address.value = addresses.value[index];
  deleteAddress(index);
};

const updateAddressPosition = (position: { lat: number; lng: number }) => {
  address.value.lat = position.lat;
  address.value.lng = position.lng;
};

const deleteAddress = (index: number) => {
  const removedAddress = addresses.value[index];

  if (!removedAddress.id) {
    addresses.value.splice(index, 1);
    return;
  }

  const form = useForm({});
  form.delete(route("customers.address", { id: removedAddress.id }));
};

watch(
  () => address.value,
  (newStreet) => {
    if (!newStreet) {
      addressOptions.value = [];
      return;
    }

    searchAddressPrediction(
      `${newStreet.street}, ${newStreet.number}, ${newStreet.district}.${newStreet.city}-${newStreet.state}`,
    );
  },
  { deep: true },
);

watch(
  () => props.addresses!,
  (value: Address[]) => {
    addresses.value = value;
  },
);

const searchAddressPrediction = debounce((street) => {
  if (!street) {
    return;
  }

  setTimeout(async () => {
    addressOptions.value = await service.searchAddress(street);
    const { lat, lng } = await service.getGeolocation(street);
    address.value.lat = lat;
    address.value.lng = lng;
  }, 500);
}, 300);

const selectAddress = async (option: AddressOption) => {
  addressOptions.value = [];
  isEditing.value = true;

  address.value = await service.getGeolocation(option.description);
};

const onFocus = () => {
  isFocused.value = true;
};

const onBlur = () => {
  setTimeout(() => {
    isFocused.value = false;
  }, 200); // Delay to allow selectAddress event to fire
};

const onKeyDown = (event: KeyboardEvent) => {
  if (event.key === "Escape") {
    addressOptions.value = [];
    isFocused.value = false;
  }
};

const loading = ref(false);
const submit = () => {
  loading.value = true;
  map(addresses.value, (address) => {
    address.customer_id = props.customer.id!;
  });

  const form = useForm({
    addresses: addresses.value,
  });

  form.post(route("customers.address", { id: props.customer.id }));
  loading.value = false;
};
</script>

<template>
  <CreatePage :customer="props.customer" :step="props.step">
    <form autocomplete="off" @submit.prevent="submit">
      <div class="flex flex-col w-full">
        <div class="font-semibold text-lg">Endereços</div>
        <div class="grid grid-cols-2 gap-4 w-full">
          <div class="flex flex-col text-sm mt-8">
            <input type="hidden" autocomplete="off" />
            <div class="relative">
              <label class="font-semibold mr-4">Rua</label>
              <TextInput
                v-model="address.street"
                type="text"
                label="Rua"
                rules="required"
                :autocomplete="'new-password'"
                @focus="onFocus"
                @blur="onBlur"
                @keydown="onKeyDown"
              />
              <transition name="fade">
                <AddressPredictionSelect
                  v-if="addressOptions.length && isFocused"
                  class="address-prediction-select"
                  :options="addressOptions"
                  @select-address="selectAddress"
                />
              </transition>
            </div>
            <div class="mt-4">
              <div class="flex flex-row gap-4">
                <div>
                  <label for="position" class="font-semibold mr-4">Número</label>
                  <TextInput id="phone" v-model="address.number" type="text" label="Cargo" rules="required" />
                </div>
                <div>
                  <label for="name" class="font-semibold mr-4">Complemento</label>
                  <TextInput id="phone" v-model="address.details" type="text" label="Complemento" />
                </div>
              </div>
            </div>
            <div class="mt-4">
              <div class="flex flex-row gap-4">
                <div>
                  <label for="position" class="font-semibold mr-4">Bairro</label>
                  <TextInput id="phone" v-model="address.district" type="text" label="Bairro" rules="required" />
                </div>
                <div>
                  <label for="name" class="font-semibold mr-4">CEP</label>
                  <TextInput id="phone" v-model="address.zip" type="text" label="CEP" rules="required" />
                </div>
              </div>
            </div>
            <div class="mt-4">
              <div class="flex flex-row gap-4">
                <div>
                  <label for="position" class="font-semibold mr-4">Cidade</label>
                  <TextInput id="phone" v-model="address.city" type="text" label="Cidade" rules="required" />
                </div>
                <div>
                  <label for="name" class="font-semibold mr-4">Estado</label>
                  <TextInput id="phone" v-model="address.state" type="text" label="Estado" rules="required" />
                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-row w-full mt-2">
            <GoogleMaps
              v-if="address.lat && address.lng"
              class="relative"
              :lat="address.lat"
              :lng="address.lng"
              @position="updateAddressPosition"
            />
          </div>
        </div>
        <SecondaryButton class="mt-8 w-1/4" type="button" color="primary" label="Adicionar" @click="addAddress" />
        <div v-if="addresses.length" class="font-regular mt-8 italic">Endereços cadastrados</div>
        <div class="grid grid-cols-3 gap-4 mt-4">
          <AddressCard
            v-for="(addressItem, index) in addresses"
            :key="index"
            :address="addressItem"
            @edit="editAddress(index)"
            @delete="deleteAddress(index)"
          />
        </div>
        <div v-if="addresses.length" class="flex justify-end mt-4 w-full">
          <secondary-button
            class="bg-primary text-white hover:opacity-70"
            type="submit"
            label="Salvar"
            width="w-[175px]"
            :loading="loading"
          />
        </div>
      </div>
    </form>
  </CreatePage>
</template>

<style scoped>
.address-prediction-select {
  @apply absolute z-10 w-full;
}
</style>
