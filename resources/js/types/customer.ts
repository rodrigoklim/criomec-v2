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
  street?: string;
  number?: string;
  district?: string;
  city?: string;
  state?: string;
  zip_code: string;
  municipality?: string;
  details?: string;
}
