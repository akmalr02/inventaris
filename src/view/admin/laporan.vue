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
          Pemakaian Barang
        </button>
      </div>
    </div>

    <!-- Tampilkan data berdasarkan tab yang aktif -->
    <div v-if="activeTab === 'barangKosong'">
      <h1 class="text-black text-center font-bold text-2xl m-5">
        Barang Kosong
      </h1>
      <table class="table">
        <thead>
          <tr>
            <th class="text-black">No</th>
            <th class="text-black">Pembuat Laporan</th>
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
              <router-link
                :to="{ name: 'viewBarangKosong', params: { id: barang.id } }"
                class="btn btn-primary items-center"
              >
                <EyeIcon class="size-6 text-blue-100-300" /> View
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="activeTab === 'barangRusak'">
      <h1 class="text-black text-center font-bold text-2xl m-5">
        Barang Rusak
      </h1>
      <table class="table">
        <thead>
          <tr>
            <th class="text-black">No</th>
            <th class="text-black">Pembuat Laporan</th>
            <th class="text-black">Nama Barang</th>
            <th class="text-black">Jumlah Barang</th>
            <th class="text-black">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(barang, index) in barangRusak" :key="barang.id">
            <th>{{ index + 1 }}</th>
            <td>{{ barang.user?.name ?? "-" }}</td>
            <td>{{ barang.barang?.name ?? "-" }}</td>
            <td>{{ barang.jumlah_rusak ?? "-" }}</td>
            <td>
              <router-link
                :to="{ name: 'viewBarangRusak', params: { id: barang.id } }"
                class="btn btn-primary items-center"
              >
                <EyeIcon class="size-6 text-blue-100-300" /> View
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="activeTab === 'pesananBarang'">
      <h1 class="text-black text-center font-bold text-2xl m-5">
        Pemakaian Barang
      </h1>
      <table class="table">
        <thead>
          <tr>
            <th class="text-black">No</th>
            <th class="text-black">Nama Pemesan</th>
            <th class="text-black">Nama Barang</th>
            <th class="text-black">Jumlah Pesanan</th>
            <th class="text-black">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(pesanan, index) in pesanan" :key="pesanan.id">
            <th>{{ index + 1 }}</th>
            <td>{{ pesanan.user?.name ?? "-" }}</td>
            <td>{{ pesanan.barang?.name ?? "-" }}</td>
            <td>{{ pesanan.jumlah_pesanan ?? "-" }}</td>
            <td>
              <router-link
                :to="{ name: 'viewPesanan', params: { id: pesanan.id } }"
                class="btn btn-primary items-center"
              >
                <EyeIcon class="size-6 text-blue-100-300" /> View
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import apiClient from "@/service/inventaris";
import { EyeIcon } from "@heroicons/vue/24/solid";

export default {
  components: {
    EyeIcon,
  },
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
        console.log(this.pesanan);
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
