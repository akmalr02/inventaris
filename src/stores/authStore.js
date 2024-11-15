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
      localStorage.setItem("user", JSON.stringify(user)); // Simpan user sebagai JSON string
      localStorage.setItem("authToken", token); // Simpan token di localStorage
      localStorage.setItem("userRole", user.role); // Simpan role di localStorage
    },
    logout() {
      this.user = null; // Kosongkan pengguna saat logout
      this.token = null; // Kosongkan token saat logout
      this.role = null; // Kosongkan role saat logout
      localStorage.removeItem("authToken"); // Hapus token dari localStorage
      localStorage.removeItem("userRole"); // Hapus role dari localStorage
      localStorage.removeItem("user"); // Hapus user dari localStorage
    },
    loadUserFromLocalStorage() {
      const token = localStorage.getItem("authToken");
      const userRole = localStorage.getItem("userRole");
      const user = localStorage.getItem("user");

      if (token) {
        this.token = token; // Set token jika ada
      }
      if (userRole) {
        this.role = userRole; // Set role jika ada
      }
      if (user) {
        this.user = JSON.parse(user); // Parse JSON string menjadi objek
      }
    },
    updateUser(updatedUser) {
      this.user = updatedUser; // Perbarui data user di state
      this.role = updatedUser.role; // Perbarui role di state jika role juga berubah
      localStorage.setItem("user", JSON.stringify(updatedUser)); // Simpan perubahan ke localStorage
      localStorage.setItem("userRole", updatedUser.role); // Simpan perubahan role jika ada
    },
    getRole() {
      return this.role; // Mengambil role dari store atau localStorage
    },
  },
});
