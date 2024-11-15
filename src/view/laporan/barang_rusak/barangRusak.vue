<style scoped>
.table {
  width: 100%;
  border-collapse: collapse;
}

.table th,
.table td {
  padding: 8px;
  border: 1px solid #ddd;
  text-align: left;
}

.header {
  display: flex;
  justify-content: center;
  margin: 1rem;
}
</style>

<template>
  <div class="overflow-x-auto m-9">
    <div class="px-4">
      <div class="header">
        <p class="font-bold">Laporan barang Rusak</p>
      </div>
    </div>
    <table class="table">
      <!-- head -->
      <thead>
        <tr>
          <th class="text-black">No</th>
          <th class="text-black">Nama User</th>
          <th class="text-black">Nama Barang</th>
          <th class="text-black">Descripsi</th>
          <th class="text-black">Jumlah Barnag</th>
          <th class="text-black">Tanggal</th>
          <th v-if="userRole === 'admin'" class="text-black">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(laporan, index) in barangRusak" :key="laporan.id">
          <th>{{ index + 1 }}</th>
          <td>
            <!-- Tampilkan nama user jika ada -->
            {{ laporan.user?.name ?? "-" }}
          </td>
          <td>
            <!-- Tampilkan nama barang jika ada -->
            {{ laporan.barang?.name ?? "-" }}
          </td>
          <td>
            <!-- Tampilkan description jika ada -->
            {{ laporan.description ?? "-" }}
          </td>
          <td>
            <!-- Tampilkan jumlah jika ada -->
            {{ laporan.jumlah_rusak ?? "-" }}
          </td>
          <td>
            <!-- Tampilkan tanggal jika ada -->
            {{ laporan.tanggal ?? "-" }}
          </td>
          <td v-if="userRole === 'admin'">
            <router-link
              :to="{ name: 'editBarangRusak', params: { id: laporan.id } }"
              class="btn btn-outline btn-warning mbs-2"
              ><PencilIcon
                class="size-6 text-yellow-200-500"
              />edit</router-link
            >
            <form @submit.prevent="confirmDelete(laporan.id)">
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
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { useAuthStore } from "@/stores/authStore";
import {
  TrashIcon,
  PencilIcon,
  BackspaceIcon,
  PlusCircleIcon,
} from "@heroicons/vue/24/solid";

export default {
  components: {
    TrashIcon,
    PencilIcon,
    BackspaceIcon,
    PlusCircleIcon,
  },
  data() {
    return {
      barangRusak: [],
      userRole: "",
    };
  },
  created() {
    this.checkAuthStatus();
    this.getBarangRusak();
  },
  methods: {
    async checkAuthStatus() {
      const authStore = useAuthStore();
      this.userRole = authStore.getRole();
    },
    async getBarangRusak() {
      try {
        const response = await apiClient.get("/barangRusak");
        this.barangRusak = response.data;
        // console.log(this.barangRusak);
      } catch (error) {
        console.error("Error:", error);
      }
    },

    confirmDelete(id) {
      if (window.confirm("Apakah Anda yakin ingin menghapus Laporan ini?")) {
        this.deleteLaporan(id);
      }
    },

    async deleteLaporan(id) {
      try {
        await apiClient.delete(`/barangRusak/${id}`);
        this.getBarangRusak();
        toast.success("Data berhasil dihapus.", { autoClose: 3000 });
      } catch (error) {
        console.error("Error deleting laporan:", error);
        toast.error("Gagal menghapus data.", { autoClose: 3000 });
      }
    },
  },
};
</script>
