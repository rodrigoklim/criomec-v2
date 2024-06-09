import { CompanyDataRequest } from "@/types/customer";
import axios from "axios";

export const createCompanyData = async (data: CompanyDataRequest) => {
  await axios.post(`/customers/company-data/${data.type}`, data);
};
