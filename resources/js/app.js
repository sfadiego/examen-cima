import { createApp } from "vue";
import { Quasar } from "quasar";
import { plugin, defaultConfig } from "@formkit/vue";

import "@quasar/extras/material-icons/material-icons.css";
// Import Quasar css
import "quasar/src/css/index.sass";

import App from "./App.vue";
import router from "./router/router.js";
import { VueQueryPlugin } from "@tanstack/vue-query";

const myApp = createApp(App);

myApp.use(router);
myApp.use(VueQueryPlugin);
myApp.use(plugin, defaultConfig({ theme: "genesis" }));
myApp.use(Quasar, { plugins: {} });

myApp.mount("#app");
