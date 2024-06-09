export interface CustomerResponse {
  customer: CustomerPj;
  type: "pj" | "pf";
}

export interface CustomerPj {
  id?: string;
  document: string;
  corporate_name: string;
  company_name?: string;
  ie?: string;
  main_activity?: string;
  status: string;
  address: Address;
  type: string;
  email?: string;
  withNF: boolean;
  contacts: Contact[];
}

export interface CustomerPf {
  id?: string;
  document: string;
  name: string;
  birthdate: string;
  type: string;
  main_activity?: string;
  company_name?: string;
  address?: Address;
  status: string;
  email?: string;
  withNF: boolean;
  contacts: Contact[];
}

export interface Address {
  id?: string;
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
  customer_id?: string;
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
  customer_id: string;
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
  lat: number;
  lng: number;
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
  id?: string;
  type: string;
  parameters?: string;
  details?: PaymentDetails;
  customer_id: string;
}

export interface PaymentDetails {
  bank?: string;
  installments?: number[];
  contract_number?: string;
  commitment_number?: string;
  due_date?: string;
}

export interface CompanyDataRequest {
  document: string;
  corporate_name?: string;
  company_name: string;
  ie?: string;
  main_activity: string;
  status: string;
  type: string;
  email: string;
}

export interface CompanyPaymentResponse {
  id: string;
  type: string;
  parameters: string;
  bank_account?: string;
  commitment_number?: string;
  contract_number?: string;
  due_date?: string;
  installments?: string;
  customer_id: string;
}
