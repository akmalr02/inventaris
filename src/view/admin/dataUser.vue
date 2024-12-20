<template>
  <div class="flex items-center mt-4">
    <div class="px-4">
      <router-link to="/tambahUser" class="btn btn-primary mb-3 ml-5">
        <PlusCircleIcon class="size-6 text-error-200-500" />Tambah User
      </router-link>

      <div class="form-control mx-5">
        <input
          type="text"
          placeholder="Search"
          class="input input-bordered w-24 md:w-auto"
          v-model="searchQuery"
        />
      </div>
    </div>
  </div>

  <div class="header">
    <p class="font-bold">Daftar User</p>
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
        <tr v-for="(human, index) in filteredHumans" :key="human.id">
          <th>{{ index + 1 }}</th>
          <td>{{ human.name }}</td>
          <td>{{ human.email }}</td>
          <td>{{ human.role }}</td>
          <td>
            <router-link
              :to="{ name: 'editUser', params: { id: human.id } }"
              class="btn btn-outline btn-warning mbs-2"
            >
              <PencilIcon class="size-6 text-yellow-200-500" />edit
            </router-link>
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
      searchQuery: "", // Tambahkan searchQuery
    };
  },
  created() {
    this.fetchUserData();
  },
  computed: {
    filteredHumans() {
      // Filter berdasarkan name, email, atau role
      return this.humans.filter((human) => {
        const query = this.searchQuery.toLowerCase();
        return (
          human.name.toLowerCase().includes(query) ||
          human.email.toLowerCase().includes(query) ||
          human.role.toLowerCase().includes(query)
        );
      });
    },
  },
  methods: {
    async fetchUserData() {
      try {
        const response = await apiClient.get("/admin", {
          params: {
            search: this.searchQuery, // Kirim query pencarian ke backend
          },
        });
        this.humans = response.data;
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
