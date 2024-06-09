import api from "@/Api";
import { AddressOption } from "@/types/customer";
import map from "lodash/map";

export const searchAddress = async (data: string) => {
  const search = await api.customer.searchAddress(data);

  return mapAutoCompleteResponse(search);
};

const mapAutoCompleteResponse = (data: AddressOption[]) => {
  return map(data, (item: AddressOption) => {
    return {
      place_id: item.place_id,
      terms: item.terms,
      description: item.description,
    } as AddressOption;
  });
};
