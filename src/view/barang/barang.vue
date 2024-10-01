<style>
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
      <router-link to="/tambahBarang" class="btn btn-primary mb-3 ml-5">
        <PlusCircleIcon class="size-6 text-error-200-500" />Tambah Barang Baru
      </router-link>

      <div class="header">
        <p class="font-bold">Barang</p>
      </div>
    </div>
    <table class="table">
      <!-- head -->
      <thead>
        <tr>
          <th class="text-black">No</th>
          <th class="text-black">Nama Bbarang</th>
          <th class="text-black">Description Barang</th>
          <th class="text-black">kategori Barang</th>
          <th class="text-black">Jumlah Barang</th>
          <th class="text-black">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(barang, index) in barangs" :key="barang.id">
          <th>{{ index + 1 }}</th>
          <td>{{ barang.name ?? "-" }}</td>
          <td>{{ barang.description ?? "-" }}</td>
          <td>{{ barang.category?.name_categories ?? "-" }}</td>
          <td>{{ barang.jumlah ?? "-" }}</td>
          <td>
            <router-link
              :to="{ name: 'viewBarang', params: { id: barang.id } }"
              class="btn btn-primary mr-2 mb-2"
            >
              <EyeIcon class="size-6 text-blue-100-300" /> View
            </router-link>
            <router-link
              :to="{ name: 'editBarang', params: { id: barang.id } }"
              class="btn btn-outline btn-warning mbs-2 mr-2 mb-2"
            >
              <PencilIcon class="size-6 text-yellow-200-500" /> Edit
            </router-link>

            <!-- Dropdown tombol untuk memilih laporan -->
            <div class="relative inline-block">
              <button
                class="text-lg px-2 btn btn-primary bg-blue-500 text-white menu-dropdown-show"
                @click="toggleDropdown(barang.id)"
              >
                <FolderOpenIcon class="size-6" />
                Pilih Laporan
              </button>
              <ul
                v-if="dropdowns[barang.id]"
                class="absolute mt-2 p-2 shadow-lg rounded-lg w-52 bg-white"
              >
                <li class="mx-2 py-2">
                  <button
                    class="w-full flex items-center"
                    @click="openModal1(barang)"
                  >
                    <PlusCircleIcon class="w-6 h-6 mr-2 text-blue-500" /> Barang
                    Kosong
                  </button>
                </li>
                <li class="mx-2 py-2">
                  <button
                    class="w-full flex items-center"
                    @click="openModal2(barang)"
                  >
                    <PlusCircleIcon class="w-6 h-6 mr-2 text-blue-500" /> Barang
                    Rusak
                  </button>
                </li>
              </ul>
            </div>
            <form @submit.prevent="confirmDelete(barang.id)">
              <button type="submit" class="btn btn-outline btn-error mt-3">
                <TrashIcon class="size-6 text-error-200-500" /> Delete
              </button>
            </form>
          </td>
        </tr>
      </tbody>

      <!-- bagian barang kosong -->
      <div class="m-2">
        <dialog id="barangModal1" class="modal">
          <div class="modal-box">
            <h2 class="flex justify-center card-title text-center">
              Buat Laporan Barang Kosong
            </h2>
            <form @submit.prevent="barangKosong" class="card-body pt-3">
              <!-- Bagian nama Barang -->
              <h3 class="text-center font-bold p-2">
                Nama Barang : {{ selectedBarang?.name ?? "-" }}
              </h3>

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
              </div>
            </form>
            <div class="modal-action">
              <button class="btn" @click="closeModal1">Tutup</button>
            </div>
          </div>
        </dialog>
      </div>

      <!-- bagian barang rusak -->
      <div class="m-2">
        <dialog id="barangModal2" class="modal">
          <div class="modal-box">
            <h2 class="flex justify-center card-title text-center">
              Buat Laporan Barang Rusak
            </h2>
            <form
              @submit.prevent="barangRusak"
              enctype="multipart/form-data"
              class="card-body pt-3"
            >
              <!-- Bagian nama barang -->
              <h3 class="text-center font-bold p-2">
                Nama Barang : {{ selectedBarang?.name ?? "-" }}
              </h3>

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
                  <span class="label-text">Images</span>
                </label>
                <input
                  ref="imageInput"
                  type="file"
                  @change="handleImageUpload"
                  multiple
                  class="file-input file-input-bordered w-full max-w-xs mb-2"
                />
                <ul>
                  <li
                    v-for="(image, index) in images"
                    :key="index"
                    class="mb-3"
                  >
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

              <!-- Tombol Submit -->
              <div class="form-control mt-2">
                <button class="btn btn-primary p-3 mb-2" type="submit">
                  Submit
                </button>
              </div>
            </form>
            <div class="modal-action">
              <button class="btn" @click="closeModal2">Tutup</button>
            </div>
          </div>
        </dialog>
      </div>
    </table>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import apiClient from "@/service/inventaris";
