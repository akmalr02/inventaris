<template>
  <div v-if="options.data.length">
    <ag-charts :options="options" />
  </div>
</template>

<script>
import { AgCharts } from "ag-charts-vue3";

export default {
  props: {
    data: {
      type: Array,
      default: () => [],
    },
    title: {
      type: String,
      default: "Bar Chart",
    },
  },
  components: {
    "ag-charts": AgCharts,
  },
  data() {
    return {
      options: {
        data: [], // Inisialisasi dengan data kosong
        series: [{ type: "bar", xKey: "name", yKey: "jumlah" }],
        title: {
          text: this.title, // Judul grafik
        },
      },
    };
  },
  watch: {
    data: {
      handler() {
        if (this.data && this.data.length > 0) {
          // Update data chart ketika data berubah
          this.options.data = this.data;
        }
      },
      immediate: true, // Agar watcher dipanggil saat komponen pertama kali di-mount
      deep: true,
    },
  },
};
</script>
