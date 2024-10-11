import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null, // Untuk menyimpan informasi user
  }),
  getters: {
    isAuthenticated: (state) => !!state.user, // Cek apakah user sudah login
    userRole: (state) => (state.user ? state.user.role : null), // Ambil role user
  },
  actions: {
    login(user) {
      this.user = user; // Set user yang login
      localStorage.setItem("user", JSON.stringify(user)); // Simpan user di localStorage
    },
    logout() {
      this.user = null; // Logout
      localStorage.removeItem("user"); // Hapus user dari localStorage
    },
    loadUserFromLocalStorage() {
      const storedUser = localStorage.getItem("user");
      if (storedUser) {
        this.user = JSON.parse(storedUser); // Set user dari localStorage jika ada
      }
    },
  },
});
