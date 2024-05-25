<script setup lang="ts">
import GoogleMaps from "@/Components/GoogleMaps/GoogleMaps.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AddressCard from "@/Pages/Customers/Create/Partials/Components/AddressCard.vue";
import AddressPredictionSelect from "@/Pages/Customers/Create/Partials/Components/AddressPredictionSelect.vue";
import { useCustomerStore } from "@/Pages/Customers/Create/Store/customer-store";
import { Address, AddressOption } from "@/types/customer";
import debounce from "lodash/debounce";
import { onMounted, ref, watch } from "vue";

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
});

const customerStore = useCustomerStore();
const addresses = customerStore.addresses;
const addAddress = () => {
  console.log(1);
  customerStore.addAddress(address.value);
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
  };
  isEditing.value = false;
};

const addressOptions = ref<AddressOption[]>([]);

const isEditing = ref(false);
const isFocused = ref(false);

onMounted(() => {
  if (customerStore.addresses.length === 1) {
    editAddress(0);
  }
});

const editAddress = (index: number) => {
  isEditing.value = true;
  address.value = customerStore.addresses[index];
  customerStore.removeAddress(index);
};

const updateAddressPosition = (position: { lat: number; lng: number }) => {
  address.value.lat = position.lat;
  address.value.lng = position.lng;
};

watch(
  () => address.value.street,
  (newStreet) => {
    if (!newStreet) {
      addressOptions.value = [];
      return;
    }

    searchAddressPrediction(newStreet);
  },
);

const searchAddressPrediction = debounce((street) => {
  if (!street) {
    return;
  }

  setTimeout(async () => {
    addressOptions.value = await customerStore.searchAddress(street);
  }, 500);
}, 300);

const deleteAddress = (index: number) => {
  customerStore.removeAddress(index);
};

const selectAddress = async (option: AddressOption) => {
  addressOptions.value = [];
  isEditing.value = true;

  address.value = await customerStore.getGeolocation(option.description);
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
</script>

<template>
  <div>
    <div class="flex flex-col w-full">
      <div class="font-semibold text-lg">Endereços</div>
      <div class="grid grid-cols-2 gap-4 w-full">
        <div class="flex flex-col text-sm mt-8">
          <div class="relative">
            <label for="name" class="font-semibold mr-4">Rua</label>
            <TextInput
              id="phone"
              v-model="address.street"
              type="text"
              label="Rua"
              rules="required"
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
                <TextInput id="phone" v-model="address.details" type="text" label="Email" rules="email" />
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
                <TextInput id="phone" v-model="address.zip" type="text" label="CEP" rules="email" />
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
                <TextInput id="phone" v-model="address.state" type="text" label="Estado" rules="email" />
              </div>
            </div>
          </div>
        </div>
        <div class="flex w-full h-full pt-4 text-white">
          <GoogleMaps
            v-if="address.lat && address.lng"
            :lat="address.lat"
            :lng="address.lng"
            @position="updateAddressPosition"
          />
        </div>
      </div>
      <div class="flex flex-row w-full"></div>
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
  </div>
</template>

<style scoped>
.address-prediction-select {
  @apply absolute z-10 w-full;
}
</style>
