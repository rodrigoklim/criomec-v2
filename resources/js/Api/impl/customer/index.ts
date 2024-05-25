import { getGeolocation } from "@/Api/impl/customer/get-geolocation";
import { searchAddress } from "./search-address";
import { documentValidation } from "./document-validation";

export default {
  documentValidation,
  searchAddress,
  getGeolocation,
};
