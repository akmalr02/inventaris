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
          <!-- Bagian untuk Nama Barang -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Nama barang</span>
            </label>
            <input
              v-model="nama_barang"
              type="text"
              placeholder="Nama Barang"
              class="input input-bordered"
              required
            />
            <div v-if="errors.nama_barang" class="error-message">
              <span>{{ errors.nama_barang[0] }}</span>
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

          <!-- Bagian untuk upload Gambar -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Images</span>
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
            <router-link to="/barangRusak" class="btn btn-primary p-3">
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
      nama_barang: "",
      description: "",
      tanggal: "",
      Images: [],
      errors: {},
    };
  },

  mounted() {
    // Isi otomatis tanggal dengan tanggal hari ini
    this.tanggal = new Date().toISOString().split("T")[0];
  },

  methods: {
    handleImageUpload(event) {
      const files = Array.from(event.target.files);
      this.Images = [...this.Images, ...files];
    },

    removeImage(index) {
      this.Images.splice(index, 1);
    },

    async submitForm() {
      const formData = new FormData();
      formData.append("nama_barang", this.nama_barang);
      formData.append("description", this.description);
      formData.append("tanggal", this.tanggal);

      this.Images.forEach((image) => {
        formData.append("image[]", image);
      });

      try {
        const response = await apiClient.post("/barangRusak", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        toast.success("Laporan berhasil dibuat");
        this.resetForm();
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errors = error.response.data.errors;
        } else {
          toast.error("Terjadi kesalahan saat membuat laporan");
        }
      }
    },

    resetForm() {
      this.nama_barang = "";
      this.description = "";
      this.tanggal = new Date().toISOString().split("T")[0];
      this.Images = [];
      this.errors = {};
    },
  },
};
</script>
