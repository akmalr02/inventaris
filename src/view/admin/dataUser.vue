<template>
  <div class="flex justify-between items-center mt-4">
    <router-link to="/tambahUser" class="btn btn-primary mb-3 ml-5">
      <PlusCircleIcon class="size-6 text-error-200-500" />Tambah User
    </router-link>
    <div class="flex-grow"></div>
    <div class="form-control mx-auto">
      <input
        type="text"
        placeholder="Search"
        class="input input-bordered w-24 md:w-auto"
      />
    </div>
    <div class="flex-grow"></div>
  </div>

  <div class="overflow-x-auto m-9">
    <table class="table">
      <!-- head -->
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="human in humans" :key="human.id">
          <th>{{ human.id }}</th>
          <td>{{ human.name }}</td>
          <td>{{ human.email }}</td>
          <td>{{ human.role }}</td>
          <td>
            <router-link
              :to="{ name: 'editUser', params: { id: human.id } }"
              class="btn btn-outline btn-warning mbs-2"
              ><PencilIcon
                class="size-6 text-yellow-200-500"
              />edit</router-link
            >
            <form @submit.prevent="confirmDelete(human.id)">
              <button type="submit" class="btn btn-outline btn-error mt-3">
                <TrashIcon class="size-6 text-error-200-500" />Delete
              </button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import apiClient from "@/service/inventaris";
import { PencilIcon, TrashIcon, PlusCircleIcon } from "@heroicons/vue/24/solid";

export default {
  components: {
    PencilIcon,
    TrashIcon,
    PlusCircleIcon,
  },
  data() {
    return {
      humans: [],
    };
  },
  created() {
    this.fetchUserData();
  },
  methods: {
    async fetchUserData() {
      try {
        const response = await apiClient.get("/admin");
        this.humans = response.data;
        // console.log(this.humans);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    },
    confirmDelete(id) {
      if (window.confirm("Apakah Anda yakin ingin menghapus user ini?")) {
        this.deleteUser(id);
      }
    },
    async deleteUser(id) {
      try {
        await apiClient.delete(`/admin/${id}`);
        this.fetchUserData();
      } catch (error) {
        if (error.response && error.response.status === 401) {
          this.handleExpiredToken();
        } else {
          console.error("Error deleting user:", error);
        }
      }
    },
  },
};
</script>
