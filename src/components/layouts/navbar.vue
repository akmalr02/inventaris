<template>
  <div v-if="!hideNavbar" class="navbar bg-neutral-content">
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

          <ul class="menu-list p-2 my-5">
            <li class="text-2xl font-bold m-5">Menu</li>
            <hr class="border-t border-gray-500 p-1" />

            <!-- Menu List user -->
            <li v-if="userRole === 'pemakai'" class="mb-1">
              <router-link
                to="/pengguna"
                class="text-lg transition-colors mx-2 p-2"
                active-class="bg-white text-black rounded-lg"
                ><HomeIcon class="size-6" />Dashboard
              </router-link>
            </li>

            <!-- dashboard admin dan pengelola -->
            <li
              v-if="userRole === 'admin' || userRole === 'pengelola'"
              class="mb-1"
            >
              <router-link
                to="/home"
                class="text-lg transition-colors mx-2 p-2"
                active-class="bg-white text-black rounded-lg"
                ><HomeIcon class="size-6" />Dashboard
              </router-link>
            </li>
            <hr class="border-t border-gray-500 p-1" />

            <!-- Menu List user -->
            <li v-if="userRole === 'pemakai'" class="mb-1">
              <router-link
                to="/pesanan"
                class="text-lg transition-colors mx-2 p-2"
                active-class="bg-white text-black rounded-lg"
                ><ShoppingCartIcon class="size-6" />Pesanan Saya
              </router-link>
            </li>

            <!-- Data user hanya untuk admin -->
            <li v-if="userRole === 'admin'" class="mb-1">
              <router-link
                to="/dataUser"
                class="text-lg transition-colors mx-2 p-2"
                active-class="bg-white text-black rounded-lg"
                ><UsersIcon class="size-6" />Data User
              </router-link>
            </li>
            <hr
              v-if="userRole === 'admin'"
              class="border-t border-gray-500 p-1"
            />

            <!-- barang untuk admin dan pengelola -->
            <li v-if="userRole === 'admin'" class="mb-1">
              <router-link
                to="/barang"
                class="text-lg transition-colors mx-2 p-2"
                active-class="bg-white text-black rounded-lg"
                ><BriefcaseIcon class="size-6" />Barang
              </router-link>
            </li>
            <hr class="border-t border-gray-500 p-1" />

            <!-- category hanya untuk admin dan pengelola -->
            <li
              v-if="userRole === 'admin' || userRole === 'pengelola'"
              class="mb-1"
            >
              <router-link
                to="/categories"
                class="text-lg transition-colors mx-2 p-2"
                active-class="bg-white text-black rounded-lg"
                ><BookOpenIcon class="size-6" />Category Barang
              </router-link>
            </li>
            <hr
              v-if="userRole === 'admin' || userRole === 'pengelola'"
              class="border-t border-gray-500 p-1"
            />

            <!-- laporan hanya untuk admin dan pengelola -->
            <li
              v-if="userRole === 'admin' || userRole === 'pengelola'"
              class="mb-1"
            >
              <router-link
                to="/laporan"
                class="text-lg transition-colors mx-2 p-2"
                active-class="bg-white text-black rounded-lg"
                ><DocumentTextIcon class="size-6" />Laporan
              </router-link>
            </li>
            <hr
              v-if="userRole === 'admin' || userRole === 'pengelola'"
              class="border-t border-gray-500 p-1"
            />

            <!-- Dropdown tombol untuk memilih laporan hanya untuk admin dan pengelola -->
            <div
              v-if="userRole === 'admin' || userRole === 'pengelola'"
              class="text-lg transition-colors mx-2 p-2 dropdown m-3"
            >
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
            <hr
              v-if="userRole === 'admin' || userRole === 'pengelola'"
              class="border-t border-gray-500 p-1"
            />
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

    <!-- tombol dropdown account -->
    <div class="flex flex-1 justify-end px-2">
      <div class="flex items-stretch">
        <!-- Profil Dropdown -->
        <div class="dropdown dropdown-end" v-if="isLoggedIn">
          <div
            tabindex="0"
            role="button"
            class="btn btn-ghost rounded-btn flex items-center space-x-2"
          >
            <!-- Avatar -->
            <div class="avatar p-1">
              <div
                class="ring-current ring-offset-base-100 w-10 h-10 rounded-full ring ring-offset-1"
              >
                <img
                  :src="imagePreviewUrl + '?v=' + new Date().getTime()"
                  alt="Profil"
                />
              </div>
            </div>

            <!-- Nama Pengguna -->
            <span
              class="hidden sm:block text-sm font-medium truncate max-w-[150px]"
            >
              {{ user.name ?? "-" }}
            </span>
          </div>

          <!-- Dropdown Menu -->
          <ul
            tabindex="0"
            class="menu dropdown-content bg-base-100 rounded-box z-[1] mt-4 w-52 p-2 shadow"
          >
            <li>
              <router-link to="/profil"
                ><IdentificationIcon class="size-6" /> Your Profile
              </router-link>
            </li>
            <li>
              <button @click="logout" class="btn bg-error">Logout</button>
            </li>
          </ul>
        </div>

        <!-- Login Button -->
        <router-link v-if="!isLoggedIn" to="/login" class="btn">
          Login
        </router-link>
      </div>
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
  IdentificationIcon,
  ShoppingCartIcon,
} from "@heroicons/vue/24/solid";
import jwt_decode from "jwt-decode";
import apiClient from "@/service/inventaris";
import { useAuthStore } from "@/stores/authStore";

