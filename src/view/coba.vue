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
        <p class="font-bold">Pesanan Barang</p>
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
          <th class="text-black">Tanggal Pesan</th>
          <th class="text-black">Jumlah Pesanan</th>
          <th class="text-black">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(laporan, index) in pesanan" :key="laporan.id">
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
            <!-- Tampilkan tanggal jika ada -->
            {{ laporan.tanggal ?? "-" }}
          </td>
          <td>
            <!-- Tampilkan jumlah jika ada -->
            {{ laporan.jumlah_pesanan ?? "-" }}
          </td>
          tombol
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
      pesanan: [],
      userRole: "",
    };
  },
  created() {
    this.checkAuthStatus();
    this.getpesanan();
  },
  methods: {
    async checkAuthStatus() {
      const authStore = useAuthStore();
      this.userRole = authStore.getRole();
    },
    async getpesanan() {
      try {
        const response = await apiClient.get("/pesanan");
        this.pesanan = response.data;
        // console.log(this.pesanan);
      } catch (error) {
        console.error("Error:", error);
      }
    },
  },
};
</script>
