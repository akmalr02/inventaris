<style></style>
<template>
  <div class="bg-base-200 flex items-center justify-between w-full p-0">
    <button
      @click="goBack"
      class="btn btn-outline bg-black text-white gap-2 m-5"
    >
      <BackspaceIcon class="w-6 h-6 text-white" />
      Back
    </button>
  </div>

  <div class="hero bg-base-200 m-0 p-5 rounded-lg shadow-lg w-full">
    <div class="hero-content flex-col lg:flex-row">
      <div
        v-if="data_gambar && data_gambar.length"
        class="carousel rounded-box w-80 border border-gray-300 p-2"
      >
        <div
          class="carousel-item w-full"
          v-for="(image, index) in data_gambar"
          :key="index"
        >
          <img
            :src="`${lokasi}/${image}`"
            class="w-full h-auto"
            alt="Gambar Barang"
          />
        </div>
      </div>

      <div>
        <h1 class="text-5xl font-bold mb-5">
          {{ barang.name ?? "Nama tidak ada" }}
        </h1>
        <div class="flex justify-between w-full">
          <div class="badge badge-outline mb-2 text-left">
            {{ barang.category?.name ?? "Category tidak ada" }}
          </div>
          <h3 class="badge badge-outline">
            Stok: {{ barang.jumlah ?? "Tidak ada stok barang" }}
          </h3>
        </div>
        <p class="py-4">
          {{ barang.description ?? "Tidak ada descripsi" }}
        </p>
        <div class="m-2">
          <div class="w-full flex justify-end">
            <button
              class="btn btn-outline btn-lg flex items-center gap-2"
              @click="openModal"
            >
              <ShoppingBagIcon class="w-6 h-6 text-error-200-500" />
              Pesan
            </button>
          </div>

          <!-- bagian pesanan barang  -->
          <div class="m-2">
            <dialog ref="barangModal" class="modal">
              <div class="modal-box">
                <h2 class="flex justify-center card-title text-center">
                  Buat Pesanan Barang
                </h2>
                <form @submit.prevent="pesanan" class="card-body pt-3">
                  <!-- Bagian nama Barang -->
                  <h3 class="text-center font-bold p-2">
                    Nama Barang : {{ selectedBarang?.name ?? "-" }}
                  </h3>

                  <!-- Bagian untuk memasukkan Deskripsi -->
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text">Deskripsi</span>
                    </label>
                    <textarea
                      v-model="description"
                      placeholder="Deskripsi"
                      class="textarea textarea-bordered"
                    ></textarea>
                    <div v-if="errors.description" class="error-message">
                      <span>{{ errors.description[0] }}</span>
                    </div>
                  </div>

                  <!-- Bagian untuk memilih Tanggal -->
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text">Tanggal</span>
                    </label>
                    <input
                      v-model="tanggal"
                      type="date"
                      class="input input-bordered"
                      required
                    />
                    <div v-if="errors.tanggal" class="error-message">
                      <span>{{ errors.tanggal[0] }}</span>
                    </div>
                  </div>

                  <!-- Jumlah Barang Rusak -->
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text">Jumlah Barang </span>
                    </label>
                    <input
                      v-model="jumlah_pesanan"
                      type="text"
                      inputmode="numeric"
                      placeholder="Jumlah"
                      class="input input-bordered"
                      required
                    />
                    <div v-if="errors.barangpesanan" class="error-message">
                      <span>{{ errors.barangpesanan[0] }}</span>
                    </div>
                  </div>

                  <!-- Tombol Submit -->
                  <div class="form-control mt-2">
                    <button class="btn btn-primary p-3 mb-2" type="submit">
                      Submit
                    </button>
                  </div>
                </form>
                <div class="modal-action">
                  <button class="btn" @click="closeModal">Tutup</button>
                </div>
              </div>
            </dialog>
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
import apiClient from "@/service/inventaris";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import {
  TrashIcon,
  PencilIcon,
  BackspaceIcon,
  PlusCircleIcon,
  ShoppingBagIcon,
} from "@heroicons/vue/24/solid";

export default {
  components: {
    TrashIcon,
    PencilIcon,
    BackspaceIcon,
    PlusCircleIcon,
    ShoppingBagIcon,
  },
  data() {
    return {
      barang: [],
      selectedBarang: "",
      barang_id: "",
      description: "",
      tanggal: "",
      jumlah_pesanan: "",
      lokasi: "http://inventaris.test/storage/",
      data_gambar: "",
      errors: {},
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
        this.barang_id = this.barang.id;
        // Ekstrak nama file gambar dan simpan di data_gambar
        if (this.barang.image) {
          // Hapus tanda kurung array jika masih dalam bentuk string array JSON
          const parsedImage = JSON.parse(this.barang.image);
          this.data_gambar = parsedImage; // Simpan nama file gambar
          // console.log(this.data_gambar);
        }

        // console.log(this.image);
      } catch (error) {
        toast.error("Gagal mengambil data barang.", { autoClose: 3000 });
      }
    },

    openModal() {
      this.selectedBarang = this.barang;
      this.$refs.barangModal.showModal();
      this.barang_id = this.barang.id;
      // console.log(this.barang_id);
      this.tanggal = new Date().toISOString().split("T")[0];
    },

    closeModal() {
      this.$refs.barangModal.close();
      this.errors = {};
    },

    async pesanan() {
      try {
        if (!this.barang_id) {
          toast.error("ID barang tidak valid.");
          return;
        }
        const data = {
          barang_id: this.barang_id,
          description: this.description,
          jumlah_pesanan: this.jumlah_pesanan,
          tanggal: this.tanggal,
        };

        const response = await apiClient.post("/pesanan", data);
        toast.success("Pesanan berhasil ditambahkan.", { autoClose: 3000 });
        // console.log(data);
      } catch (error) {
        // console.error("Gagal menambahkan Pesanan:", error);
        toast.error("Gagal menambahkan Pesanan.", { autoClose: 3000 });
      }
    },

    goBack() {
      this.$router.back();
    },
  },
};
</script>
