import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/authStore";
import Login from "@/view/login.vue";
import Error402 from "@/view/error.vue";

// Dashboard
import admin from "@/view/dashboard/home.vue";
import Dashboard from "@/view/dashboard/dashboard.vue";
import pengguna from "@/view/dashboard/homePengguna.vue";

// akses admin user
import dataUser from "@/view/admin/dataUser.vue";
import editUser from "@/view/admin/edit.vue";
import tambahUser from "@/view/admin/tambahUser.vue";

// laporoan
import laporan from "@/view/admin/laporan.vue";

// laporoan barang kosong
import barangKosong from "@/view/laporan/barang_kosong/barangKosong.vue";
import editBarangKosong from "@/view/laporan/barang_kosong/edit.vue";
import viewBarangKosong from "@/view/laporan/barang_kosong/view.vue";

// laporoan barang rusak
import barangRusak from "@/view/laporan/barang_rusak/barangRusak.vue";
import editBarangRusak from "@/view/laporan/barang_rusak/edit.vue";
import viewBarangRusak from "@/view/laporan/barang_rusak/view.vue";

// laporoan pesanan barnag
import pesananBarang from "@/view/laporan/pesanan/pesananBarang.vue";
import editPesananBarang from "@/view/laporan/pesanan/edit.vue";
import viewPesanan from "@/view/laporan/pesanan/view.vue";

// barang
import barang from "@/view/barang/barang.vue";
import tambahBarang from "@/view/barang/tambah.vue";
import editBarang from "@/view/barang/edit.vue";
import viewBarang from "@/view/barang/view.vue";

//categories
import categories from "@/view/categories/category.vue";
import tambahCategories from "@/view/categories/tambah.vue";

// user all
import profil from "@/view/seting/profil.vue";
import edit from "@/view/seting/edit.vue";
import ubah from "@/view/seting/ubah.vue";

//pesanan
import pesananUser from "@/view/user/index.vue";

const routes = [
  { path: "/login", name: "login", component: Login },

  // Dashboard
  // hanya untuk admin dan pengelola
  { path: "/", name: "dashboard", component: Dashboard },
  {
    path: "/home",
    name: "home",
    component: admin,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },

  //hanya untuk pemakai
  {
    path: "/pengguna",
    name: "homePengguna",
    component: pengguna,
    meta: { requiresAuth: true, roles: ["pemakai"] },
  },

  // akses admin penuh admin
  {
    path: "/dataUser",
    name: "dataUser",
    component: dataUser,
    meta: { requiresAuth: true, roles: ["admin"] },
  },
  {
    path: "/editUser/:id",
    name: "editUser",
    component: editUser,
    meta: { requiresAuth: true, roles: ["admin"] },
  },
  {
    path: "/tambahUser",
    name: "tambahUser",
    component: tambahUser,
    meta: { requiresAuth: true, roles: ["admin"] },
  },

  // seluruh laporan admin dan pengelola
  {
    path: "/laporan",
    name: "laporan",
    component: laporan,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },

  // laporan barang rusak hanya untuk admin dan pengelola
  {
    path: "/barangRusak",
    name: "barangRusak",
    component: barangRusak,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },

  {
    path: "/editR/:id",
    name: "editBarangRusak",
    component: editBarangRusak,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },
  {
    path: "/viewR/:id",
    name: "viewBarangKosong",
    component: viewBarangKosong,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },

  // laporan barang kosong hanya untuk admin dan pengelola
  {
    path: "/barangKosong",
    name: "barangKosong",
    component: barangKosong,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },

  {
    path: "/editK/:id",
    name: "editBarangKosong",
    component: editBarangKosong,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },
  {
    path: "/viewK/:id",
    name: "viewBarangRusak",
    component: viewBarangRusak,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },

  // laporan pesanan barang hanya untuk admin dan pengelola
  {
    path: "/pesananBarang",
    name: "pesananBarang",
    component: pesananBarang,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },

  {
    path: "/editP/:id",
    name: "editPesananBarang",
    component: editPesananBarang,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },
  {
    path: "/viewP/:id",
    name: "viewPesanan",
    component: viewPesanan,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },

  // barang dapat di buka oleh semua role
  { path: "/barang", name: "barang", component: barang },
  { path: "/viewB/:id", name: "viewBarang", component: viewBarang },

  //hanya untuk admin dan pengelola
  {
    path: "/tambahBarang",
    name: "tambahBarang",
    component: tambahBarang,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },
  {
    path: "/editB/:id",
    name: "editBarang",
    component: editBarang,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },

  //categories hanya untuk admin dan pengelola
  {
    path: "/categories",
    name: "categories",
    component: categories,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },
  {
    path: "/tambahCategories",
    name: "tambahCategories",
    component: tambahCategories,
    meta: { requiresAuth: true, roles: ["admin", "pengelola"] },
  },

  //halaman error
  { path: "/error-402", name: "error404", component: Error402 },

  // seting
  { path: "/profil", name: "profil", component: profil },
  { path: "/editU/:id", name: "editU", component: edit, props: true },
  { path: "/password/:id", name: "password", component: ubah, props: true },

  //pesanan user
  {
    path: "/pesanan",
    name: "pesanan",
    component: pesananUser,
    meta: { requiresAuth: true, roles: ["pemakai"] },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  authStore.loadUserFromLocalStorage(); // Memuat data pengguna dari localStorage

  const requiredRoles = to.meta.roles; // Mengambil roles yang dibutuhkan dari meta route
  const userRole = authStore.getRole(); // Mengambil role pengguna dari store

  if (to.meta.requiresAuth && !userRole) {
    // Jika memerlukan autentikasi tetapi pengguna tidak terautentikasi
    next({ name: "login" });
  } else if (requiredRoles && !requiredRoles.includes(userRole)) {
    // Jika role pengguna tidak termasuk dalam roles yang diperbolehkan
    next({ name: "error404" }); // Arahkan ke halaman error 402
  } else {
    next(); // Melanjutkan ke route yang dituju
  }
});

export default router;
