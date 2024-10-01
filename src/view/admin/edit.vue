<style>
.content_image {
  display: flex;
  width: max-content;
  gap: 1rem;
}

.horizontal_scroll {
  width: 100%;
  overflow-x: scroll;
  scrollbar-color: transparent transparent;
}

.horizontal_scroll::-webkit-scrollbar {
  display: none;
}

.error-message {
  color: red;
  font-weight: bold;
  margin-top: 0.5rem;
}

.form-control {
  margin-bottom: 1rem;
}
</style>

<template>
  <div class="flex justify-center items-center min-h-screen mb-6">
    <div class="card bg-base-300 w-96 shadow-xl">
      <div class="card-body">
        <h2 class="flex justify-center card-title text-center">Edit User</h2>
        <form class="card-body pt-3" @submit.prevent="updateUser">
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

<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import apiClient from "@/service/inventaris";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const route = useRoute();
const router = useRouter();
const name = ref("");
const email = ref("");
const role = ref("");
const phone = ref("");
const errors = ref([]);

onMounted(async () => {
  try {
    const response = await apiClient.get(`/admin/${route.params.id}`);
    const user = response.data;
    // console.log(user);
    name.value = user.name;
    email.value = user.email;
    role.value = user.role;
    phone.value = user.phone;
  } catch (error) {
    // console.error("Error fetching user data:", error);
    toast.error("Gagal mengambil data user.", { autoClose: 3000 });
  }
});

const updateUser = async () => {
  try {
    let formData = new FormData();
    formData.append("name", name.value);
    formData.append("email", email.value);
    formData.append("role", role.value);
    formData.append("phone", phone.value);
    formData.append("_method", "PATCH");
    console.log(role.value);
    await apiClient
      .post(`/admin/${route.params.id}`, formData)
      .then(() => {
        toast.success("Data user berhasil diperbarui!", { autoClose: 3000 });
        router.push({ name: "dataUser" });
      })
      .catch((error) => {
        // console.log("Error response:", error.response.data);
        if (error.response && error.response.data.errors) {
          errors.value = error.response.data.errors;
          toast.error("Gagal memperbarui data user.", { autoClose: 3000 });
        } else {
          toast.error("Terjadi kesalahan saat memperbarui data.", {
            autoClose: 3000,
          });
        }
      });
  } catch (error) {
    // console.error("Error updating user data:", error);
    toast.error("Terjadi kesalahan saat memperbarui data.", {
      autoClose: 3000,
    });
  }
};
</script>
