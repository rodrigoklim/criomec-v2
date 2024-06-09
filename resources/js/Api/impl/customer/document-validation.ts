import { GenericResponse } from "@/types";
import axios from "axios";

export const documentValidation = async (document: string, birthdate: string = "") => {
  try {
    const { data } = <GenericResponse>await axios.get(route("document.validation"), {
      params: {
        document: document,
        birthdate: birthdate,
      },
    });

    return data;
  } catch (error) {
    console.log(error);
  }
};
