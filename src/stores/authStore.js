// stores/authStore.js
import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null, // Menyimpan informasi pengguna
    token: null, // Menyimpan token
    role: null, // Menyimpan role
  }),
  actions: {
    login(user, token) {
      this.user = user; // Simpan pengguna
      this.token = token; // Simpan token
      this.role = user.role; // Simpan role
      localStorage.setItem("authToken", token); // Simpan token di localStorage
      localStorage.setItem("userRole", user.role); // Simpan role di localStorage
    },
    logout() {
      this.user = null; // Kosongkan pengguna saat logout
      this.token = null; // Kosongkan token saat logout
      this.role = null; // Kosongkan role saat logout
      localStorage.removeItem("authToken"); // Hapus token dari localStorage
      localStorage.removeItem("userRole"); // Hapus role dari localStorage
    },
    loadUserFromLocalStorage() {
      const token = localStorage.getItem("authToken");
      const userRole = localStorage.getItem("userRole");
      if (token) {
        this.token = token; // Set token jika ada
      }
      if (userRole) {
        this.role = userRole; // Set role jika ada
      }
    },
    getRole() {
      return this.role; // Mengambil role dari store atau localStorage
    },
  },
});
