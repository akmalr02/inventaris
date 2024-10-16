import "../src/assets/main.css";

import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import VueApexCharts from "vue3-apexcharts";
import { useAuthStore } from "@/stores/authStore"; // Import store

const app = createApp(App);

const pinia = createPinia();
app.use(router).use(pinia).use(VueApexCharts);

// Muat token dari localStorage saat aplikasi dimulai
const authStore = useAuthStore();
authStore.loadUserFromLocalStorage(); // Pastikan store memuat status login dari localStorage

app.mount("#app");
