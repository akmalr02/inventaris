<style></style>
<template>
  <div class="bg-base-200 flex items-center justify-between w-full p-0">
    <router-link
      to="/laporan"
      class="btn btn-outline bg-black text-white gap-2 m-5"
    >
      <BackspaceIcon class="w-6 h-6 text-white" />
      Back
    </router-link>
  </div>

  <div class="hero bg-base-200 m-0 p-5 rounded-lg shadow-lg w-full">
    <div>
      <h3 class="text-6xl font-bold mb-5">Laporan Barang Kosong</h3>
      <h3 class="text-3xl text-center font-bold mb-5">
        {{ laporan?.barang?.name ?? "Barang tidak ditemukan" }}
      </h3>
      <div class="flex justify-between w-full">
        <div class="badge badge-outline mb-2 text-left">
          {{ laporan?.tanggal ?? "Tanggal tidak tersedia" }}
        </div>
        <h3 class="badge badge-outline">
          {{ laporan?.user?.name ?? "User tidak ditemukan" }}
        </h3>
      </div>
      <p class="py-4">
        {{ laporan?.description ?? "Deskripsi tidak tersedia" }}
      </p>
      <div class="m-2">
        <div class="w-full flex justify-end">
          <button
            class="btn btn-outline btn-lg flex items-center gap-2"
            @click="downloadPDF"
          >
            <ArrowDownIcon class="w-6 h-6 text-error-200-500" /> unduh laporan
          </button>
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
import apiClient from "@/service/inventaris";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { BackspaceIcon, ArrowDownIcon } from "@heroicons/vue/24/solid";
import { jsPDF } from "jspdf";

export default {
  components: {
    BackspaceIcon,
    ArrowDownIcon,
  },
  data() {
    return {
      laporan: [],
    };
  },

  created() {
    this.getLaporan();
  },

  methods: {
    async getLaporan() {
      try {
        const response = await apiClient.get(
          `/barangKosong/${this.$route.params.id}`
        );
        this.laporan = response.data;
      } catch (error) {
        toast.error("Gagal mengambil data barang.", { autoClose: 3000 });
      }
    },

    downloadPDF() {
      const doc = new jsPDF();
      const { description, tanggal, barang, user } = this.laporan;

      // Lebar halaman untuk perhitungan posisi tengah
      const pageWidth = doc.internal.pageSize.getWidth();

      // Menentukan posisi tengah untuk judul
      const title = "Laporan Barang Kosong";
      const titleWidth = doc.getTextWidth(title);
      const titleX = (pageWidth - titleWidth) / 2;

      // Menentukan ukuran font yang lebih kecil untuk nama barang
      doc.setFontSize(12);

      // Menambahkan konten ke PDF
      // Judul di tengah paling atas
      doc.setFontSize(16);
      doc.text(title, titleX, 20); // Judul berada di koordinat y = 10 (paling atas)

      // Nama barang sedikit lebih kecil di bawah judul
      doc.setFontSize(12);
      const barangName = `Nama Barang: ${barang?.name ?? "Tidak ditemukan"}`;
      const barangNameWidth = doc.getTextWidth(barangName);
      doc.text(barangName, (pageWidth - barangNameWidth) / 2, 30); // Nama barang tepat di bawah judul

      // Nama user di kiri dan tanggal di kanan di bawah nama barang
      doc.text(`Nama User: ${user?.name ?? "Tidak ditemukan"}`, 10, 55); // Nama user di kiri
      const tanggalText = `${tanggal}`;
      const tanggalWidth = doc.getTextWidth(tanggalText);
      doc.text(tanggalText, pageWidth - tanggalWidth - 20, 50); // Tanggal di kanan

      // Deskripsi dan jumlah rusak di bawahnya
      doc.text(` ${description}`, 30, 65);

      // Mengunduh file PDF
      doc.save("laporan_barang_kosong.pdf");
    },
  },
};
</script>
