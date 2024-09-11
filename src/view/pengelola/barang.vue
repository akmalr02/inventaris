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
      <router-link to="#" class="btn btn-primary mb-3 ml-5">
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
          <th class="text-black">Gambar</th>
          <th class="text-black">Jumlah</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(laporan, index) in barangs" :key="barangs.id">
          <th>{{ index + 1 }}</th>
          <td>
            <!-- Tampilkan nama barang jika ada -->
            {{ laporan.name ?? "-" }}
          </td>
          <td>
            <!-- Tampilkan description barang jika ada -->
            {{ laporan.description ?? "-" }}
          </td>
          <td>
            <!-- Tampilkan kategori jika ada -->
            {{ laporan.category?.name_categiries ?? "-" }}
          </td>
          <td>
            <!-- Tampilkan gambar jika ada -->
            <div v-if="laporan.image">
              <img
                v-for="(img, i) in JSON.parse(laporan.image)"
                :key="i"
                :src="img"
                alt="Gambar"
                style="width: 100px; height: auto; margin-right: 5px"
              />
            </div>
            <div v-else>-</div>
          </td>
          <td>
            <!-- Tampilkan jumlah jika ada -->
            {{ laporan.jumlah ?? "-" }}
          </td>
          <!-- <td>
            <router-link
              :to="{ name: 'editBarangKosong', params: { id: laporan.id } }"
              class="btn btn-outline btn-warning mbs-2"
              ><PencilIcon
                class="size-6 text-yellow-200-500"
              />edit</router-link
            >
            <form @submit.prevent="confirmDelete(laporan.id)">
              <button type="submit" class="btn btn-outline btn-error mt-3">
                <TrashIcon class="size-6 text-error-200-500" />Delete
              </button>
            </form>
          </td> -->
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import apiClient from "@/service/inventaris";
import {
  TrashIcon,
  PencilIcon,
  BackspaceIcon,
  PlusCircleIcon,
} from "@heroicons/vue/24/solid";

export default {
  components: {
    TrashIcon,
    PencilIcon,
    BackspaceIcon,
    PlusCircleIcon,
  },
  data() {
    return {
      barangs: [],
    };
  },
  created() {
    this.getBarangs();
  },
  methods: {
    async getBarangs() {
      try {
        const response = await apiClient.get("/barang");
        this.barangs = response.data;
        console.log(this.barangs);
      } catch (error) {
        toast.error("Gagal mengambil data barang.", { autoClose: 3000 });
      }
    },
  },
};
</script>
