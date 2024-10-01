<style></style>

<template>
  <div>
    <h1>hallo</h1>
  </div>
</template>

<script>
import {
  UsersIcon,
  DocumentTextIcon,
  HomeIcon,
  FolderOpenIcon,
  BriefcaseIcon,
} from "@heroicons/vue/24/solid";

export default {
  components: {
    UsersIcon,
    DocumentTextIcon,
    HomeIcon,
    FolderOpenIcon,
    BriefcaseIcon,
  },
  data() {
    return {
      isLoggedIn: false,
      isMenuOpen: false,
      isDropdownOpen: false,
      tokenCheckInterval: null, // Interval untuk mengecek token
    };
  },
  created() {
    this.checkAuthStatus();
  },
  mounted() {
    // Tandai halaman dimuat untuk pertama kali
    sessionStorage.setItem("isPageRefreshed", "false");

    // Menambahkan event listener untuk sebelum halaman ditutup
    window.addEventListener("beforeunload", this.handleBeforeUnload);

    // Cek status token setiap 1 detik
    this.tokenCheckInterval = setInterval(() => {
      this.checkAuthStatus();
    }, 1000);
  },
  beforeDestroy() {
    // Hapus event listener dan interval sebelum komponen dihancurkan
    window.removeEventListener("beforeunload", this.handleBeforeUnload);
    clearInterval(this.tokenCheckInterval);
  },
  methods: {
    checkAuthStatus() {
      const token = localStorage.getItem("authToken");
      if (!token || this.isTokenExpired(token)) {
        this.isLoggedIn = false;
        localStorage.removeItem("authToken");
      } else {
        this.isLoggedIn = true;
      }
    },
    isTokenExpired(token) {
      try {
        const payload = JSON.parse(atob(token.split(".")[1]));
        return payload.exp * 1000 < Date.now(); // Cek apakah token sudah kadaluarsa
      } catch (error) {
        return true; // Jika token rusak, anggap sudah tidak valid
      }
    },
    logout() {
      localStorage.removeItem("authToken");
      this.isLoggedIn = false;
      this.$router.push({ name: "login" });
    },
    handleBeforeUnload(event) {
      // Tandai halaman sedang dimuat ulang atau ditutup
      sessionStorage.setItem("isPageRefreshed", "true");

      // Tunggu sebentar untuk memastikan browser mendeteksi apakah itu reload atau tab ditutup
      setTimeout(() => {
        const isPageRefreshed = sessionStorage.getItem("isPageRefreshed");
        if (isPageRefreshed === "false") {
          // Jika halaman ditutup, hapus token
          localStorage.removeItem("authToken");
        }
      }, 0);
    },
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
    closeMenu() {
      this.isMenuOpen = false;
    },
    homeAdmin() {
      this.$router.push({ name: "homeAdmin" });
    },
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
  },
  watch: {
    $route() {
      this.checkAuthStatus();
    },
  },
};
</script>
