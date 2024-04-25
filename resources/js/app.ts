import "./bootstrap";
import "../css/app.css";

import { createApp, h, DefineComponent } from "vue";
import { Quasar } from "quasar";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { createPinia } from "pinia";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";
const pinia = createPinia();

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>("./Pages/**/*.vue")),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(pinia)
      .use(Quasar, {
        plugins: {}, // import Quasar plugins and add here
        /*
                        config: {
                          brand: {
                            // primary: '#e46262',
                            // ... or all other brand colors
                          },
                          notify: {...}, // default set of options for Notify Quasar plugin
                          loading: {...}, // default set of options for Loading Quasar plugin
                          loadingBar: { ... }, // settings for LoadingBar Quasar plugin
                          // ..and many more (check Installation card on each Quasar component/directive/plugin)
                        }
                        */
      })
      .mount(el);
  },
  progress: {
    color: "#4B5563",
  },
});
