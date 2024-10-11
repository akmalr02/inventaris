<style>
.home {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  padding: 20px;
  margin: 10px;
  box-sizing: border-box;
  justify-content: center;
}
.box {
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: 1.2rem;
  margin: 2rem;
  flex-wrap: wrap;
  gap: 10px;
}
</style>

<template>
  <div class="home">
    <div class="container">
      <div class="box">
        <!-- Stok Barang -->
        <div
          class="max-w-md mx-auto bg-slate-200 rounded-xl shadow-md overflow-hidden md:max-w-2xl p-4"
        >
          <div class="md:flex">
            <apexchart
              width="600"
              height="500"
              type="pie"
              :options="barangsOptions"
              :series="barangsSeries"
              v-if="barangs.length > 0 && !isLoading"
            ></apexchart>

            <div v-else-if="isLoading" class="text-center w-full">
              <p>Loading...</p>
              <span class="loading loading-bars loading-md"></span>
            </div>

            <table v-else class="table-auto w-full text-left border">
              <thead>
                <tr>
                  <th class="px-4 py-2 border text-center">Stok Barang</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="px-4 py-2 border text-center" colspan="2">
                    Stok Barang Kosong!!!
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pemakaian Barang -->
        <div
          class="max-w-md mx-auto bg-slate-200 rounded-xl shadow-md overflow-hidden md:max-w-2xl p-4 m-5"
        >
          <apexchart
            width="600"
            height="500"
            type="bar"
            :options="pesananOptions"
            :series="pesananSeries"
            v-if="pesanan.length > 0 && !isLoading"
          ></apexchart>

          <div v-else-if="isLoading" class="text-center w-full">
            <p>Loading...</p>
            <span class="loading loading-bars loading-md"></span>
          </div>

          <table v-else class="table-auto w-full text-left border">
            <thead>
              <tr>
                <th class="px-4 py-2 border text-center">Pemakaian Barang</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="px-4 py-2 border text-center" colspan="2">
                  Tidak Ada Pemakaian Barang!!!
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Barang Rusak -->
        <div
          class="max-w-md bg-slate-200 rounded-xl shadow-md overflow-hidden md:max-w-2xl p-4 m-5"
        >
          <apexchart
            width="600"
            height="500"
            type="bar"
            :options="rusakOptions"
            :series="rusakSeries"
            v-if="rusak.length > 0 && !isLoading"
          ></apexchart>

          <div v-else-if="isLoading" class="text-center w-full">
            <p>Loading...</p>
            <span class="loading loading-bars loading-md"></span>
          </div>

          <table v-else class="table-auto w-full text-left border">
            <thead>
              <tr>
                <th class="px-4 py-2 border text-center">Barang Rusak</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="px-4 py-2 border text-center" colspan="2">
                  Tidak Ada Barang Rusak!!!
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <footer
    class="footer footer-center bg-base-300 text-base-content rounded p-10"
  >
    <nav class="grid grid-flow-col gap-4">
      <a class="link link-hover">About us</a>
      <a class="link link-hover">Contact</a>
      <a class="link link-hover">Jobs</a>
      <a class="link link-hover">Press kit</a>
    </nav>
    <nav>
      <div class="grid grid-flow-col gap-4">
        <a>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            class="fill-current"
          >
            <path
              d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"
            ></path>
          </svg>
        </a>
        <a>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            class="fill-current"
          >
            <path
              d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"
            ></path>
          </svg>
        </a>
        <a>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            class="fill-current"
          >
            <path
              d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"
            ></path>
          </svg>
        </a>
      </div>
    </nav>
    <aside>
      <p>
        Copyright © {new Date().getFullYear()} - All right reserved by ACME
        Industries Ltd
      </p>
    </aside>
  </footer>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";
import apiClient from "@/service/inventaris";

export default {
  components: {
    apexchart: VueApexCharts,
  },
  data() {
    return {
      isLoading: true,
      barangs: [],
      pesanan: [],
      rusak: [],
      barangsOptions: {
        chart: {
          type: "pie",
          width: 380,
        },
        labels: [],
        title: {
          text: "Stok Barang",
          align: "center",
        },
      },
      barangsSeries: [],
      pesananOptions: {
        chart: {
          type: "bar",
          height: 300,
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            distributed: true,
          },
        },
        colors: ["#33b2df", "#546E7A", "#d4526e", "#13d8aa"],
        xaxis: {
          categories: [],
        },
        title: {
          text: "Data Pemakaian Barang",
          align: "center",
        },
      },
      // pesanan
      pesananSeries: [{ name: "Jumlah Pesanan", data: [] }],
      rusakOptions: {
        chart: {
          type: "bar",
          height: 350,
        },
        plotOptions: {
          bar: {
            horizontal: true,
            barHeight: "100%",
            distributed: true,
            dataLabels: {
              position: "bottom",
            },
          },
        },
        colors: [
          "#33b2df",
          "#546E7A",
          "#d4526e",
          "#13d8aa",
          "#A5978B",
          "#2b908f",
          "#f9a3a4",
          "#90ee7e",
          "#f48024",
          "#69d2e7",
        ],
        dataLabels: {
          enabled: true,
          style: {
            colors: ["#fff"],
          },
        },
        stroke: {
          width: 1,
          colors: ["#fff"],
        },
        xaxis: {
          categories: [],
        },
        title: {
          text: "Barang Rusak",
          align: "center",
        },
      },
      rusakSeries: [{ name: "Jumlah Barang Rusak", data: [] }],
    };
  },
  created() {
    this.getData();
  },
  methods: {
    async getData() {
      await Promise.all([
        this.getBarangs(),
        this.getPesanan(),
        this.getRusak(),
      ]);
      this.isLoading = false;
    },
    async getBarangs() {
      try {
        const response = await apiClient.get("/barang");
        this.barangs = response.data;

        if (this.barangs.length > 0) {
          const labels = this.barangs.map(
            (barang) => barang.name || "Tanpa Nama"
          );
          const seriesData = this.barangs.map((barang) => barang.jumlah || 0);

          this.barangsOptions.labels = labels;
          this.barangsSeries = seriesData;
        }
      } catch (error) {
        console.error("Gagal mengambil data barang.", error);
      }
    },
    async getPesanan() {
      try {
        const response = await apiClient.get("/pesanan");
        this.pesanan = response.data;

        if (this.pesanan.length > 0) {
          const categories = this.pesanan.map(
            (pesan) => pesan.barang?.name || "Tanpa Nama"
          );
          const seriesData = this.pesanan.map(
            (pesan) => pesan.jumlah_pesanan || 0
          );

          this.pesananOptions.xaxis.categories = categories;
          this.pesananSeries[0].data = seriesData;
        }
      } catch (error) {
        console.error("Gagal mengambil data pesanan.", error);
      }
    },
    async getRusak() {
      try {
        const response = await apiClient.get("/barangRusak");
        this.rusak = response.data;

        if (this.rusak.length > 0) {
          const categories = this.rusak.map(
            (rusak) => rusak.barang?.name || "Tanpa Nama"
          );
          const seriesData = this.rusak.map((rusak) => rusak.jumlah_rusak || 0);

          this.rusakOptions.xaxis.categories = categories;
          this.rusakSeries[0].data = seriesData;
        }
      } catch (error) {
        console.error("Gagal mengambil data barang rusak.", error);
      }
    },
  },
};
</script>
