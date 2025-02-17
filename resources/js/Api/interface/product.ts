import { Ncm } from "@/Pages/Products/Service/get-by-ncm";
import { GenericPaginatedResponse } from "@/types";

export interface Product {
  getByNcm: (ncm: string) => Promise<GenericPaginatedResponse<Ncm>>;
}
