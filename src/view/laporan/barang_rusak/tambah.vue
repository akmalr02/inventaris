<template>
  <div class="flex justify-center items-center min-h-screen mb-6">
    <div class="card bg-base-300 w-96 shadow-xl">
      <div class="card-body">
        <h2 class="flex justify-center card-title text-center">
          Buat Laporan Barang Rusak
        </h2>

        <form
          @submit.prevent="submitForm"
          enctype="multipart/form-data"
          class="card-body pt-3"
        >
          <!-- Bagian input Barang -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Nama Barang</span>
            </label>
            <input
              v-model="name"
              type="text"
              placeholder="Nama Barang"
              class="input input-bordered"
              required
            />
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

          <!-- Bagian untuk memilih kondisi -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Pilih Kondisi</span>
            </label>
            <select
              v-model="kondisiRusak"
              class="select select-bordered w-full mt-2"
              required
            >
              <option disabled value="">Pilih kondisi</option>
              <option value="Ringan">Ringan</option>
              <option value="Sedang">Sedang</option>
              <option value="Berat">Berat</option>
            </select>
            <div v-if="errors.kondisiRusak" class="error-message">
              <span>{{ errors.kondisiRusak[0] }}</span>
            </div>
          </div>

          <!-- Jumlah Barang Rusak -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Jumlah Barang Rusak</span>
            </label>
            <input
              v-model="jumlah_rusak"
              type="text"
              inputmode="numeric"
              placeholder="Jumlah"
              class="input input-bordered"
              required
            />
            <div v-if="errors.barangRusak" class="error-message">
              <span>{{ errors.barangRusak[0] }}</span>
            </div>
          </div>

          <!-- Bagian untuk upload Gambar -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Images Barang</span>
            </label>
            <input
              ref="images"
              type="file"
              @change="handleImageUpload"
              multiple
            />
            <!-- Tampilkan pesan error jika kurang dari 3 gambar -->
            <ul class="mt-3">
              <li v-for="(image, index) in Images" :key="index">
                {{ image.name }}
                <button @click="removeImage(index)" class="btn btn-error mb-3">
                  X
                </button>
              </li>
            </ul>
          </div>

          <!-- Tombol Submit -->
          <div class="form-control mt-2">
            <button class="btn btn-primary p-3 mb-2" type="submit">
              Submit
            </button>
            <router-link to="/barang" class="btn btn-primary p-3">
              Back
            </router-link>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import apiClient from "@/service/inventaris";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export default {
  setup() {
    const name = ref("");
    const barang_id = ref(null);
    const description = ref("");
    const tanggal = ref("");
    const kondisiRusak = ref("");
    const jumlah_rusak = ref("0");
    const Images = ref([]);
    const errors = ref({});
    const route = useRoute();

    const getBarang = async () => {
      try {
        const response = await apiClient.get(`/barang/${route.params.id}`);
        const barang = response.data;
        barang_id.value = barang.id;
        name.value = barang.name;
        tanggal.value = new Date().toISOString().split("T")[0];
        // console.log(name);
        // console.log("Barang:", name.value, "ID:", barang_id.value);
      } catch (error) {
        console.error("Gagal mengambil barang:", error);
      }
    };

    onMounted(async () => {
      await getBarang();
    });

    const createLaporan = async () => {
      try {
        const data = {
          barang_id: barang_id.value,
          description: description.value,
          tanggal: new Date().toISOString().split("T")[0],
        };
        const response = await apiClient.post("/barangKosong", data);
        console.log(response.data);
        toast.success("Laporan barang kosong berhasil disimpan!");
      } catch (error) {
        errors.value = error.response.data.errors || {};
        console.error("Gagal membuat laporan:", error);
      }
    };

    return {
      barang_id,
      name,
      description,
      tanggal,
      errors,
      kondisiRusak,
      jumlah_rusak,
      Images,
      createLaporan,
    };
  },
};
</script>
