<template>
  <div class="navbar bg-neutral-content">
    <div class="flex-none">
      <div v-if="isLoggedIn" class="dropdown">
        <!-- Hamburger Button -->
        <button
          @click="toggleMenu"
          tabindex="0"
          class="btn btn-square btn-ghost"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            class="inline-block h-5 w-5 stroke-current"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            ></path>
          </svg>
        </button>

        <!-- Menu Dropdown -->
        <div
          :class="[
            'fixed top-0 left-0 h-full bg-neutral text-white w-64 transition-transform duration-300 ease-in-out z-20 ',
            isMenuOpen ? 'translate-x-0' : '-translate-x-full',
          ]"
        >
          <!-- Close Button -->
          <button
            @click="toggleMenu"
            class="absolute top-2 right-2 btn btn-white text-xl"
          >
            ✖
          </button>

          <!-- Menu List -->
          <ul class="menu-list p-2 my-5">
            <li class="text-2xl font-bold m-5">Menu</li>
            <hr class="border-t border-gray-500 p-1" />

            <li class="mb-1">
              <router-link
                to="/home"
                class="text-lg transition-colors mx-2 p-2"
                active-class="bg-white text-black rounded-lg"
                ><HomeIcon class="size-6" />Dashboard
              </router-link>
            </li>
            <hr class="border-t border-gray-500 p-1" />
            <li class="mb-1">
              <router-link
                to="/dataUser"
                class="text-lg transition-colors mx-2 p-2"
                active-class="bg-white text-black rounded-lg"
                ><UsersIcon class="size-6" />Data User
              </router-link>
            </li>
            <hr class="border-t border-gray-500 p-1" />

            <li class="mb-1">
              <router-link
                to="/barang"
                class="text-lg transition-colors mx-2 p-2"
                active-class="bg-white text-black rounded-lg"
                ><BriefcaseIcon class="size-6" />Barang
              </router-link>
            </li>
            <hr class="border-t border-gray-500 p-1" />

            <li class="mb-1">
              <router-link
                to="/categories"
                class="text-lg transition-colors mx-2 p-2"
                active-class="bg-white text-black rounded-lg"
                ><BookOpenIcon class="size-6" />Category Barang
              </router-link>
            </li>
            <hr class="border-t border-gray-500 p-1" />

            <li class="mb-1">
              <router-link
                to="/laporan"
                class="text-lg transition-colors mx-2 p-2"
                active-class="bg-white text-black rounded-lg"
                ><DocumentTextIcon class="size-6" />Laporan
              </router-link>
            </li>
            <hr class="border-t border-gray-500 p-1" />

            <!-- Dropdown tombol untuk memilih laporan -->
            <div class="text-lg transition-colors mx-2 p-2 dropdown m-3">
              <button class="dropdown-toggle" @click="toggleDropdown">
                <FolderOpenIcon class="size-6" />Pilih Laporan
              </button>
              <ul
                v-if="isDropdownOpen"
                class="dropdown-menu p-2 shadow rounded-box w-52"
              >
                <li>
                  <router-link
                    to="/barangKosong"
                    class="dropdown-item"
                    active-class="bg-white text-black rounded-lg p-1"
                  >
                    Barang Kosong
                  </router-link>
                </li>
                <li>
                  <router-link
                    to="/barangRusak"
                    class="dropdown-item"
                    active-class="bg-white text-black rounded-lg p-1"
                  >
                    Barang Rusak
                  </router-link>
                </li>
                <li>
                  <router-link
                    to="/pesananBarang"
                    class="dropdown-item"
                    active-class="bg-white text-black rounded-lg p-1"
                  >
                    Pesanan Barang
                  </router-link>
                </li>
              </ul>
            </div>
            <hr class="border-t border-gray-500 p-1" />
          </ul>
        </div>

        <!-- Overlay -->
        <div
          v-if="isMenuOpen"
          @click="closeMenu"
          class="fixed inset-0 bg-danger opacity-50 z-10"
        ></div>
      </div>
    </div>

    <!-- App Title -->
    <div class="flex-1 m-2">
      <router-link v-if="!isLoggedIn" to="/" class="btn btn-white text-xl">
        Inventaris
      </router-link>
      <button v-else @click="homeAdmin" class="btn btn-white text-xl">
        Inventaris
      </button>
    </div>

    <!-- Authentication Links -->
    <div class="navbar-end">
      <router-link v-if="!isLoggedIn" to="/login" class="btn">
        Login
      </router-link>
      <button v-else @click="logout" class="btn">Logout</button>
    </div>
  </div>
