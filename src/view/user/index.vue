<template>
  <div class="overflow-x-auto m-9">
    <div class="px-4">
      <div class="header">
        <p class="font-bold">Pesanan saya</p>
      </div>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th class="text-black">No</th>
          <th class="text-black">Nama Barang</th>
          <th class="text-black">Descripsi</th>
          <th class="text-black">Jumlah Pesanan</th>
          <th class="text-black">Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(laporan, index) in pesanan" :key="laporan.id">
          <th>{{ index + 1 }}</th>
          <td>{{ laporan.barang?.name ?? "-" }}</td>
          <td>{{ laporan.description ?? "-" }}</td>
          <td>{{ laporan.jumlah_pesanan ?? "-" }}</td>
          <td>{{ laporan.tanggal ?? "-" }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import apiClient from "@/service/inventaris";
import { useAuthStore } from "@/stores/authStore";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export default {
  data() {
    return {
      pesanan: [],
      auth: [],
    };
  },
  computed: {
    authStore() {
      return useAuthStore();
    },
  },
  created() {
    this.checkAuth();
  },
  methods: {
    async checkAuth() {
      try {
        this.auth = this.authStore.user;

        if (this.auth && this.auth.id) {
          await this.getPesanan();
        } else {
          toast.error("User belum login atau ID tidak ditemukan!");
        }
      } catch (error) {
        toast.error("Gagal mengambil data user!!!");
      }
    },

    async getPesanan() {
      try {
        if (!this.auth) {
          throw new Error("User belum tersedia!");
        }

        const userId = this.auth.id;
        // console.log("Data User:", this.auth.id);

        const response = await apiClient.get(`/pesanan/${userId}/user`);

        this.pesanan = response.data;
        // console.log(this.pesanan);
      } catch (error) {
        toast.error("Data tidak ditemukanl!!!");
      }
    },
  },
};
</script>
