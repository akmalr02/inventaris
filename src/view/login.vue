<template>
  <div class="item-center">
    <div class="hero dashboard-container h-screen">
      <div class="hero-content flex-col lg:flex-row-reverse">
        <div
          class="card bg-base-200 w-full max-w-sm shrink-0 shadow-2xl animate-fade-in"
        >
          <form class="card-body" @submit.prevent="login">
            <div class="form-control">
              <label class="label">
                <span class="label-text">Email</span>
              </label>
              <input
                v-model="email"
                type="email"
                placeholder="Email"
                class="input input-bordered"
                required
              />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Password</span>
              </label>
              <div class="relative">
                <input
                  :type="passwordVisible ? 'text' : 'password'"
                  v-model="password"
                  placeholder="Password"
                  class="input input-bordered w-full"
                  required
                />
                <button
                  type="button"
                  @click="togglePasswordVisibility"
                  class="absolute right-2 top-2 btn btn-xs btn-outline"
                >
                  <component
                    :is="passwordVisible ? 'XCircleIcon' : 'EyeIcon'"
                    class="w-4 h-4"
                  />
                </button>
              </div>
            </div>
            <div class="form-control mt-6">
              <button class="btn btn-primary" type="submit">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import apiClient from "@/service/inventaris";
import { EyeIcon, XCircleIcon } from "@heroicons/vue/24/solid";
import { useAuthStore } from "@/stores/authStore";

export default {
  components: {
    EyeIcon,
    XCircleIcon,
  },
  data() {
    return {
      email: "",
      password: "",
      passwordVisible: false,
    };
  },
  setup() {
    const authStore = useAuthStore(); // Gunakan store untuk autentikasi
    return { authStore };
  },
  methods: {
    togglePasswordVisibility() {
      this.passwordVisible = !this.passwordVisible;
    },
    async login() {
      try {
        const response = await apiClient.post("/login", {
          email: this.email,
          password: this.password,
        });

        // console.log(this.email);
        // console.log(response.data);

        const token = response.data.token;
        const user = response.data.user;

        // console.log(token);
        // console.log(user);

        // alert(user.name);

        this.authStore.login(user, token);

        if (user.role === "admin" || user.role === "pengelola") {
          this.$router.push({ name: "home" }); // Route untuk admin dan pengelola
        } else if (user.role === "pemakai") {
          this.$router.push({ name: "homePengguna" });
        } else {
          // Jika role tidak dikenali, arahkan ke halaman default
          this.$router.push({ name: "login" });
        }

        // console.log(user);
      } catch (error) {
        console.error(
          "Login failed:",
          error.response ? error.response.data : error.message
        );
        this.notifGagal();
      }
    },
    checkAuthStatus() {
      const token = localStorage.getItem("authToken");
      this.isLoggedIn = !!token;
    },
    notifGagal() {
      toast("Email atau password salah", {
        autoClose: 3000,
      });
    },
  },
};
</script>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.animate-fade-in {
  animation: fadeIn 1s ease-in-out;
}

.dashboard-container {
  background-image: url("/img/libry3.jpg");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
</style>
