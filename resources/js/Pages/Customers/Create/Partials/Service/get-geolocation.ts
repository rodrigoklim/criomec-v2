import api from "@/Api";
import { Address, GeolocationResponse } from "@/types/customer";
import map from "lodash/map";

export const getGeolocation = async (data: string) => {
  const response = await api.customer.getGeolocation(data);

  return mapGeolocationResponse(response) as Address;
};

export const mapGeolocationResponse = (data: GeolocationResponse) => {
  if (typeof data === "undefined") {
    return;
  }

  const response = {
    formatted_address: data.formatted_address,
    street: "",
    number: "",
    district: "",
    city: "",
    state: "",
    lat: data.geometry.location.lat,
    lng: data.geometry.location.lng,
    zip: "",
    placeId: data.place_id,
  } as Address;

  map(data.address_components, (item) => {
    switch (item.types[0]) {
      case "route":
        response.street = item.long_name;
        break;
      case "street_number":
        response.number = item.long_name;
        break;
      case "sublocality":
      case "political":
        response.district = item.long_name;
        break;
      case "administrative_area_level_2":
        response.city = item.long_name;
        break;
      case "administrative_area_level_1":
        response.state = item.long_name;
        break;
      case "postal_code":
        response.zip = item.long_name;
        break;
    }
  });

  return response;
};
