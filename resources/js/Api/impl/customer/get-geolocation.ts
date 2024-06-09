import { GenericResponse } from "@/types";
import { GeolocationResponse } from "@/types/customer";
import axios from "axios";

export const getGeolocation = async (address: string) => {
  const { data } = await axios.get<GenericResponse>("/customers/address/geolocation", { params: { address: address } });

  return data.data[0] as GeolocationResponse;
};
