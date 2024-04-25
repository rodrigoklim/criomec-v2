export type MenuItem = {
  label: string;
  icon: string;
  path: string;
  children?: Child[];
};

export type Child = {
  label: string;
  path: string;
};
export const menu = [
  {
    label: "Entregas",
    icon: "local_shipping",
    path: "/freights",
  },
  {
    label: "Manutenção",
    icon: "build",
    path: "/maintenance",
  },
  {
    label: "Administrativo",
    icon: "monitoring",
    path: "/administrative",
  },
  {
    label: "Clientes",
    icon: "store",
    path: "/customers",
  },
  {
    label: "Veículos",
    icon: "garage",
    path: "/vehicles",
  },
  {
    label: "Products",
    icon: "propane_tank",
    path: "/vehicles",
  },
  {
    label: "Equipe",
    icon: "group",
    path: "/team",
  },
  {
    label: "config",
    icon: "settings",
    path: "/config",
  },
] as MenuItem[];
