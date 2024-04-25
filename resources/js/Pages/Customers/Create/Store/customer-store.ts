import api from "@/Api";
import Log from "@/Utils/log";
import { defineStore } from "pinia";
import { CustomerPf, CustomerPj } from "@/types/customer";

export const useCustomerStore = defineStore("customer", {
  state: () => ({
    companyData: {} as CustomerPj | CustomerPf,
    step: "company-data",
  }),
  getters: {
    currentCompanyData: (state) => state.companyData,
  },
  actions: {
    async getCompanyData(document: string, birthdate: string) {
      try {
        const { data } = await api.customer.documentValidation(document, birthdate);
        this.setCompanyData(data);
      } catch (error) {
        Log.error(error, "PermissionUsers.users");
      }
    },

    setCompanyData(data: CustomerPj | CustomerPf) {
      this.companyData = data;
    },

    setTab(tab: string) {
      this.step = tab;
    },
  },
});
