import { GenericResponse } from "@/types";
import { AddressOption } from "@/types/customer";
import axios from "axios";

export const searchAddress = async (address: string) => {
  const { data } = await axios.get<GenericResponse>(`/customers/address/search`, { params: { search: address } });

  return data.data as AddressOption[];
};
