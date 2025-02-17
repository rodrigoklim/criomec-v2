import { Ncm } from "@/Pages/Products/Service/get-by-ncm";
import { GenericPaginatedResponse } from "@/types";
import axios from "axios";

export const getByNcm = async (ncm: string) => {
  const { data } = await axios.get<GenericPaginatedResponse<Ncm>>(`/products/${ncm}/ncm`);

  return data.data;
};