export default {
  components: {
    UsersIcon,
    DocumentTextIcon,
    HomeIcon,
    FolderOpenIcon,
    BriefcaseIcon,
    BookOpenIcon,
    IdentificationIcon,
    ShoppingCartIcon,
  },
  data() {
    return {
      isLoggedIn: false,
      isMenuOpen: false,
      isDropdownOpen: false,
      userRole: null,
      hideNavbar: false,
      lokasi: "http://inventaris.test/storage",
      imagePreviewUrl: null,
    };
  },
  computed: {
    authStore() {
      return useAuthStore(); // Mengambil seluruh data dari Pinia
    },
    user() {
      return this.authStore.user; // Mengakses data user secara keseluruhan
    },
  },

  created() {
    this.checkAuthStatus();
  },
  mounted() {
    sessionStorage.setItem("isPageRefreshed", "false");

    window.addEventListener("beforeunload", this.handleBeforeUnload);

    apiClient.interceptors.response.use(
      (response) => response,
      (error) => {
        if (error.response && error.response.status === 401) {
          this.handleTokenExpired();
        }
        return Promise.reject(error);
      }
    );
    this.checkRoute();
  },
  beforeDestroy() {
    window.removeEventListener("beforeunload", this.handleBeforeUnload);
  },
  watch: {
    // Perbarui imagePreviewUrl ketika image berubah
    image: {
      immediate: true,
      handler(newImage) {
        this.updateImagePreview(newImage);
      },
    },
    $route() {
      this.checkAuthStatus();
      this.checkRoute();
    },
  },
  methods: {
    checkAuthStatus() {
      const token = localStorage.getItem("authToken");
      if (token) {
        try {
          const decodedToken = jwt_decode(token);
          const currentTime = Date.now() / 1000;
          if (decodedToken.exp < currentTime) {
            this.handleTokenExpired();
          } else {
            this.isLoggedIn = true;
            this.userRole = this.authStore.getRole();
            this.updateImagePreview(this.authStore.user.image);
          }
        } catch (error) {
          this.isLoggedIn = false;
        }
      } else {
        this.isLoggedIn = false;
      }
    },
    checkRoute() {
      const currentRoute = this.$route.name;
      const hiddenRoutes = ["error404"];
      this.hideNavbar = hiddenRoutes.includes(currentRoute);
    },
    handleTokenExpired() {
      localStorage.removeItem("authToken");
      this.isLoggedIn = false;
      this.userRole = null;
      this.$router.push({ name: "login" });
    },
    logout() {
      localStorage.removeItem("authToken");
      this.isLoggedIn = false;
      this.userRole = null;
      this.$router.push({ name: "login" });
    },
    handleBeforeUnload(event) {
      sessionStorage.setItem("isPageRefreshed", "true");

      const isPageRefreshed = sessionStorage.getItem("isPageRefreshed");
      if (isPageRefreshed === "false") {
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
      if (this.userRole === "admin" || this.userRole === "pengelola") {
        this.$router.push({ name: "home" });
      } else if (this.userRole === "pemakai") {
        this.$router.push({ name: "homePengguna" });
      }
    },
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    updateImagePreview(newImage) {
      // Pastikan newImage bukan null, kosong, atau string yang tidak valid
      if (newImage && newImage !== "null" && newImage !== "[]") {
        try {
          let images = JSON.parse(newImage);

          // Jika images adalah array dan memiliki elemen
          if (Array.isArray(images) && images.length > 0) {
            this.imagePreviewUrl = `${this.lokasi}/${images[0]}`.replace(
              /[\[\]"]/g,
              ""
            );
          } else {
            this.imagePreviewUrl = "/img/profil.jpg"; // Menampilkan gambar default
          }
        } catch (error) {
          // Jika JSON.parse gagal, fallback ke gambar default
          this.imagePreviewUrl = "/img/profil.jpg";
        }
      } else {
        // Jika newImage null atau kosong
        this.imagePreviewUrl = "/img/profil.jpg";
      }
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
