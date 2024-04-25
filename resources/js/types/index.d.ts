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

export type GenericResponse<T> = {
  data: T;
  message: string;
  status: number;
};
