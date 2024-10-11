<template>
  <div class="flex justify-center items-center min-h-screen mb-6">
    <div class="card bg-base-300 w-96 shadow-xl">
      <div class="card-body">
        <h2 class="flex justify-center card-title text-center">
          Tambah persediaan
        </h2>
        <form class="card-body pt-3" @submit.prevent="tambahBarang">
          <!-- Bagian Nama Barang -->
          <h3 class="text-lg font-bold">
            {{ laporan?.barang?.name ?? "Barang tidak tersedia!!!" }}
          </h3>

          <!-- Bagian untuk memilih Tanggal -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Tanggal</span>
            </label>
            <input
              v-model="tanggal"
              type="date"
              class="input input-bordered"
              required
            />
          </div>

          <!-- Input Jumlah Barang -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Jumlah Barang </span>
            </label>
            <input
              v-model="jumlah"
              type="text"
              inputmode="numeric"
              placeholder="Jumlah"
              class="input input-bordered"
              min="1"
              required
            />
          </div>

          <!-- Tombol Submit -->
          <div class="form-control mt-2">
            <button class="btn btn-primary p-3 mb-2" type="submit">
              Submit
            </button>
            <router-link to="/barangKosong" class="btn btn-primary p-3">
              Kembali
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

export default {
  data() {
    return {
      laporan: [],
      jumlah: "",
      tanggal: "",
    };
  },
  created() {
    this.getLaporan();
  },
  methods: {
    async getLaporan() {
      const response = await apiClient.get(
        `/barangKosong/${this.$route.params.id}`
      );
      this.laporan = response.data;
      this.tanggal = new Date().toISOString().split("T")[0];
      // console.log(this.laporan);
    },

    async tambahBarang() {
      try {
        const data = {
          jumlah: this.jumlah,
          tanggal: this.tanggal,
        };
        const response = await apiClient.post(
          `/barangKosong/${this.$route.params.id}/tambahBarang`,
          data
        );
        if (response.status === 200) {
          toast.success("Jumlah barang berhasil ditambahkan.");
        }
      } catch (error) {
        console.error(error);
        toast.error("Gagal menambahkan jumlah barang.");
      }
    },
  },
};
</script>
