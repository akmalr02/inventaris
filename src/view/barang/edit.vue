<style scoped>
.content_image {
  display: flex;
  gap: 10px;
  overflow-x: auto;
}

.image-box {
  width: 250px;
  height: 150px;
  object-fit: cover;
  border-radius: 8px;
}
</style>

<template>
  <div class="flex justify-center items-center min-h-screen mb-6">
    <div class="card bg-base-300 w-96 shadow-xl">
      <div class="card-body">
        <h2 class="flex justify-center card-title text-center">
          Update Barang
        </h2>

        <form @submit.prevent="update" class="card-body pt-3">
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

          <!-- Menampilkan Gambar -->
          <div class="horizontal_scroll">
            <div v-if="images && images.length" class="content_image">
              <img
                v-for="(data_gambar, index) in images"
                :key="index"
                :src="`${lokasi}/${data_gambar}`"
                alt="Gambar Barang"
                class="image-box"
              />
            </div>
          </div>

          <!-- Upload Gambar Baru -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Upload Gambar</span>
            </label>
            <input
              ref="imageInput"
              type="file"
              @change="handleImageUpload"
              multiple
              class="mb-2"
            />
            <ul class="mt-3">
              <li v-for="(image, index) in newImages" :key="index" class="mb-2">
                {{ image.name }}
                <button
                  type="button"
                  @click="removeNewImage(index)"
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
              Update
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
import { useRoute } from "vue-router";
import apiClient from "@/service/inventaris";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export default {
  setup() {
    const name = ref("");
    const description = ref("");
    const categories = ref([]);
    const categories_id = ref(null);
    const images = ref([]);
    const newImages = ref([]);
    const imagesToRemove = ref([]);
    const jumlah = ref();
    const errors = ref({});
    const route = useRoute();
    const lokasi = "http://inventaris.test/storage/";

    const getCategories = async () => {
      try {
        const response = await apiClient.get("/category");
        categories.value = response.data;
      } catch (error) {
        console.error("Data tidak bisa diambil", error);
      }
    };

    const getBarang = async () => {
      try {
        const response = await apiClient.get(`/barang/${route.params.id}`);
        const barang = response.data;
        name.value = barang.name;
        console.log(barang);
        description.value = barang.description;
        categories_id.value = barang.categories_id;
        images.value = JSON.parse(barang.image);
        jumlah.value = barang.jumlah;
      } catch (error) {
        console.error("Error fetching barang:", error);
      }
    };

    onMounted(async () => {
      await getCategories();
      await getBarang();
    });

    const handleImageUpload = (event) => {
      const files = Array.from(event.target.files);
      const validFiles = files.filter(
        (file) => file.type.startsWith("image/") && file.size <= 2048 * 1024
      );
      newImages.value = [...newImages.value, ...validFiles];
    };

    // Fungsi untuk menghapus gambar baru yang di-upload
    const removeNewImage = (index) => {
      newImages.value.splice(index, 1);
    };

    // Fungsi untuk menandai gambar yang ingin dihapus
    const removeExistingImage = (index) => {
      const removedImage = images.value.splice(index, 1)[0];
      imagesToRemove.value.push(removedImage); // Masukkan ke daftar yang akan dihapus saat update
    };

    const update = async () => {
      try {
        const formData = new FormData();
        formData.append("name", name.value);
        formData.append("description", description.value);
        formData.append("categories_id", categories_id.value);
        formData.append("jumlah", jumlah.value);

        // Kirim gambar baru yang tersisa setelah yang dihapus di newImages
        newImages.value.forEach((image) => {
          formData.append("image[]", image);
        });

        // Tambahkan gambar yang dihapus untuk dihapus dari backend
        if (imagesToRemove.value.length > 0) {
          formData.append(
            "imagesToRemove",
            JSON.stringify(imagesToRemove.value)
          );
        }

        formData.append("_method", "PATCH");

        await apiClient.post(`/barang/${route.params.id}`, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        toast.success("Data barang berhasil diupdate", { autoClose: 3000 });
      } catch (error) {
        console.error("Error response:", error.response);
        if (
          error.response &&
          error.response.data &&
          error.response.data.errors
        ) {
          errors.value = error.response.data.errors;
        }
        toast.error("Gagal mengupdate data barang!", { autoClose: 3000 });
      }
    };

    return {
      name,
      description,
      categories,
      categories_id,
      images,
      newImages,
      imagesToRemove,
      jumlah,
      handleImageUpload,
      removeNewImage,
      removeExistingImage,
      update,
      lokasi,
    };
  },
};
</script>
