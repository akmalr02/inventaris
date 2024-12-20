<style></style>
<template>
  <div class="bg-white">
    <h2 class="font-bold text-center my-5 text-4xl">Products</h2>

    <div class="form-control mx-5">
      <input
        type="text"
        placeholder="Search"
        class="input input-bordered border-gray-600 w-20 md:w-48 max-w-xs"
        v-model="searchQuery"
      />
    </div>

    <div
      v-if="filteredBarang.length > 0"
      class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8"
    >
      <div
        v-for="barang in filteredBarang"
        :key="barang.id"
        class="group shadow-2xl border-2 border-gray-500 rounded-lg hover:border-gray-800 m-5"
      >
        <router-link :to="{ name: 'viewBarang', params: { id: barang.id } }">
          <div
            class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7"
          >
            <img
              :src="`${lokasi}/${barang.image[0]}`"
              alt="Barang"
              class="size-full object-cover object-center group-hover:opacity-75"
            />
          </div>
          <h3 class="m-4 text-center font-semibold text-2xl">
            {{ barang.name ?? "Nama tidak ada" }}
          </h3>
          <div class="mb-2 flex justify-between w-full">
            <div class="badge badge-outline mb-2 text-left">
              {{ barang.category?.name ?? "Category tidak ada" }}
            </div>
            <h3 class="badge badge-outline">
              Stok: {{ barang.jumlah ?? "Tidak ada stok barang" }}
            </h3>
          </div>
        </router-link>
      </div>
      <!-- More products... -->
    </div>
    <p v-else class="text-center text-red-500 font-semibold text-xl mt-5">
      Barang yang Anda cari tidak ada!!!.
    </p>
  </div>
</template>

<script>
import apiClient from "@/service/inventaris";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export default {
  data() {
    return {
      barangs: [],
      lokasi: "http://inventaris.test/storage/",
      image: [],
      searchQuery: "",
    };
  },
  created() {
    this.getBarangs();
  },

  computed: {
    filteredBarang() {
      if (!this.searchQuery) {
        return this.barangs;
      }
      const searchLower = this.searchQuery.toLowerCase();
      return this.barangs.filter((barang) => {
        const jumlahString = barang.jumlah ? barang.jumlah.toString() : "";
        return (
          barang.name?.toLowerCase().includes(searchLower) ||
          barang.description?.toLowerCase().includes(searchLower) ||
          barang.category?.name_categories
            ?.toLowerCase()
            .includes(searchLower) ||
          jumlahString.includes(searchLower)
        );
      });
    },
  },

  methods: {
    async getBarangs() {
      try {
        const response = await apiClient.get("barang");
        this.barangs = response.data.map((barang) => {
          return {
            ...barang,
            image: JSON.parse(barang.image),
          };
        });
        // console.log(this.barangs);
      } catch (error) {
        toast.error("Data tidak terpanggil!!!", error);
      }
    },
  },
};
</script>
