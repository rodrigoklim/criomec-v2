import { fileURLToPath } from "node:url";
import { configDefaults, mergeConfig } from "vitest/config";
import { defineConfig } from "vitest/config";
import vue from "@vitejs/plugin-vue";
import viteConfig from "./vite.config";

export default mergeConfig(
  viteConfig,
  defineConfig({
    test: {
      environment: "jsdom",
      include: ["**/__tests__/**/*.{ts,tsx}"],
      exclude: [...configDefaults.exclude, "e2e/*"],
      root: fileURLToPath(new URL("./", import.meta.url)),
    },
    plugins: [vue()],
  }),
);
