import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "@/view/dashboard.vue";
import Login from "@/view/login.vue";
import coba from "@/view/coba.vue";
import admin from "@/view/admin/home.vue";
import dataUser from "@/view/admin/dataUser.vue";
import laporan from "@/view/admin/laporan.vue";
import editUser from "@/view/admin/edit.vue";

const routes = [
  { path: "/", name: "dashboard", component: Dashboard },
  { path: "/login", name: "login", component: Login },
  { path: "/coba", name: "coba", component: coba },
  { path: "/home", name: "homeAdmin", component: admin },
  { path: "/dataUser", name: "dataUser", component: dataUser },
  { path: "/laporan", name: "laporan", component: laporan },
  { path: "/editUser/:id", name: "editUser", component: editUser },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
