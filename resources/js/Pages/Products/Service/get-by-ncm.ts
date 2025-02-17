import api from "@/Api";
import map from "lodash/map";

export interface Ncm {
  ncm: string;
}

export const getByNcm = async (ncm: string) => {
  const response = await api.product.getByNcm(ncm);

  return mapNcmResponse(response.data);
};

const mapNcmResponse = (data: Ncm[]) => {
  return map(data, (item) => item.ncm);
};
