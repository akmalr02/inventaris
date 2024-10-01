<style></style>
<template>
  <div class="hero bg-base-200 min-h-screen">
    <div class="hero-content flex-col lg:flex-row">
      <img
        :src="image"
        alt="Gambar Barang"
        class="max-w-sm rounded-lg shadow-2xl"
      />
      <div>
        <h1 class="text-5xl font-bold mb-5">{{ name }}</h1>
        <div class="flex justify-between w-full">
          <div class="badge badge-outline mb-2 text-left">{{ category }}</div>
          <h3 class="badge badge-outline">Stok: {{ jumlah }}</h3>
        </div>
        <p class="py-4">
          {{ description }}
        </p>
        <div class="m-2">
          <router-link to="/barang" class="btn btn-outline btn-primary m-3">
            <BackspaceIcon class="size-6 text-error-200-500" />
            Back</router-link
          >
          <router-link to="/barang" class="btn btn-outline btn-primary">
            <BackspaceIcon class="size-6 text-error-200-500" />
            Back</router-link
          >
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import apiClient from "@/service/inventaris";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
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
      barang: "",
      name: "",
      description: "",
      category: "",
      jumlah: "",
      image: [],
    };
  },

  created() {
    this.getBarang();
  },

  methods: {
    async getBarang() {
      try {
        const response = await apiClient.get(
          `/barang/${this.$route.params.id}`
        );
        this.barang = response.data;
        this.name = this.barang.name;
        this.description = this.barang.description;
        this.category = this.barang.category.name_categories;
        this.jumlah = this.barang.jumlah;
        this.image = JSON.parse(this.barang.image);
        console.log(this.image);
      } catch (error) {
        toast.error("Gagal mengambil data barang.", { autoClose: 3000 });
      }
    },
  },
};
</script>
