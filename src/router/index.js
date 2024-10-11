import { createRouter, createWebHistory } from "vue-router";
import Login from "@/view/login.vue";
// import coba from "@/view/coba.vue";

// Dashboard
import admin from "@/view/admin/home.vue";
import Dashboard from "@/view/dashboard.vue";

// akses admin user
import dataUser from "@/view/admin/dataUser.vue";
import editUser from "@/view/admin/edit.vue";
import tambahUser from "@/view/admin/tambahUser.vue";

// laporoan
import laporan from "@/view/admin/laporan.vue";

// laporoan barang kosong
import barangKosong from "@/view/laporan/barang_kosong/barangKosong.vue";
import tambahBarangKosong from "@/view/laporan/barang_kosong/tambah.vue";
import editBarangKosong from "@/view/laporan/barang_kosong/edit.vue";
import viewBarangKosong from "@/view/laporan/barang_kosong/view.vue";

// laporoan barang rusak
import barangRusak from "@/view/laporan/barang_rusak/barangRusak.vue";
import tambahBarangRusak from "@/view/laporan/barang_rusak/tambah.vue";
import editBarangRusak from "@/view/laporan/barang_rusak/edit.vue";
import viewBarangRusak from "@/view/laporan/barang_rusak/view.vue";

// laporoan pesanan barnag
import pesananBarang from "@/view/laporan/pesanan/pesananBarang.vue";
import editPesananBarang from "@/view/laporan/pesanan/edit.vue";
import tambahPesananBarang from "@/view/laporan/pesanan/tambah.vue";
import viewPesanan from "@/view/laporan/pesanan/view.vue";

// barang
import barang from "@/view/barang/barang.vue";
import tambahBarang from "@/view/barang/tambah.vue";
import editBarang from "@/view/barang/edit.vue";
import viewBarang from "@/view/barang/view.vue";

//categories
import categories from "@/view/categories/category.vue";
import tambahCategories from "@/view/categories/tambah.vue";

const routes = [
  { path: "/login", name: "login", component: Login },

  // Dashboard
  { path: "/", name: "dashboard", component: Dashboard },
  { path: "/home", name: "homeAdmin", component: admin },

  // akses admin
  { path: "/dataUser", name: "dataUser", component: dataUser },
  { path: "/editUser/:id", name: "editUser", component: editUser },
  { path: "/tambahUser", name: "tambahUser", component: tambahUser },
  { path: "/laporan", name: "laporan", component: laporan },

  // laporan barang rusak
  { path: "/barangRusak", name: "barangRusak", component: barangRusak },
  {
    path: "/tambahR/:id",
    name: "tambahBarangRusak",
    component: tambahBarangRusak,
  },
  {
    path: "/editR/:id",
    name: "editBarangRusak",
    component: editBarangRusak,
  },
  { path: "/viewR/:id", name: "viewBarangKosong", component: viewBarangKosong },

  // laporan barang kosong
  { path: "/barangKosong", name: "barangKosong", component: barangKosong },
  {
    path: "/tambahK/:id",
    name: "tambahBarangKosong",
    component: tambahBarangKosong,
  },
  {
    path: "/editK/:id",
    name: "editBarangKosong",
    component: editBarangKosong,
  },
  { path: "/viewK/:id", name: "viewBarangRusak", component: viewBarangRusak },

  // laporan pesanan barang
  { path: "/pesananBarang", name: "pesananBarang", component: pesananBarang },
  {
    path: "/tambahPesananBarang",
    name: "tambahPesananBarang",
    component: tambahPesananBarang,
  },
  {
    path: "/editP/:id",
    name: "editPesananBarang",
    component: editPesananBarang,
  },
  { path: "/viewP/:id", name: "viewPesanan", component: viewPesanan },

  // barang
  { path: "/barang", name: "barang", component: barang },
  {
    path: "/tambahBarang",
    name: "tambahBarang",
    component: tambahBarang,
  },
  {
    path: "/editB/:id",
    name: "editBarang",
    component: editBarang,
  },
  { path: "/viewB/:id", name: "viewBarang", component: viewBarang },

  //categories
  { path: "/categories", name: "categories", component: categories },
  {
    path: "/tambahCategories",
    name: "tambahCategories",
    component: tambahCategories,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
