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

export default {
  components: {
    EyeIcon,
    XCircleIcon,
  },
  data() {
    return {
      email: "admin@example.com",
      password: "",
      passwordVisible: false,
    };
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
        // console.log(response);

        const token = response.data.token;
        localStorage.setItem("authToken", token);
        this.checkAuthStatus();
        this.$router.push({ name: "homeAdmin" });
      } catch (error) {
        this.notifGagal();
      }
    },
    checkAuthStatus() {
      const token = localStorage.getItem("authToken");
      this.isLoggedIn = !!token;
    },
    notifGagal() {
      toast("Email atau password salah", {
        autoClose: 1000,
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