</template>

<script>
import {
  UsersIcon,
  DocumentTextIcon,
  HomeIcon,
  FolderOpenIcon,
  BriefcaseIcon,
  BookOpenIcon,
} from "@heroicons/vue/24/solid";
import jwt_decode from "jwt-decode";
import apiClient from "@/service/inventaris";

export default {
  components: {
    UsersIcon,
    DocumentTextIcon,
    HomeIcon,
    FolderOpenIcon,
    BriefcaseIcon,
    BookOpenIcon,
  },
  data() {
    return {
      isLoggedIn: false,
      isMenuOpen: false,
      isDropdownOpen: false,
    };
  },
  created() {
    this.checkAuthStatus();
  },
  mounted() {
    // Set flag saat halaman dimuat ulang
    sessionStorage.setItem("isPageRefreshed", "false");

    // Tambahkan event listener untuk menangani logout saat tab/jendela ditutup
    window.addEventListener("beforeunload", this.handleBeforeUnload);

    // Menangani token expired saat menerima response 401 dari backend
    apiClient.interceptors.response.use(
      (response) => response,
      (error) => {
        if (error.response && error.response.status === 401) {
          this.handleTokenExpired();
        }
        return Promise.reject(error);
      }
    );
  },
  beforeDestroy() {
    // Hapus event listener saat komponen dihancurkan
    window.removeEventListener("beforeunload", this.handleBeforeUnload);
  },
  methods: {
    checkAuthStatus() {
      const token = localStorage.getItem("authToken");

      if (token) {
        // Decode token untuk mendapatkan waktu expired
        const decodedToken = jwt_decode(token); // Menggunakan jwt_decode
        const currentTime = Date.now() / 1000; // waktu sekarang dalam detik

        // Cek apakah token sudah expired
        if (decodedToken.exp < currentTime) {
          // Jika token expired, logout otomatis
          this.handleTokenExpired();
        } else {
          this.isLoggedIn = true;
        }
      } else {
        this.isLoggedIn = false;
      }
    },
    handleTokenExpired() {
      // Hapus token dari localStorage dan arahkan ke halaman login
      localStorage.removeItem("authToken");
      this.isLoggedIn = false;
      this.$router.push({ name: "login" });
    },
    logout() {
      localStorage.removeItem("authToken");
      this.isLoggedIn = false;
      this.$router.push({ name: "login" });
    },
    handleBeforeUnload(event) {
      // Tandai halaman di-refresh
      sessionStorage.setItem("isPageRefreshed", "true");

      // Mengecek apakah halaman benar-benar ditutup
      const isPageRefreshed = sessionStorage.getItem("isPageRefreshed");
      if (isPageRefreshed === "false") {
        // Jika halaman ditutup, hapus token (logout)
        localStorage.removeItem("authToken");
        this.isLoggedIn = false;
      }
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

<style>
.menu-list {
  display: flex;
  flex-direction: column;
  font-size: 0.875rem;
  line-height: 1.25rem;
  padding: 0.5rem;
  max-height: 642px; /* Adjust height as needed */
  overflow-y: auto; /* Enable vertical scrolling */
}

.menu-list::-webkit-scrollbar {
  width: 8px; /* Width of the scrollbar */
}

.menu-list::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.5); /* Color of the scrollbar */
  border-radius: 4px; /* Rounded corners */
}

.menu-list::-webkit-scrollbar-track {
  background: rgba(0, 0, 0, 0.1); /* Background of the scrollbar track */
}

/* Other existing styles remain unchanged */
.menu-list li {
  display: flex;
  flex-direction: column;
  align-items: stretch;
  padding: 0.5rem;
}

.menu-list li:hover {
  background-color: var(--fallback-bc, oklch(var(--bc) / 0.1));
}

.menu-list li.active {
  background-color: var(--fallback-n, oklch(var(--n) / 0.1));
  color: var(--fallback-nc, oklch(var(--nc) / 1));
}

.menu-list li.disabled {
  cursor: not-allowed;
  color: var(--fallback-bc, oklch(var(--bc) / 0.3));
}

.menu-list li > *:not(ul, .baris-title, details, .btn):active,
.menu-list li > *:not(ul, .baris-title, details, .btn).active,
.menu-list li > details > summary:active {
  background-color: var(--fallback-n, oklch(var(--n) / 1));
  color: var(--fallback-nc, oklch(var(--nc) / 1));
}

.z-10 {
  z-index: 10;
}

.z-20 {
  z-index: 20;
}
</style>
