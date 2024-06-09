import { GoogleApi } from "@/Pages/Customers/Create/Partials/Interface";
import { getGeolocation } from "./get-geolocation";
import { searchAddress } from "./search-address";

export default {
  getGeolocation,
  searchAddress,
} as GoogleApi;
