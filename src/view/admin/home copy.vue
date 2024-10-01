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
  padding: 1.2em;
  flex-wrap: wrap;
  gap: 30px;
}
.box-item {
  flex: 1 1 200px;
  padding: 2em;
  background-color: #f3f3f3;
  border: 1px solid #ccc;
  border-radius: 8px;
  text-align: center;
}
</style>
<template>
  <div class="home">
    <div class="container">
      <div class="col-lg-6">
        <div class="box">
          <div class="box-item">
            <apexchart
              width="600"
              type="bar"
              :options="barangsOptions"
              :series="barangsSeries"
              v-if="barangs.length > 0"
            />
            <p v-else>Loading data barang...</p>
          </div>

          <div class="box-item">
            <apexchart
              width="600"
              type="bar"
              :options="pesananOptions"
              :series="pesananSeries"
              v-if="pesanan.length > 0"
            />
            <p v-else>Loading data pesanan...</p>
          </div>
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
      barangs: [],
      pesanan: [],
      barangsOptions: {
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
          textAnchor: "start",
          style: {
            colors: ["#fff"],
          },
          formatter: function (val, opt) {
            return opt.w.globals.labels[opt.dataPointIndex] + ": " + val;
          },
          offsetX: 0,
          dropShadow: {
            enabled: true,
          },
        },
        stroke: {
          width: 1,
          colors: ["#fff"],
        },
        xaxis: {
          categories: [], // Akan diisi oleh data
        },
        yaxis: {
          labels: {
            show: false,
          },
        },
        title: {
          text: "Data Barang",
          align: "center",
          floating: true,
        },
        subtitle: {
          text: "Jumlah Barang per Kategori",
          align: "center",
        },
        tooltip: {
          theme: "dark",
          x: {
            show: false,
          },
          y: {
            title: {
              formatter: function () {
                return "";
              },
            },
          },
        },
      },
      pesananOptions: {
        chart: {
          type: "bar",
          height: 350,
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            barHeight: "100%",
            distributed: true,
            dataLabels: {
              position: "top", // top, center, bottom
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
          formatter: function (val) {
            return val + "%";
          },
          offsetY: -20,
          style: {
            fontSize: "12px",
            colors: ["#304758"],
          },

          formatter: function (val, opt) {
            return opt.w.globals.labels[opt.dataPointIndex] + ": " + val;
          },
          offsetX: 0,
          dropShadow: {
            enabled: true,
          },
        },
        stroke: {
          width: 1,
          colors: ["#fff"],
        },
        xaxis: {
          categories: [], // Akan diisi oleh data
        },
        yaxis: {
          labels: {
            show: false,
          },
        },
        title: {
          text: "Data Pesanan",
          align: "center",
          floating: true,
        },
        subtitle: {
          text: "Jumlah Pesanan per Barang",
          align: "center",
        },
        tooltip: {
          theme: "dark",
          x: {
            show: false,
          },
          y: {
            title: {
              formatter: function () {
                return "";
              },
            },
          },
        },
      },
      barangsSeries: [
        {
          name: "Jumlah Barang",
          data: [], // Jumlah barang untuk setiap barang
        },
      ],
      pesananSeries: [
        {
          name: "Jumlah Pesanan",
          data: [], // Jumlah pesanan untuk setiap barang
        },
      ],
    };
  },
  created() {
    this.getBarangs();
    this.getPesanan();
  },
  methods: {
    async getBarangs() {
      try {
        const response = await apiClient.get("/barang");
        this.barangs = response.data;

        // Proses data untuk ApexCharts
        const categories = this.barangs.map(
          (barang) => barang.name ?? "Tanpa Nama"
        );
        const seriesData = this.barangs.map((barang) => barang.jumlah ?? 0);

        // Update chart options dan series
        this.barangsOptions.xaxis.categories = categories;
        this.barangsSeries[0].data = seriesData;
      } catch (error) {
        console.error("Gagal mengambil data barang.", error);
      }
    },
    async getPesanan() {
      try {
        const response = await apiClient.get("/pesanan");
        this.pesanan = response.data;

        // Proses data untuk ApexCharts
        const categories = this.pesanan.map(
          (pesan) => pesan.barang?.name ?? "Tanpa Nama"
        );
        const seriesData = this.pesanan.map(
          (pesan) => pesan.jumlah_pesanan ?? 0
        );

        // Update chart options dan series
        this.pesananOptions.xaxis.categories = categories;
        this.pesananSeries[0].data = seriesData;
      } catch (error) {
        console.error("Gagal mengambil data pesanan.", error);
      }
    },
  },
};
</script>
