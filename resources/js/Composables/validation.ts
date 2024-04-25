export const requiredValidation = (value: string, label: string, callback: (message: string) => void) => {
  if (!value) {
    callback(validationMessage("required", label));
    return false;
  }
};

export const emailValidation = (value: string, label: string, callback: (message: string) => void) => {
  if (!/.+@.+\..+/.test(value)) {
    return callback(validationMessage("email", label));
  }
};

export const lengthValidation = (value: string, label: string, length: number, callback: (message: string) => void) => {
  if (value.length < length) {
    return callback(validationMessage("length", label, length));
  }
};

export const confirmValidation = (
  value: string,
  label: string,
  callback: (message: string) => void,
  confirmValue: string,
) => {
  if (value !== confirmValue) {
    callback(validationMessage("confirm", label));
    return false;
  }
};

export const phoneMask = (locale: string) => {
  switch (locale) {
    case "en-US":
      return "###-###-####";
    case "es-ES":
      return "###-###-####";
    case "fr-FR":
      return "###-###-####";
    case "pt-BR":
      return "(##) #####-####";
    default:
      return "(##) #####-####";
  }
};

export const validationMessage = (message: "email" | "confirm" | "length" | "required", label = "", length = -1) => {
  const validationMessages: { [key: string]: string } = {
    email: "Dados inválidos para e-mail",
    confirm: `Os campos ${label} não são iguais`,
    length: `${label} deve ter no mínimo ${length} caracteres`,
    required: "Este campo é obrigatório",
  };

  return validationMessages[message];
};
