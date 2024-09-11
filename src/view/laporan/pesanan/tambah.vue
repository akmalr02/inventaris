<template>
  <div class="flex justify-center items-center min-h-screen mb-6">
    <div class="card bg-base-300 w-96 shadow-xl">
      <div class="card-body">
        <h2 class="flex justify-center card-title text-center">
          Buat Pesanan Barang
        </h2>

        <form @submit.prevent="submitForm" class="card-body pt-3">
          <!-- Bagian untuk memilih Barang -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Pilih Barang</span>
            </label>
            <select v-model="barang_id" class="select select-bordered" required>
              <option value="" disabled>Pilih Barang</option>
              <option
                v-for="barang in barangs"
                :key="barang.id"
                :value="barang.id"
              >
                {{ barang.name }}
              </option>
            </select>
          </div>

          <!-- Bagian untuk memasukkan Deskripsi -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Deskripsi</span>
            </label>
            <textarea
              v-model="description"
              placeholder="Deskripsi"
              class="textarea textarea-bordered"
              required
            ></textarea>
            <div v-if="errors.description" class="error-message">
              <span>{{ errors.description[0] }}</span>
            </div>
          </div>

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
            <div v-if="errors.tanggal" class="error-message">
              <span>{{ errors.tanggal[0] }}</span>
            </div>
          </div>

          <!-- Bagian untuk memasukkan Jumlah Pesanan -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Jumlah Pesanan</span>
            </label>
            <input
              v-model.number="jumlah_pesanan"
              type="text"
              inputmode="numeric"
              placeholder="Jumlah Pesanan"
              class="input input-bordered"
              required
            />
            <div v-if="errors.jumlah_pesanan" class="error-message">
              <span>{{ errors.jumlah_pesanan[0] }}</span>
            </div>
          </div>

          <!-- Tombol Submit -->
          <div class="form-control mt-2">
            <button class="btn btn-primary p-3 mb-2" type="submit">
              Submit
            </button>
            <router-link to="/pesananBarang" class="btn btn-primary p-3">
              Kembali
            </router-link>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import apiClient from "@/service/inventaris";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export default {
  setup() {
    const barangs = ref([]);
    const barang_id = ref("");
    const description = ref("");
    const tanggal = ref("");
    const jumlah_pesanan = ref(0);
    const errors = ref({});

    const getBarangs = async () => {
      try {
        const response = await apiClient.get("/barang");
        barangs.value = response.data;
      } catch (error) {
        console.error("Gagal mengambil data barang:", error);
      }
    };

    const resetForm = () => {
      barang_id.value = "";
      description.value = "";
      tanggal.value = new Date().toISOString().split("T")[0];
      jumlah_pesanan.value = 0;
    };

    const submitForm = async () => {
      try {
        const data = {
          barang_id: barang_id.value,
          description: description.value,
          tanggal: tanggal.value,
          jumlah_pesanan: jumlah_pesanan.value,
        };
        await apiClient.post("/pesanan", data);
        toast.success("Berhasil tambah data laporan", { autoClose: 3000 });
        resetForm();
      } catch (error) {
        if (
          error.response &&
          error.response.data &&
          error.response.data.errors
        ) {
          errors.value = error.response.data.errors;
        }
        toast.error("Gagal menambah data laporan!!", { autoClose: 3000 });
      }
    };

    onMounted(() => {
      getBarangs();
      tanggal.value = new Date().toISOString().split("T")[0];
    });

    return {
      barangs,
      barang_id,
      description,
      tanggal,
      jumlah_pesanan,
      errors,
      submitForm,
    };
  },
};
</script>
