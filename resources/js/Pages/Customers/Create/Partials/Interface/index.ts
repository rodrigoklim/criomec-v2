import { AddressOption, GeolocationResponse } from "@/types/customer";

export interface GoogleApi {
  getGeolocation: (address: string) => Promise<GeolocationResponse>;
  searchAddress: (address: string) => Promise<AddressOption[]>;
}
