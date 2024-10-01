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
        <PlusCircleIcon class="size-6 text-error-200-500" />Tambah Barang
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
          <th class="text-black">Nama</th>
          <th class="text-black">Description</th>
          <th class="text-black">kategori</th>
          <th class="text-black">Jumlah</th>
          <th class="text-black">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(barang, index) in barangs" :key="barangs.id">
          <th>{{ index + 1 }}</th>
          <td>
            <!-- Tampilkan nama barang jika ada -->
            {{ barang.name ?? "-" }}
          </td>
          <td>
            <!-- Tampilkan description barang jika ada -->
            {{ barang.description ?? "-" }}
          </td>
          <td>
            <!-- Tampilkan kategori jika ada -->
            {{ barang.category?.name_categiries ?? "-" }}
          </td>

          <td>
            <!-- Tampilkan jumlah jika ada -->
            {{ barang.jumlah ?? "-" }}
          </td>
          <td>
            <router-link
              :to="{ name: 'viewBarang', params: { id: barang.id } }"
              class="btn btn-primary mr-2 mb-2"
            >
              <EyeIcon class="size-6 text-blue-100-300" /> View
            </router-link>
            <router-link
              :to="{ name: 'editBarang', params: { id: barang.id } }"
              class="btn btn-outline btn-warning mbs-2"
              ><PencilIcon
                class="size-6 text-yellow-200-500"
              />edit</router-link
            >
            <form @submit.prevent="confirmDelete(barang.id)">
              <button type="submit" class="btn btn-outline btn-error mt-3">
                <TrashIcon class="size-6 text-error-200-500" />Delete
              </button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import apiClient from "@/service/inventaris";
import {
  TrashIcon,
  PencilIcon,
  BackspaceIcon,
  PlusCircleIcon,
  EyeIcon,
  FolderOpenIcon,
} from "@heroicons/vue/24/solid";
import { useRoute, useRouter } from "vue-router"; // import useRoute and useRouter

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
    const barang = ref({
      name: "",
      description: "",
      jumlah: 0,
    });
    const description = ref("");
    const tanggal = ref("");
    const kondisiRusak = ref("");
    const jumlah_rusak = ref("0");
    const Images = ref([]);
    const selectedBarang = ref(null);
    const errors = ref({});
    const route = useRoute(); // use useRoute to get route params
    const router = useRouter(); // use useRouter for navigation
    const isDropdownOpen = ref(false);
    const dropdowns = ref({});

    // Fetch all barang
    const getBarang = async () => {
      try {
        const response = await apiClient.get("/barang");
        barangs.value = response.data;
        tanggal.value = new Date().toISOString().split("T")[0];
        barangs.value.forEach((barang) => {
          dropdowns.value[barang.id] = false;
        });
      } catch (error) {
        errors.value = error.response.data.errors || {};
        toast.error("Gagal mengambil barang:", error);
      }
    };

    // Fetch barang by ID from params
    const barangKosong = async () => {
      try {
        const response = await apiClient.get(
          `/barangKosong/${route.params.id}`
        ); // use params.id
        barang.value = response.data;
      } catch (error) {
        console.error("Gagal mendapatkan data barang:", error);
      }
    };

    // Open modal for barang kosong
    const openModal1 = (barangs) => {
      selectedBarang.value = barangs;
      // barang_id.value = barangs;
      console.log("ID from route params:", route.params.id);
      const modal = document.getElementById("barangModal1");
      if (modal) {
        modal.showModal();
      }
    };

    // Open modal for barang rusak
    const openModal2 = (barang) => {
      selectedBarang.value = barang;
      barang_id.value = barang;
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

    // Mounted lifecycle hook
    onMounted(async () => {
      await getBarang();
      await barangKosong(); // call getBarangById when mounted
    });

    // Update barang
    const updateBarang = async () => {
      try {
        await apiClient.put(`/barang/${route.params.id}`, barang.value); // use params.id to update barang
        alert("Barang berhasil diperbarui!");
        router.push({ name: "viewBarang", params: { id: route.params.id } }); // Redirect to view page
      } catch (error) {
        console.error("Gagal memperbarui barang:", error);
      }
    };

    // Create barang rusak report
    const barangRusak = async () => {
      try {
        const data = {
          barang_id: barang_id.value,
          description: description.value,
          tanggal: new Date().toISOString().split("T")[0],
        };
        await apiClient.post("/barangRusak", data);
        toast.success("Laporan barang Rusak berhasil disimpan!");
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
      Images,
      barangKosong,
      barangRusak,
      openModal1,
      openModal2,
      closeModal1,
      closeModal2,
      toggleDropdown,
      isDropdownOpen,
      dropdowns,
      errors,
      updateBarang,
    };
  },
};
</script>
