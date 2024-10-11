<style></style>
<template>
  <div class="overflow-x-auto m-9">
    <div class="px-4">
      <router-link to="/tambahCategories" class="btn btn-primary mb-3 ml-5">
        <PlusCircleIcon class="size-6 text-error-200-500" />Tambah Category Baru
      </router-link>
      <div class="form-control mx-5">
        <input
          type="text"
          placeholder="Search"
          class="input input-bordered w-20 md:w-48 max-w-xs"
        />
      </div>
      <div class="header">
        <p class="font-bold">Jenis Category</p>
      </div>
    </div>
    <table class="table table-zebra">
      <!-- head -->
      <thead>
        <tr>
          <th>No</th>
          <th>Jenis Category</th>
          <th>Descripsi Category</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(category, index) in categories" :key="category.id">
          <th>{{ index + 1 }}</th>
          <td>{{ category.name }}</td>
          <td>{{ category.description }}</td>
          <td>
            <button
              class="btn btn-outline btn-warning mbs-2 mr-2 mb-2"
              @click="openEditModal(category)"
            >
              <PencilIcon class="w-6 h-6 text-yellow-200-500" /> Edit
            </button>
            <form @submit.prevent="confirmDelete(category.id)">
              <button type="submit" class="btn btn-outline btn-error mt-3">
                <TrashIcon class="size-6 text-error-200-500" />Delete
              </button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Modal Edit -->
    <div
      v-if="showEditModal"
      class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 class="text-lg font-bold mb-4">Edit Category</h3>
        <form @submit.prevent="submitEditForm">
          <div class="mb-4">
            <label class="block text-gray-700">Nama Category:</label>
            <input
              v-model="selectedCategory.name"
              type="text"
              class="input input-bordered w-full"
            />
          </div>
          <div class="mb-4">
            <label class="block text-gray-700">Deskripsi Category:</label>
            <textarea
              v-model="selectedCategory.description"
              type="text"
              class="textarea textarea-bordered w-full"
            ></textarea>
          </div>
          <div class="flex justify-end space-x-2">
            <button
              type="button"
              @click="closeEditModal"
              class="btn btn-outline"
            >
              Batal
            </button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import apiClient from "@/service/inventaris";
import { useRouter, useRoute } from "vue-router";
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
    const categories = ref([]);
    const selectedCategory = ref({ name: "", description: "" });
    const showEditModal = ref(false);
    const category_id = ref(null);
    const route = useRoute();

    const getCategories = async () => {
      try {
        const response = await apiClient.get("/category");
        categories.value = response.data;
        // console.log(categories);
      } catch (error) {
        toast.error("Gagal mengambil data kategori.", { autoClose: 3000 });
      }
    };

    const openEditModal = (categories) => {
      selectedCategory.value = categories;
      category_id.value = categories.id;
      // console.log(selectedCategory.value);
      showEditModal.value = true;
    };
    const closeEditModal = () => {
      showEditModal.value = false;
      selectedCategory.value = { name: "", description: "" };
    };

    onMounted(async () => {
      await getCategories();
    });

    const submitEditForm = async () => {
      try {
        const formData = new FormData();
        formData.append("name", selectedCategory.value.name);
        formData.append("description", selectedCategory.value.description);
        formData.append("_method", "PATCH");
        // formData.forEach((value, key) => {
        //   console.log(`${key}: ${value}`);
        // });

        const response = await apiClient.post(
          `/category/${selectedCategory.value.id}`,
          formData
        );
        // console.log(response.data);

        toast.success("Kategori berhasil diperbarui.", { autoClose: 3000 });
        closeEditModal();
      } catch (error) {
        toast.error("Gagal memperbarui kategori.", { autoClose: 3000 });
        // console.error(error);s
      }
    };

    return {
      categories,
      selectedCategory,
      category_id,
      showEditModal,
      openEditModal,
      closeEditModal,
      submitEditForm,
    };
  },
};
</script>
