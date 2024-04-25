import { GenericResponse } from "@/types";
import { CustomerPf, CustomerPj } from "@/types/customer";
import axios from "axios";

export const documentValidation = async (document: string, birthdate: string = "") => {
  const { data } = <GenericResponse<CustomerPj | CustomerPf>>await axios.get(route("document.validation"), {
    params: {
      document: document,
      birthdate: birthdate,
    },
  });

  return data;
};