import { useRoute, useRouter } from "vue-router";
import {
  TrashIcon,
  PencilIcon,
  BackspaceIcon,
  PlusCircleIcon,
  EyeIcon,
  FolderOpenIcon,
} from "@heroicons/vue/24/solid";

export default {
  components: {
    TrashIcon,
    PencilIcon,
    BackspaceIcon,
    PlusCircleIcon,
    EyeIcon,
    FolderOpenIcon,
  },
  setup() {
    const barangs = ref([]);
    const name = ref("");
    const barang_id = ref(null);
    const description = ref("");
    const tanggal = ref("");
    const kondisiRusak = ref("");
    const jumlah_rusak = ref(0);
    const images = ref([]);
    const selectedBarang = ref(null);
    const errors = ref({});
    const isDropdownOpen = ref(false);
    const dropdowns = ref({});
    const router = useRouter();

    const getBarang = async () => {
      try {
        const response = await apiClient.get("/barang");
        barangs.value = response.data;
        // console.log(barangs.value);
        tanggal.value = new Date().toISOString().split("T")[0];
        barangs.value.forEach((barang) => {
          dropdowns.value[barang.id] = false;
        });
      } catch (error) {
        errors.value = error.response.data.errors || {};
        toast.error("Gagal mengambil barang:", error);
      }
    };

    const openModal1 = (barangs) => {
      selectedBarang.value = barangs;
      barang_id.value = barangs.id;
      tanggal.value = new Date().toISOString().split("T")[0];
      const modal = document.getElementById("barangModal1");
      if (modal) {
        modal.showModal();
      }
    };

    const openModal2 = (barangs) => {
      selectedBarang.value = barangs;
      barang_id.value = barangs.id;
      tanggal.value = new Date().toISOString().split("T")[0];
      console.log(barang_id.value);
      const modal = document.getElementById("barangModal2");
      if (modal) {
        modal.showModal();
      }
    };

    const closeModal1 = () => {
      const modal = document.getElementById("barangModal1");
      if (modal) {
        modal.close();
      }
    };
    const closeModal2 = () => {
      const modal = document.getElementById("barangModal2");
      if (modal) {
        modal.close();
      }
    };

    const toggleDropdown = (id) => {
      dropdowns.value[id] = !dropdowns.value[id];
    };

    const handleImageUpload = (event) => {
      const files = Array.from(event.target.files);
      const validFiles = files.filter(
        (file) => file.type.startsWith("image/") && file.size <= 2048 * 1024
      );

      // Gabungkan dengan file yang sudah ada
      images.value.push(...validFiles);
    };

    const removeImage = (index) => {
      images.value.splice(index, 1);
    };

    onMounted(async () => {
      await getBarang();
    });

    const barangKosong = async () => {
      try {
        if (!barang_id.value) {
          console.error("barang_id tidak ditemukan");
          toast.error("ID barang tidak valid.");
          return; // Menghentikan eksekusi jika barang_id tidak valid
        }

        const data = {
          barang_id: barang_id.value, // Pastikan barang_id sudah benar
          description: description.value,
          tanggal: tanggal.value,
        };

        await apiClient.post("/barangKosong", data);
        toast.success("Laporan barang kosong berhasil dikirim!");
        closeModal1();
      } catch (error) {
        errors.value = error.response.data.errors || {};
        toast.error("Gagal mengirim laporan barang kosong.");
      }
    };

    const barangRusak = async () => {
      try {
        if (!barang_id.value) {
          toast.error("ID barang tidak valid.");
          return;
        }

        if (images.value.length === 0) {
          toast.error("Silakan unggah setidaknya satu gambar.");
          return;
        }

        const formData = new FormData();
        formData.append("barang_id", barang_id.value);
        formData.append("description", description.value);
        formData.append("tanggal", new Date().toISOString().split("T")[0]);
        formData.append("jumlah_rusak", jumlah_rusak.value);
        formData.append("kondisi", kondisiRusak.value);

        // Append images to FormData
        images.value.forEach((image) => {
          formData.append("image[]", image);
        });

        const response = await apiClient.post("/barangRusak", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        console.log(response.data);
        toast.success("Laporan barang rusak berhasil disimpan!");
      } catch (error) {
        errors.value = error.response.data.errors || {};
        console.error("Gagal membuat laporan:", error);
      }
    };

    return {
      barangs,
      selectedBarang,
      barang_id,
      getBarang,
      tanggal,
      description,
      kondisiRusak,
      jumlah_rusak,
      images,
      barangKosong,
      barangRusak,
      openModal1,
      openModal2,
      closeModal1,
      closeModal2,
      toggleDropdown,
      isDropdownOpen,
      dropdowns,
      handleImageUpload,
      removeImage,
      useRouter,
      errors,
    };
  },
};
</script>
