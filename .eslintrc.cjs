module.exports = {
  env: {
    node: true
  },
  parser: "vue-eslint-parser", // Specifies the ESLint parser
  parserOptions: {
    parser: "@typescript-eslint/parser", // Specifies the ESLint parser for TypeScript
    ecmaVersion: 2020,
    sourceType: "module",
  },
  extends: [
    "plugin:vue/vue3-recommended", // or 'plugin:vue/vue3-strongly-recommended' or 'plugin:vue/vue3-recommended' for stricter rules
    "eslint:recommended",
    "@vue/typescript/recommended",
    "prettier",
    "plugin:prettier/recommended",
  ],
  rules: {
    // Add custom rules or override existing ones here
  },
};
