export interface CustomerResponse {
  customer: CustomerPj;
  type: "pj" | "pf";
}

export interface CustomerPj {
  document: string;
  corporateName: string;
  companyName?: string;
  ie?: string;
  mainActivity?: string;
  status: string;
  address: Address;
  type: string;
}

export interface CustomerPf {
  document: string;
  name: string;
  birthdate: string;
  type: string;
  mainActivity?: string;
  companyName?: string;
  address?: Address;
  status: string;
}

export interface Address {
  formatted_address?: string;
  street?: string;
  number?: string;
  district?: string;
  city?: string;
  cityCode?: string;
  state?: string;
  zip?: string;
  municipality?: string;
  details?: string;
  lat?: number;
  lng?: number;
  placeId?: string;
}

export interface AddressOption {
  place_id: string;
  terms: AddressTerms[];
  description: string;
}

export interface AddressTerms {
  offset: number;
  value: string;
}

export interface Contact {
  id?: number;
  name: string;
  position: string;
  phone: string;
  email: string;
}

export interface AddressRequest {
  address?: string;
  placeId?: string;
}

export interface GeolocationResponse {
  formatted_address: string;
  address_components: AddressOptions[];
  geometry: Geolocation;
  place_id: string;
}

export interface Geolocation {
  location: {
    lat: number;
    lng: number;
  };
}

export interface AddressOptions {
  long_name: string;
  types: string[];
}

export interface Payment {
  type: string;
  parameters?: string;
  details?: PaymentDetails;
}

export interface PaymentDetails {
  bank?: string;
  installments?: number[];
  contract_number?: string;
  due_date?: string;
}
