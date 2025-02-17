export interface Product {
  id?: string;
  name: string;
  cest?: string;
  ncm?: string;
  sku?: string;
  is_active: string;
  operation: string;
  units: ProductUnit[];
  logs?: ProductLog[];
}

export interface ProductLog {
  id: string;
  user: string;
  operation: string;
  created_at: string;
  updated_at: string;
}

export interface ProductUnit {
  product_id?: string;
  unit: string;
}

export const productUnits = [
  {
    value: "liters",
    text: "Litro",
  },
  {
    value: "cubic_meters",
    text: "M³",
  },
  {
    value: "kilograms",
    text: "Quilograma",
  },
  {
    value: "recharge",
    text: "Carga",
  },
  {
    value: "units",
    text: "Unidade",
  },
];

export const productOperations = [
  {
    value: "sell",
    label: "Venda",
  },
  {
    value: "rent",
    label: "Locação",
  },
  {
    value: "loan_for_use",
    label: "Comodato",
  },
  {
    value: "other",
    label: "Outro",
  },
];
