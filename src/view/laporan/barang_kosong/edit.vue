<template>
  <div class="flex justify-center items-center min-h-screen mb-6">
    <div class="card bg-base-300 w-96 shadow-xl">
      <div class="card-body">
        <h2 class="flex justify-center card-title text-center">
          Edit Laporan Barang Kosong
        </h2>
        <form
          class="card-body pt-3"
          @submit.prevent="updateLaporanBarangKosong"
        >
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
                :value="barang.name"
              >
                {{ barang.name }}
              </option>
            </select>
            <div v-if="errors.barang_id" class="error-message">
              <span>{{ errors.barang_id[0] }}</span>
            </div>
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

<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import apiClient from "@/service/inventaris";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const route = useRoute();
const router = useRouter();
const barang_id = ref(null);
const description = ref("");
const tanggal = ref("");
const barangs = ref([]);
const errors = ref({});

const getBarangs = async () => {
  try {
    const response = await apiClient.get("/barang");
    barangs.value = response.data;
  } catch (error) {
    toast.error("Gagal mengambil data barang.", { autoClose: 3000 });
  }
};

onMounted(async () => {
  await getBarangs();
  try {
    const response = await apiClient.get(`/barangKosong/${route.params.id}`);
    const laporan = response.data;
    console.log(laporan);
    barang_id.value = laporan.barang_id;
    description.value = laporan.description;
    tanggal.value = laporan.tanggal;
  } catch (error) {
    toast.error("Gagal mengambil data laporan.", { autoClose: 3000 });
  }
});

const updateLaporanBarangKosong = async () => {
  try {
    let formData = {
      barang_id: barang_id.value,
      description: description.value,
      tanggal: tanggal.value,
      _method: "PATCH",
    };

    await apiClient.post(`/barangKosong/${route.params.id}`, formData);
    router
      .push({
        name: "barangKosong",
        state: { successMessage: "Data laporan berhasil diperbarui!" },
      })
      .catch((error) => {
        if (error.response && error.response.data.errors) {
          errors.value = error.response.data.errors;
          toast.error("Gagal memperbarui data laporan.", { autoClose: 3000 });
        } else {
          toast.error("Terjadi kesalahan saat memperbarui data.", {
            autoClose: 3000,
          });
        }
      });
  } catch (error) {
    toast.error("Terjadi kesalahan saat memperbarui data.", {
      autoClose: 3000,
    });
  }
};

const resetForm = () => {
  barang_id.value = "";
  description.value = "";
  tanggal.value = "";
};
</script>
