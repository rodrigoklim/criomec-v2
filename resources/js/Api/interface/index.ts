import { Product } from "./product";
import { Customer } from "./customer";

export interface Api {
  customer: Customer;
  product: Product;
}
