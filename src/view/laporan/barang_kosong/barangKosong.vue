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
        <p class="font-bold">Laporan barang Kosong</p>
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
          <th class="text-black">Tanggal</th>
          <th class="text-black">Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(laporan, index) in barangKosong" :key="laporan.id">
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
            <!-- Tombol untuk membuka modal -->
            <button class="btn btn-primary" @click="openModal(laporan)">
              <PlusCircleIcon class="size-6 text-error-200-500" />Tambah
              persediaan
            </button>

            <!-- Modal Tambah Persediaan -->
            <div
              v-if="isModalOpen"
              class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50"
            >
              <div class="modal-box bg-base-300 w-96">
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
                    <button
                      class="btn btn-outline btn-error mt-3"
                      type="button"
                      @click="closeModal"
                    >
                      Tutup
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <!-- Modal -->
            <div v-if="userRole === 'admin'">
              <form @submit.prevent="confirmDelete(laporan.id)">
                <button type="submit" class="btn btn-outline btn-error mt-3">
                  <TrashIcon class="size-6 text-error-200-500" />Delete
                </button>
              </form>
            </div>
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
      barangKosong: [],
      userRole: "",
      isModalOpen: false,
      selectedLaporan: null,
      tanggal: "",
      jumlah: "",
    };
  },
  created() {
    this.checkAuthStatus();
    this.getBarangkosong();
  },
  methods: {
    async checkAuthStatus() {
      const authStore = useAuthStore();
      this.userRole = authStore.getRole();
    },
    async getBarangkosong() {
      try {
        const response = await apiClient.get("/barangKosong");
        this.barangKosong = response.data;
        // console.log(this.barangKosong);
        if (this.$route.state && this.$route.state.successMessage) {
          toast.success(this.$route.state.successMessage, { autoClose: 3000 });
        }
      } catch (error) {
        // console.error("Error:", error);
      }
    },
    openModal(laporan) {
      this.selectedLaporan = laporan;
      this.tanggal = new Date().toISOString().split("T")[0]; // Default tanggal hari ini
      this.isModalOpen = true;
    },

    closeModal() {
      this.isModalOpen = false;
      this.selectedLaporan = null;
      this.tanggal = "";
      this.jumlah = "";
    },

    async tambahBarang() {
      try {
        const data = {
          jumlah: this.jumlah,
          tanggal: this.tanggal,
        };
        const response = await apiClient.post(
          `/barangKosong/${this.selectedLaporan.id}/tambahBarang`,
          data
        );
        if (response.status === 200) {
          toast.success("Jumlah barang berhasil ditambahkan.");
          this.getBarangkosong(); // Perbarui data tabel
          this.closeModal();
        }
      } catch (error) {
        console.error(error);
        toast.error("Gagal menambahkan jumlah barang.");
      }
    },
    confirmDelete(id) {
      if (window.confirm("Apakah Anda yakin ingin menghapus Laporan ini?")) {
        this.deleteLaporan(id);
      }
    },

    async deleteLaporan(id) {
      try {
        await apiClient.delete(`/barangKosong/${id}`);
        this.getBarangkosong();
        toast.success("Data berhasil dihapus.", { autoClose: 3000 });
      } catch (error) {
        // console.error("Error deleting laporan:", error);
        toast.error("Gagal menghapus data.", { autoClose: 3000 });
      }
    },
  },
};
</script>
