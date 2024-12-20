<template>
  <div class="flex justify-center items-center min-h-screen mb-6">
    <div class="card bg-base-300 w-96 shadow-xl">
      <div class="card-body">
        <h2 class="flex justify-center card-title text-center">
          Edit Barang Rusak
        </h2>
        <form class="card-body pt-3" @submit.prevent="updateBarangRusak">
          <!-- Pilih Barang -->
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
            <div v-if="errors.barang_id" class="error-message">
              <span>{{ errors.barang_id[0] }}</span>
            </div>
          </div>

          <!-- Deskripsi -->
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

          <!-- Tanggal -->
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

          <!-- Kondisi -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Pilih Kondisi</span>
            </label>
            <select
              v-model="kondisi"
              class="select select-bordered w-full mt-2"
              required
            >
              <option disabled value="">Pilih kondisi</option>
              <option value="Ringan">Ringan</option>
              <option value="Sedang">Sedang</option>
              <option value="Berat">Berat</option>
            </select>
            <div v-if="errors.kondisi" class="error-message">
              <span>{{ errors.kondisi[0] }}</span>
            </div>
          </div>

          <!-- Jumlah Barang Rusak -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Jumlah Barang Rusak</span>
            </label>
            <input
              v-model="jumlah_rusak"
              type="number"
              placeholder="Jumlah"
              class="input input-bordered"
              required
            />
            <div v-if="errors.jumlah_rusak" class="error-message">
              <span>{{ errors.jumlah_rusak[0] }}</span>
            </div>
          </div>

          <!-- Upload Gambar -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Images Barang Rusak</span>
            </label>
            <input
              ref="imageInput"
              type="file"
              @change="handleImageUpload"
              multiple
              class="file-input file-input-bordered w-full max-w-xs mb-2"
            />
            <ul>
              <li v-for="(image, index) in images" :key="index" class="mb-3">
                {{ image.name }}
                <button
                  type="button"
                  @click="removeImage(index)"
                  class="btn btn-error btn-xs ml-2"
                  title="Hapus gambar ini"
                >
                  X
                </button>
              </li>
            </ul>
          </div>

          <!-- Tombol -->
          <div class="form-control mt-2">
            <button class="btn btn-primary p-3 mb-2" type="submit">
              Submit
            </button>
            <router-link to="/barangRusak" class="btn btn-primary p-3">
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
const kondisi = ref("");
const jumlah_rusak = ref(0);
const images = ref([]);

// Fetch daftar barang
const getBarangs = async () => {
  try {
    const response = await apiClient.get("/barang");
    barangs.value = response.data;
  } catch (error) {
    toast.error("Gagal mengambil data barang.", { autoClose: 3000 });
  }
};

// Fetch laporan berdasarkan ID
onMounted(async () => {
  await getBarangs();
  try {
    const response = await apiClient.get(`/barangRusak/${route.params.id}`);
    const laporan = response.data;
    barang_id.value = laporan.barang_id;
    description.value = laporan.description;
    tanggal.value = laporan.tanggal;
    kondisi.value = laporan.kondisi;
    jumlah_rusak.value = laporan.jumlah_rusak;
  } catch (error) {
    toast.error("Gagal mengambil data laporan.", { autoClose: 3000 });
  }
});

// Handle image upload
const handleImageUpload = (event) => {
  const files = Array.from(event.target.files);
  const validFiles = files.filter(
    (file) => file.type.startsWith("image/") && file.size <= 2048 * 1024
  );

  if (validFiles.length === 0) {
    toast.error("File tidak valid atau terlalu besar!", { autoClose: 3000 });
  }

  images.value.push(...validFiles);
};

// Hapus gambar
const removeImage = (index) => {
  images.value.splice(index, 1);
};

// Update laporan barang rusak
const updateBarangRusak = async () => {
  const formData = new FormData();
  formData.append("barang_id", barang_id.value);
  formData.append("description", description.value);
  formData.append("tanggal", tanggal.value);
  formData.append("kondisi", kondisi.value);
  formData.append("jumlah_rusak", jumlah_rusak.value);
  images.value.forEach((image) => {
    formData.append("images[]", image);
  });
  formData.append("_method", "PATCH");

  try {
    await apiClient.post(`/barangRusak/${route.params.id}`, formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    router.push({ name: "barangRusak" }).then(() => {
      toast.success("Data laporan berhasil diperbarui!", { autoClose: 3000 });
    });
  } catch (error) {
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors;
      toast.error("Gagal memperbarui data laporan.", { autoClose: 3000 });
    } else {
      toast.error("Terjadi kesalahan saat memperbarui data.", {
        autoClose: 3000,
      });
    }
  }
};
</script>
