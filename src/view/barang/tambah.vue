<template>
  <div class="flex justify-center items-center min-h-screen mb-6">
    <div class="card bg-base-300 w-96 shadow-xl">
      <div class="card-body">
        <h2 class="flex justify-center card-title text-center">
          Tambah Barang
        </h2>

        <form @submit.prevent="submitForm" class="card-body pt-3">
          <!-- Input Nama Barang -->
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

          <!-- Input Deskripsi -->
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
          </div>

          <!-- Pilih Category -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Pilih Category</span>
            </label>
            <select
              v-model="categories_id"
              class="select select-bordered"
              required
            >
              <option value="" disabled>Pilih Barang</option>
              <option v-for="c in categories" :key="c.id" :value="c.id">
                {{ c.name_categories }}
              </option>
            </select>
          </div>

          <!-- Upload Gambar -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Images</span>
            </label>
            <input
              ref="imageInput"
              type="file"
              @change="handleImageUpload"
              multiple
              class="mb-2"
            />
            <ul class="mt-3">
              <li v-for="(image, index) in images" :key="index" class="mb-2">
                {{ image.name }}
                <button
                  @click="removeImage(index)"
                  class="btn btn-error btn-xs ml-2"
                >
                  X
                </button>
              </li>
            </ul>
          </div>

          <!-- Input Jumlah Barang -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Jumlah Barang</span>
            </label>
            <input
              v-model.number="jumlah"
              type="text"
              inputmode="numeric"
              placeholder="Jumlah Barang"
              class="input input-bordered"
              required
            />
          </div>

          <div class="form-control mt-2">
            <button class="btn btn-primary p-3 mb-2" type="submit">
              Submit
            </button>
            <router-link to="/barang" class="btn btn-primary p-3">
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
    const name = ref("");
    const description = ref("");
    const categories = ref([]);
    const categories_id = ref("");
    const images = ref([]);
    const jumlah = ref(0);
    const errors = ref({});

    const getCategories = async () => {
      try {
        const response = await apiClient.get("/category");
        categories.value = response.data;
      } catch (error) {
        console.error("Data tidak bisa diambil", error);
      }
    };

    const resetForm = () => {
      name.value = "";
      description.value = "";
      categories_id.value = "";
      images.value = [];
      jumlah.value = 0;
    };

    const handleImageUpload = (event) => {
      const files = Array.from(event.target.files);
      const validFiles = files.filter(
        (file) => file.type.startsWith("image/") && file.size <= 2048 * 1024
      ); // Validasi tipe dan ukuran file
      images.value = [...images.value, ...validFiles]; // Gabungkan dengan file yang sudah ada
    };

    const removeImage = (index) => {
      images.value.splice(index, 1);
    };

    const submitForm = async () => {
      try {
        const formData = new FormData();
        formData.append("name", name.value);
        formData.append("description", description.value);
        formData.append("categories_id", categories_id.value);
        formData.append("jumlah", jumlah.value);

        images.value.forEach((image) => {
          formData.append("image[]", image);
        });

        await apiClient.post("/barang", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        toast.success("Berhasil tambah data barang", { autoClose: 3000 });
        resetForm();
      } catch (error) {
        console.error("Error response:", error.response);
        if (
          error.response &&
          error.response.data &&
          error.response.data.errors
        ) {
          errors.value = error.response.data.errors;
        }
        toast.error("Gagal menambah data barang!!", { autoClose: 3000 });
      }
    };

    onMounted(() => {
      getCategories();
    });

    return {
      name,
      description,
      categories,
      categories_id,
      images,
      jumlah,
      handleImageUpload,
      removeImage,
      submitForm,
    };
  },
};
</script>
