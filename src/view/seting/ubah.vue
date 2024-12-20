<template>
  <div class="flex justify-center items-center min-h-screen mb-6">
    <div class="card bg-base-300 w-96 shadow-xl">
      <div class="card-body">
        <h2 class="flex justify-center card-title text-center">
          Ubah Password
        </h2>
        <form class="card-body pt-3" @submit.prevent="submitForm">
          <div class="form-control">
            <label class="label">
              <span class="label-text">Password Lama</span>
            </label>
            <div class="relative">
              <input
                :type="oldPasswordVisible ? 'text' : 'password'"
                v-model="oldPassword"
                placeholder="Password Lama"
                class="input input-bordered w-full"
                required
              />
              <button
                type="button"
                @click="toggleVisibility('oldPasswordVisible')"
                class="absolute right-2 top-2 btn btn-xs btn-outline"
              >
                <component
                  :is="oldPasswordVisible ? 'XCircleIcon' : 'EyeIcon'"
                  class="w-4 h-4"
                />
              </button>
            </div>
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Password Baru</span>
            </label>
            <div class="relative">
              <input
                :type="newPasswordVisible ? 'text' : 'password'"
                v-model="newPassword"
                placeholder="Password Baru"
                class="input input-bordered w-full"
                required
              />
              <button
                type="button"
                @click="toggleVisibility('newPasswordVisible')"
                class="absolute right-2 top-2 btn btn-xs btn-outline"
              >
                <component
                  :is="newPasswordVisible ? 'XCircleIcon' : 'EyeIcon'"
                  class="w-4 h-4"
                />
              </button>
            </div>
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Confirm Password</span>
            </label>
            <div class="relative">
              <input
                :type="confirmPasswordVisible ? 'text' : 'password'"
                v-model="confirmPassword"
                placeholder="Confirm Password"
                class="input input-bordered w-full"
                required
              />
              <button
                type="button"
                @click="toggleVisibility('confirmPasswordVisible')"
                class="absolute right-2 top-2 btn btn-xs btn-outline"
              >
                <component
                  :is="confirmPasswordVisible ? 'XCircleIcon' : 'EyeIcon'"
                  class="w-4 h-4"
                />
              </button>
            </div>
          </div>

          <div class="form-control mt-2">
            <button class="btn btn-primary p-3 mb-2" type="submit">
              Submit
            </button>
            <router-link to="/profil" class="btn btn-primary p-3">
              Back
            </router-link>
          </div>
        </form>
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
      oldPassword: "",
      newPassword: "",
      confirmPassword: "",
      oldPasswordVisible: false,
      newPasswordVisible: false,
      confirmPasswordVisible: false,
    };
  },
  setup() {
    const authStore = useAuthStore();
    return { authStore };
  },
  methods: {
    toggleVisibility(field) {
      this[field] = !this[field];
    },
    async submitForm() {
      if (this.newPassword !== this.confirmPassword) {
        toast.error("Password baru dan konfirmasi password tidak cocok!");
        return;
      }

      try {
        const id = this.authStore.user.id; // Ambil ID user dari authStore
        await apiClient.post(`/profil/${id}/ganti-password`, {
          current_password: this.oldPassword,
          password: this.newPassword,
          password_confirmation: this.confirmPassword,
        });
        toast.success("Password berhasil diubah!");
      } catch (error) {
        const errorMessage =
          error.response?.data?.error || "Terjadi kesalahan.";
        toast.error(errorMessage);
      }
    },
  },
};
</script>
