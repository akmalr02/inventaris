<template></template>

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
