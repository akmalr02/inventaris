<style></style>

<template>
  <div
    v-if="data_gambar && data_gambar.length"
    class="carousel shadow-lg border border-gray-300 p-2"
  >
    <div
      v-for="(image, index) in data_gambar"
      :key="index"
      :id="`slide${index + 1}`"
      class="carousel-item relative w-64 h-64 flex justify-center"
    >
      <img
        :src="`${lokasi}/${image}`"
        class="h-auto max-w-full"
        alt="Gambar Barang"
        v-show="false"
      />
      <div
        class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between"
      >
        <a
          :href="`#slide${index === 0 ? data_gambar.length : index}`"
          class="btn btn-circle"
          >❮</a
        >
        <a
          :href="`#slide${index + 2 > data_gambar.length ? 1 : index + 2}`"
          class="btn btn-circle"
          >❯</a
        >
      </div>
    </div>
  </div>
</template>

<script>
import {
  UsersIcon,
  DocumentTextIcon,
  HomeIcon,
  FolderOpenIcon,
  BriefcaseIcon,
} from "@heroicons/vue/24/solid";

export default {
  components: {
    UsersIcon,
    DocumentTextIcon,
    HomeIcon,
    FolderOpenIcon,
    BriefcaseIcon,
  },
  data() {
    return {
      isLoggedIn: false,
      isMenuOpen: false,
      isDropdownOpen: false,
      tokenCheckInterval: null, // Interval untuk mengecek token
    };
  },
  created() {
    this.checkAuthStatus();
  },
  mounted() {
    // Tandai halaman dimuat untuk pertama kali
    sessionStorage.setItem("isPageRefreshed", "false");

    // Menambahkan event listener untuk sebelum halaman ditutup
    window.addEventListener("beforeunload", this.handleBeforeUnload);

    // Cek status token setiap 1 detik
    this.tokenCheckInterval = setInterval(() => {
      this.checkAuthStatus();
    }, 1000);
  },
  beforeDestroy() {
    // Hapus event listener dan interval sebelum komponen dihancurkan
    window.removeEventListener("beforeunload", this.handleBeforeUnload);
    clearInterval(this.tokenCheckInterval);
  },
  methods: {
    checkAuthStatus() {
      const token = localStorage.getItem("authToken");
      if (!token || this.isTokenExpired(token)) {
        this.isLoggedIn = false;
        localStorage.removeItem("authToken");
      } else {
        this.isLoggedIn = true;
      }
    },
    isTokenExpired(token) {
      try {
        const payload = JSON.parse(atob(token.split(".")[1]));
        return payload.exp * 1000 < Date.now(); // Cek apakah token sudah kadaluarsa
      } catch (error) {
        return true; // Jika token rusak, anggap sudah tidak valid
      }
    },
    logout() {
      localStorage.removeItem("authToken");
      this.isLoggedIn = false;
      this.$router.push({ name: "login" });
    },
    handleBeforeUnload(event) {
      // Tandai halaman sedang dimuat ulang atau ditutup
      sessionStorage.setItem("isPageRefreshed", "true");

      // Tunggu sebentar untuk memastikan browser mendeteksi apakah itu reload atau tab ditutup
      setTimeout(() => {
        const isPageRefreshed = sessionStorage.getItem("isPageRefreshed");
        if (isPageRefreshed === "false") {
          // Jika halaman ditutup, hapus token
          localStorage.removeItem("authToken");
        }
      }, 0);
    },
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
    closeMenu() {
      this.isMenuOpen = false;
    },
    homeAdmin() {
      this.$router.push({ name: "homeAdmin" });
    },
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
  },
  watch: {
    $route() {
      this.checkAuthStatus();
    },
  },

  // downloadPDF() {
  //   const doc = new jsPDF();
  //   const { description, tanggal, jumlah_rusak, barang, user } = this.laporan;

  //   // Menentukan ukuran font
  //   doc.setFontSize(16);
  //   const title = "Laporan Barang Rusak";
  //   const titleWidth = doc.getTextWidth(title);
  //   const titleX = (doc.internal.pageSize.getWidth() - titleWidth) / 2;

  //   // Menambahkan konten ke PDF
  //   doc.text(title, titleX, 20); // Judul berada di koordinat y = 20 (paling atas)
  //   doc.setFontSize(12);
  //   doc.text(`Nama Barang: ${barang?.name ?? "Tidak ditemukan"}`, 10, 30);
  //   doc.text(`Jumlah Rusak: ${jumlah_rusak}`, 10, 40);
  //   doc.text(`Deskripsi: ${description}`, 10, 50);
  //   doc.text(`Nama User: ${user?.name ?? "Tidak ditemukan"}`, 10, 60);
  //   doc.text(`Tanggal: ${tanggal}`, 10, 70);

  //   // Menambahkan QR Code
  //   if (this.laporan.image) {
  //     const parsedImage = JSON.parse(this.laporan.image);
  //     const qrValue = `${this.lokasi}${parsedImage}`; // Gabungkan lokasi dengan nama gambar

  //     // Buat instance QRCode
  //     const qr = new QRCode({
  //       element: document.createElement("canvas"),
  //       value: qrValue, // Ganti dengan nilai yang sesuai
  //       size: 150, // Ukuran QR Code
  //       background: "#ffffff", // Latar belakang putih
  //       foreground: "#000000", // Barcode hitam
  //     });

  //     // Ambil gambar QR Code dalam format base64
  //     const qrBase64 = qr.toDataURL("image/png");
  //     doc.addImage(qrBase64, "PNG", 10, 90, 50, 50); // Menambahkan QR Code ke PDF
  //   }

  //   // Mengunduh file PDF
  //   doc.save("laporan_barang_rusak.pdf");
  // },
};
</script>
