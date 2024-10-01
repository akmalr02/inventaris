import "../src/assets/main.css";

import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import VueApexCharts from "vue3-apexcharts";

const app = createApp(App);
app.use(router).use(createPinia()).use(VueApexCharts);
app.mount("#app");
