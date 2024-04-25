import { GenericResponse } from "@/types";
import { CustomerPf, CustomerPj } from "@/types/customer";

export interface Customer {
  documentValidation: (document: string, birthdate: string) => Promise<GenericResponse<CustomerPj | CustomerPf>>;
}
