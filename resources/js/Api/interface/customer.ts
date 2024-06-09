import { GenericResponse } from "@/types";
import { AddressOption, CustomerPf, CustomerPj, GeolocationResponse } from "@/types/customer";

export interface Customer {
  createCompanyData: (data: CustomerPj | CustomerPf) => Promise<void>;
  documentValidation: (document: string, birthdate: string) => Promise<GenericResponse>;
  searchAddress: (address: string) => Promise<AddressOption[]>;
  getGeolocation: (address: string) => Promise<GeolocationResponse>;
}
