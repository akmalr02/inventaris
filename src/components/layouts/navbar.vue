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
            'fixed top-0 left-0 h-full bg-neutral text-white w-64 transition-transform duration-300 ease-in-out z-20',
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
          <ul class="menu p-4">
            <li class="text-2xl font-bold mb-2">Menu</li>
            <hr class="border-t border-gray-500 mb-4" />
            <li>
              <router-link to="/home" class="text-lg">Dashboard ></router-link>
            </li>
            <hr class="border-t border-gray-500 mb-4" />
            <li>
              <router-link to="/dataUser" class="text-lg"
                >Data User ></router-link
              >
            </li>
            <li>
              <router-link to="/laporan" class="text-lg">Laporan ></router-link>
            </li>
          </ul>
        </div>
        <!-- Overlay -->
        <div
          v-if="isMenuOpen"
          @click="closeMenu"
          class="fixed inset-0 bg-black opacity-50 z-10"
        ></div>
      </div>
    </div>

    <!-- App Title -->
    <div class="flex-1 m-2">
      <router-link to="/" class="btn btn-white text-xl">inventaris</router-link>
    </div>

    <!-- Authentication Links -->
    <div class="navbar-end">
      <router-link v-if="!isLoggedIn" to="/login" class="btn"
        >Login</router-link
      >
      <button v-else @click="logout" class="btn">Logout</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isLoggedIn: false,
      isMenuOpen: false,
    };
  },
  created() {
    this.checkAuthStatus();
  },
  methods: {
    checkAuthStatus() {
      const token = localStorage.getItem("authToken");
      this.isLoggedIn = !!token;
    },
    logout() {
      localStorage.removeItem("authToken");
      this.isLoggedIn = false;
      this.$router.push({ name: "login" });
    },
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
    closeMenu() {
      this.isMenuOpen = false;
    },
  },
  watch: {
    $route() {
      this.checkAuthStatus();
    },
  },
};
</script>

<style scoped>
/* Mengatur overlay dan menu agar tampil sesuai */
.z-10 {
  z-index: 10;
}

.z-20 {
  z-index: 20;
}

.z-0 {
  z-index: 0;
}
</style>
