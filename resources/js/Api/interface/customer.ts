import { GenericResponse } from "@/types";
import { AddressOption, GeolocationResponse } from "@/types/customer";

export interface Customer {
  documentValidation: (document: string, birthdate: string) => Promise<GenericResponse>;
  searchAddress: (address: string) => Promise<AddressOption[]>;
  getGeolocation: (address: string) => Promise<GeolocationResponse>;
}
