export interface User {
  id: number;
  name?: string;
  email: string;
  email_verified_at: string;
  last_name?: string;
  phone?: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    user: User;
  };
};

export type GenericResponse = {
  data: ResponseData;
  message: string;
  status: number;
};

export type ResponseData<T> = {
  data: T | T[];
};

export interface GenericObject {
  label: string;
  value: string;
}

export interface GenericErrorResponse {
  [key: string]: string;
}
