import api from "@/Api";
import Log from "@/Utils/log";
import map from "lodash/map";
import { defineStore } from "pinia";
import { Address, AddressOption, CustomerPf, CustomerPj, GeolocationResponse, Payment } from "@/types/customer";

export const useCustomerStore = defineStore("customer", {
  state: () => ({
    address: [] as Address[],
    companyData: {} as CustomerPj | CustomerPf,
    payment: {} as Payment,
    step: "company-data",
  }),
  getters: {
    currentCompanyData: (state) => state.companyData,
    addresses: (state) => state.address,
  },
  actions: {
    async getCompanyData(document: string, birthdate: string) {
      try {
        const { data } = await api.customer.documentValidation(document, birthdate);
        this.companyData = data;

        if (data.address) {
          const address = this.mapGeolocationAddressSearch(data.address);
          const addressResponse = await this.getGeolocation(address);

          this.address.push(addressResponse);
        }
      } catch (error) {
        Log.error(error, "PermissionUsers.users");
      }
    },

    addAddress(data: Address) {
      this.address.push(data);
    },

    removeAddress(index: number) {
      this.address.splice(index, 1);
    },

    setCompanyData(data: CustomerPj | CustomerPf) {
      this.companyData = data;
    },

    setTab(tab: string) {
      this.step = tab;
    },

    mapGeolocationAddressSearch(address: Address) {
      return `${address.street}, ${address.number} - ${address.district}, ${address.city} - ${address.state}, ${address.zip}`;
    },

    async searchAddress(data: string) {
      const search = await api.customer.searchAddress(data);

      return this.mapAutoCompleteResponse(search);
    },

    async getGeolocation(data: string) {
      const response = await api.customer.getGeolocation(data);

      return this.mapGeolocationResponse(response) as Address;
    },

    mapGeolocationResponse(data: GeolocationResponse) {
      const response = {
        formatted_address: data.formatted_address,
        street: "",
        number: "",
        district: "",
        city: "",
        state: "",
        lat: data.geometry.location.lat,
        lng: data.geometry.location.lng,
        zip: "",
        placeId: data.place_id,
      } as Address;

      map(data.address_components, (item) => {
        switch (item.types[0]) {
          case "route":
            response.street = item.long_name;
            break;
          case "street_number":
            response.number = item.long_name;
            break;
          case "sublocality":
          case "political":
            response.district = item.long_name;
            break;
          case "administrative_area_level_2":
            response.city = item.long_name;
            break;
          case "administrative_area_level_1":
            response.state = item.long_name;
            break;
          case "postal_code":
            response.zip = item.long_name;
            break;
        }
      });

      return response;
    },

    mapAutoCompleteResponse(data: AddressOption[]) {
      return map(data, (item: AddressOption) => {
        return {
          place_id: item.place_id,
          terms: item.terms,
          description: item.description,
        } as AddressOption;
      });
    },

    setPaymentMethod(paymentMethod: Payment) {
      this.payment = paymentMethod;
    },
  },
});
