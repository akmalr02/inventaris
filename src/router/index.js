import { createRouter, createWebHistory } from "vue-router";
import Login from "@/view/login.vue";
import coba from "@/view/coba.vue";

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

// laporoan barang rusak

import barangRusak from "@/view/laporan/barang_rusak/barangRusak.vue";
import tambahBarangRusak from "@/view/laporan/barang_rusak/tambah.vue";
import editBarangRusak from "@/view/laporan/barang_rusak/edit.vue";

// laporoan pesanan barnag
import pesananBarang from "@/view/laporan/pesanan/pesananBarang.vue";
import editPesananBarang from "@/view/laporan/pesanan/edit.vue";
import tambahPesananBarang from "@/view/laporan/pesanan/tambah.vue";

// barang
import barang from "@/view/pengelola/barang.vue";

const routes = [
  { path: "/login", name: "login", component: Login },
  { path: "/coba", name: "coba", component: coba },

  // Dashboard
  { path: "/", name: "dashboard", component: Dashboard },
  { path: "/home", name: "homeAdmin", component: admin },

  // akses admin user
  { path: "/dataUser", name: "dataUser", component: dataUser },
  { path: "/laporan", name: "laporan", component: laporan },
  { path: "/editUser/:id", name: "editUser", component: editUser },
  { path: "/tambahUser", name: "tambahUser", component: tambahUser },

  // laporan barang rusak
  { path: "/barangRusak", name: "barangRusak", component: barangRusak },
  {
    path: "/tambahBarangRusak",
    name: "tambahBarangRusak",
    component: tambahBarangRusak,
  },
  {
    path: "/edit/:id",
    name: "editBarangRusak",
    component: editBarangRusak,
  },

  // laporan barang kosong

  { path: "/barangKosong", name: "barangKosong", component: barangKosong },
  {
    path: "/tambahbarangKosong",
    name: "tambahBarangKosong",
    component: tambahBarangKosong,
  },
  {
    path: "/edit/:id",
    name: "editBarangKosong",
    component: editBarangKosong,
  },

  // laporan pesanan barang

  { path: "/pesananBarang", name: "pesananBarang", component: pesananBarang },
  {
    path: "/tambahPesananBarang",
    name: "tambahPesananBarang",
    component: tambahPesananBarang,
  },
  {
    path: "/edit/:id",
    name: "editPesananBarang",
    component: editPesananBarang,
  },

  { path: "/barang", name: "barang", component: barang },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
