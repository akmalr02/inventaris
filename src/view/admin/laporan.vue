<style scoped>
.container {
  display: flex;
}

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

.dropdown {
  position: relative;
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1;
}
</style>

<!-- tampilkan nomor nama_user nama_barang dan aksi -->

<template>
  <div class="overflow-x-auto m-9">
    <div class="container">
      <!-- Tombol tab -->
      <div class="tombol1 m-3">
        <button
          @click="activeTab = 'barangKosong'"
          class="btn btn-outline btn-info mbs-2"
        >
          Barang Kosong
        </button>
      </div>

      <div class="tombol2 m-3">
        <button
          @click="activeTab = 'barangRusak'"
          class="btn btn-outline btn-warning mbs-2"
        >
          Barang Rusak
        </button>
      </div>

      <div class="tombol3 m-3">
        <button
          @click="activeTab = 'pesananBarang'"
          class="btn btn-outline btn-accent mbs-2"
        >
          Pesanan Barang
        </button>
      </div>
    </div>

    <!-- Tampilkan data berdasarkan tab yang aktif -->
    <table class="table" v-if="activeTab === 'barangKosong'">
      <thead>
        <tr>
          <th class="text-black">No</th>
          <th class="text-black">User Name</th>
          <th class="text-black">Nama Barang Kosong</th>
          <th class="text-black">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(barang, index) in barangKosong" :key="barang.id">
          <th>{{ index + 1 }}</th>
          <td>{{ barang.user?.name ?? "-" }}</td>
          <td>{{ barang.barang?.name ?? "-" }}</td>
          <td>
            <button class="btn btn-outline btn-error">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <table class="table" v-if="activeTab === 'barangRusak'">
      <thead>
        <tr>
          <th class="text-black">No</th>
          <th class="text-black">User Name</th>
          <th class="text-black">Nama Barang Rusak</th>
          <th class="text-black">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(barang, index) in barangRusak" :key="barang.id">
          <th>{{ index + 1 }}</th>
          <td>{{ barang.user?.name ?? "-" }}</td>
          <td>{{ barang.nama_barang ?? "-" }}</td>
          <td>
            <button class="btn btn-outline btn-error">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <table class="table" v-if="activeTab === 'pesananBarang'">
      <thead>
        <tr>
          <th class="text-black">No</th>
          <th class="text-black">User Name</th>
          <th class="text-black">Nama Barang Pesanan</th>
          <th class="text-black">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(pesanan, index) in pesanan" :key="pesanan.id">
          <th>{{ index + 1 }}</th>
          <td>{{ pesanan.user?.name ?? "-" }}</td>
          <td>{{ pesanan.barang?.name ?? "-" }}</td>
          <td>
            <button class="btn btn-outline btn-error">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import apiClient from "@/service/inventaris";

export default {
  data() {
    return {
      activeTab: "barangKosong",
      barangKosong: [],
      barangRusak: [],
      pesanan: [],
    };
  },
  created() {
    this.getBarangKosong();
  },
  methods: {
    async getBarangKosong() {
      try {
        const response = await apiClient.get("/barangKosong");
        this.barangKosong = response.data;
        // console.log(this.barangKosong);
      } catch (error) {
        console.error("Error:", error);
      }
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
    async getPesanan() {
      try {
        const response = await apiClient.get("/pesanan");
        this.pesanan = response.data;
        // console.log(this.pesanan);
      } catch (error) {
        console.error("Error:", error);
      }
    },
  },
  watch: {
    // Mengambil data berdasarkan tab yang diaktifkan
    activeTab(newValue) {
      if (newValue === "barangKosong") {
        this.getBarangKosong();
      } else if (newValue === "barangRusak") {
        this.getBarangRusak();
      } else if (newValue === "pesananBarang") {
        this.getPesanan();
      }
    },
  },
};
</script>
