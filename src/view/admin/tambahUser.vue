<style></style>
<template>
  <div class="flex justify-center items-center min-h-screen mb-6">
    <div class="card bg-base-300 w-96 shadow-xl">
      <div class="card-body">
        <h2 class="flex justify-center card-title text-center">Tambah User</h2>
        <form class="card-body pt-3" @submit.prevent="tambahUser">
          <div class="form-control">
            <label class="label">
              <span class="label-text">Nama</span>
            </label>
            <input
              v-model="name"
              type="text"
              placeholder="Name"
              class="input input-bordered"
              required
            />
            <div v-if="errors.name" class="error-message">
              <span>{{ errors.name[0] }}</span>
            </div>
          </div>

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
            <div v-if="errors.email" class="error-message">
              <span>{{ errors.email[0] }}</span>
            </div>
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Role</span>
            </label>
            <select v-model="role" class="select select-bordered" required>
              <option value="" disabled>Pilih Role</option>
              <option value="admin">Admin</option>
              <option value="pengelola">Pengelola</option>
              <option value="pemakai">Pemakai</option>
            </select>
            <div v-if="errors.role" class="error-message">
              <span>{{ errors.role[0] }}</span>
            </div>
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Phone Number</span>
            </label>
            <input
              v-model="phone"
              type="text"
              inputmode="numeric"
              placeholder="Phone Number"
              class="input input-bordered"
              required
            />
            <div v-if="errors.phone" class="error-message">
              <span>{{ errors.phone[0] }}</span>
            </div>
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
                  :is="passwordConfirmVisible ? 'XCircleIcon' : 'EyeIcon'"
                  class="w-4 h-4"
                />
              </button>
            </div>
            <label
              for="password"
              class="text-error font-bold"
              v-if="passwordError"
            >
              Minimal password 8 karakter
            </label>
            <div v-if="errors.password" class="text-red-500">
              {{ errors.password }}
            </div>
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text">Konfirmasi Password</span>
            </label>
            <div class="relative">
              <input
                :type="passwordConfirmVisible ? 'text' : 'password'"
                v-model="password_confirmation"
                placeholder="Konfirmasi Password"
                class="input input-bordered w-full"
                required
              />
              <button
                type="button"
                @click="toggleConfirmPasswordVisibility"
                class="absolute right-2 top-2 btn btn-xs btn-outline"
              >
                <component
                  :is="passwordConfirmVisible ? 'XCircleIcon' : 'EyeIcon'"
                  class="w-4 h-4"
                />
              </button>
            </div>
            <label
              for="password_confirmation"
              class="text-error font-bold"
              v-if="confirmPasswordError"
            >
              Password tidak sama
            </label>
            <div v-if="errors.password_confirmation" class="text-red-500">
              {{ errors.password_confirmation }}
            </div>
          </div>

          <div class="form-control mt-2">
            <button class="btn btn-primary p-3 mb-2" type="submit">
              Submit
            </button>
            <router-link to="/dataUser" class="btn btn-primary p-3">
              Back
            </router-link>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import apiClient from "@/service/inventaris";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { EyeIcon, XCircleIcon } from "@heroicons/vue/24/solid";

export default {
  components: {
    EyeIcon,
    XCircleIcon,
  },
  data() {
    return {
      name: "",
      email: "",
      role: "",
      phone: "",
      password: "",
      password_confirmation: "",
      errors: {},
      passwordError: false,
      confirmPasswordError: false,
      passwordVisible: false,
      passwordConfirmVisible: false,
    };
  },
  watch: {
    password(value) {
      this.passwordError = value.length < 8;
      this.validateConfirmPassword();
    },
    password_confirmation(value) {
      this.validateConfirmPassword();
    },
  },
  methods: {
    togglePasswordVisibility() {
      this.passwordVisible = !this.passwordVisible;
    },
    toggleConfirmPasswordVisibility() {
      this.passwordConfirmVisible = !this.passwordConfirmVisible;
    },
    resetForm() {
      this.name = "";
      this.email = "";
      this.role = "";
      this.phone = "";
      this.password = "";
      this.password_confirmation = "";
      this.errors = {};
    },
    validateConfirmPassword() {
      this.confirmPasswordError = this.password_confirmation !== this.password;
    },
    async tambahUser() {
      this.errors = {};
      try {
        const response = await apiClient.post("/admin", {
          name: this.name,
          email: this.email,
          password: this.password,
          role: this.role,
          phone: this.phone,
          password_confirmation: this.password_confirmation,
        });
        // console.log(response);
        toast.success("Berhasil tambah data user", { autoClose: 3000 });
        this.resetForm();
      } catch (error) {
        if (
          error.response &&
          error.response.data &&
          error.response.data.errors
        ) {
          this.errors = error.response.data.errors;
        }
        toast.error("Gagal menambah data user!!", { autoClose: 3000 });
      }
    },
  },
};
</script>
