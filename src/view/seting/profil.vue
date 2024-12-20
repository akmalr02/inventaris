<template>
  <div class="bg-white p-6">
    <div class="flex flex-col lg:flex-row items-center gap-5">
      <!-- Kotak Gambar -->
      <div
        class="w-full lg:w-1/3 p-3 border border-gray-200 shadow-xl rounded-lg group relative"
      >
        <div
          class="aspect-w-4 aspect-h-5 overflow-hidden rounded-lg transition duration-300 ease-in-out transform group-hover:scale-105 group-hover:bg-gray-100"
        >
          <!-- Gambar Klik -->
          <img
            :src="imagePreviewUrl + '?v=' + new Date().getTime()"
            alt="Profil"
            class="h-full w-full object-cover object-center cursor-pointer"
            @click="openModal"
          />
          <!-- Overlay Icon Pensil -->
          <div
            class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg pointer-events-none"
          >
            Foto
          </div>
        </div>
      </div>

      <!-- Kotak Teks (Kartu) -->
      <div class="w-full lg:w-2/3 bg-base-200 shadow-2xl rounded-lg p-6">
        <h2 class="text-3xl font-bold text-center mb-2">Profil Anda</h2>
        <hr class="border-t border-gray-500 p-1" />

        <div class="my-5 text-xl flex justify-between">
          <span class="font-semibold">Nama:</span>
          <span>{{ name || "Tidak ada nama" }}</span>
        </div>

        <div class="my-5 text-xl flex justify-between">
          <span class="font-semibold">Email:</span>
          <span>{{ email || "Tidak ada email" }}</span>
        </div>

        <div class="my-5 text-xl flex justify-between">
          <span class="font-semibold">Nomor HP:</span>
          <span>{{ phone || "Tidak ada nomor" }}</span>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <dialog
      ref="myModal"
      id="my_modal_5"
      class="modal modal-bottom sm:modal-middle"
    >
      <div class="modal-box">
        <button
          @click="closeModal"
          class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
        >
          ✕
        </button>
        <h3 class="text-lg font-bold">Ubah Foto</h3>
        <!-- <button  class="btn ci">X</button> -->

        <!-- Tampilan image disini atau teks jika belum ada gambar -->
        <div v-if="newImage" class="my-4">
          <img
            :src="newImage"
            alt="Foto Profil Terpilih"
            class="w-full h-auto object-cover rounded-lg"
          />
        </div>
        <div v-else class="my-4 text-center text-gray-500">
          Silahkan pilih gambar
        </div>

        <div class="modal-action">
          <!-- Input File Tersembunyi -->
          <input
            ref="fileInput"
            type="file"
            @change="handleFileChange"
            class="hidden"
            accept="image/*"
          />

          <button @click="deleteProfile" class="btn btn-error">
            <TrashIcon class="size-6 text-error-200-500" /> Hapus Foto
          </button>
          <button @click="triggerFileInput" class="btn btn-primary">
            <PencilIcon class="size-6 text-yellow-200-500" /> Ganti Foto
          </button>
          <button @click="updateUser" class="btn btn-success">Submit</button>
        </div>
      </div>
      <form method="dialog" class="modal-backdrop">
        <button>close</button>
      </form>
    </dialog>

    <div class="flex flex-col lg:flex-row items-center gap-5 my-6">
      <div
        class="w-full bg-base-100 shadow-2xl rounded-lg p-3 border border-gray-200"
      >
        <div class="collapse collapse-plus bg-base-200 border border-gray-400">
          <input type="radio" name="my-accordion-3" checked="checked" />
          <div class="collapse-title text-xl font-medium">Ubah Data Anda</div>
          <div class="collapse-content flex space-x-2">
            <router-link
              :to="{ name: 'editU', params: { id: id } }"
              class="btn btn-ghost"
            >
              <PencilIcon class="size-6 text-yellow-200-500" />Edit Profil
            </router-link>
            <router-link
              :to="{ name: 'password', params: { id: id } }"
              class="btn btn-ghost"
            >
              <PencilIcon class="size-6 text-yellow-200-500" />Ubah Password
            </router-link>
          </div>
        </div>
        <div class="collapse collapse-plus bg-base-200 border border-gray-400">
          <input type="radio" name="my-accordion-3" />
          <div class="collapse-title text-xl font-medium">
            Kebijakan Privasi
          </div>
          <div class="collapse-content">
            <p><strong>Kebijakan Privasi</strong></p>
            <p>
              Kami berkomitmen untuk menjaga privasi data pengguna dan mengelola
              informasi Anda secara aman dan bertanggung jawab. Berikut adalah
              kebijakan privasi untuk aplikasi inventaris kami.
            </p>

            <p><strong>1. Informasi yang Kami Kumpulkan</strong></p>
            <ul>
              <li>
                <strong>Data Pengguna:</strong> Kami mengumpulkan data pribadi
                yang Anda berikan, seperti nama, alamat email, dan informasi
                kontak lainnya yang diperlukan untuk penggunaan aplikasi.
              </li>
              <li>
                <strong>Data Inventaris:</strong> Informasi terkait barang dan
                inventaris yang Anda kelola di dalam aplikasi.
              </li>
              <li>
                <strong>Log Penggunaan:</strong> Informasi tentang aktivitas
                Anda di aplikasi, termasuk waktu login dan penggunaan fitur
                tertentu.
              </li>
            </ul>

            <p><strong>2. Penggunaan Informasi</strong></p>
            <p>
              Informasi yang dikumpulkan akan digunakan untuk memfasilitasi
              pengelolaan inventaris, memberikan layanan yang lebih baik, dan
              mengoptimalkan fitur aplikasi. Kami juga menggunakan data untuk
              menjaga keamanan aplikasi dan mematuhi kewajiban hukum yang
              berlaku.
            </p>

            <p>
              <strong>3. Pengungkapan Informasi kepada Pihak Ketiga</strong>
            </p>
            <p>
              Kami tidak membagikan informasi pribadi Anda kepada pihak ketiga,
              kecuali diperlukan untuk pemrosesan data terkait inventaris atau
              diwajibkan oleh hukum.
            </p>

            <p><strong>4. Keamanan Data</strong></p>
            <p>
              Kami menjaga keamanan informasi Anda dengan tindakan pencegahan
              teknis dan administratif untuk melindungi data dari akses yang
              tidak sah, kebocoran, atau kerusakan.
            </p>

            <p><strong>5. Hak Pengguna</strong></p>
            <p>
              Anda memiliki hak untuk mengakses, memperbarui, atau menghapus
              data pribadi Anda kapan saja dengan menghubungi kami melalui menu
              <strong>Ubah Data Anda</strong>.
            </p>

            <p><strong>6. Perubahan Kebijakan Privasi</strong></p>
            <p>
              Kebijakan privasi ini dapat diubah dari waktu ke waktu sesuai
              dengan pembaruan pada aplikasi atau peraturan yang berlaku.
              Perubahan akan diinformasikan melalui aplikasi atau saluran
              komunikasi resmi.
            </p>

            <p><strong>7. Kontak Kami</strong></p>
            <p>
              Jika Anda memiliki pertanyaan atau keluhan terkait kebijakan
              privasi ini, silakan hubungi tim dukungan kami.
            </p>
          </div>
        </div>
        <!-- <div class="collapse collapse-plus bg-base-200 border border-gray-400">
          <input type="radio" name="my-accordion-3" />
          <div class="collapse-title text-xl font-medium">
            Click to open this one and close others
          </div>
          <div class="collapse-content">
            <p>hello</p>
          </div>
        </div> -->
      </div>
    </div>
  </div>
</template>

<script>
import apiClient from "@/service/inventaris";
import { useAuthStore } from "@/stores/authStore";
import { PencilIcon, TrashIcon } from "@heroicons/vue/24/solid";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export default {
  components: {
    PencilIcon,
    TrashIcon,
  },
  data() {
    return {
      id: "",
      name: "",
      email: "",
      phone: "",
      imageFiles: [],
      image: [],
      newImage: null,
      imagePreviewUrl: "",
      lokasi: "http://inventaris.test/storage",
    };
  },
  created() {
    this.getUser();
    const authStore = useAuthStore();
    this.$watch(
      () => authStore.user,
      () => {
        this.getUser(); // panggil ulang getUser untuk memperbarui data tampilan
      }
    );
  },
  methods: {
    getUser() {
      const authStore = useAuthStore();
      const user = authStore.user;
      this.id = user.id;
      this.name = user.name;
      this.email = user.email;
      this.phone = user.phone;

      let images = user.image ? JSON.parse(user.image) : [];
      if (Array.isArray(images) && images.length > 0) {
        this.imagePreviewUrl = `${this.lokasi}/${images[0]}`.replace(
          /[\[\]"]/g,
          ""
        );
      } else {
        this.imagePreviewUrl = "/img/profil.jpg";
      }
    },
    openModal() {
      this.$refs.myModal.showModal();
    },
    closeModal() {
      this.$refs.myModal.close();
    },
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    handleFileChange(event) {
      const files = Array.from(event.target.files);
      const validFiles = files.filter(
        (file) => file.type.startsWith("image/") && file.size <= 2048 * 1024
      );

      if (validFiles.length > 0) {
        if (this.newImage) {
          URL.revokeObjectURL(this.newImage);
        }
        this.imageFiles = [validFiles[0]];
        this.newImage = URL.createObjectURL(validFiles[0]);
      } else {
        toast.error("File harus berupa gambar dan tidak melebihi 2MB.", {
          autoClose: 3000,
        });
      }
    },

    async updateUser() {
      const formData = new FormData();
      this.imageFiles.forEach((image) => {
        formData.append("image[]", image);
      });

      formData.append("_method", "PATCH");

      try {
        const authStore = useAuthStore();
        const userId = authStore.user.id;
        const response = await apiClient.post(`/profil/${userId}`, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        if (response.status === 200) {
          const updatedImage = response.data.image;
          const updatedUser = {
            ...authStore.user,
            image: JSON.stringify([updatedImage]),
          };

          authStore.updateUser(updatedUser); // Panggil metode updateUser dari Pinia store
          toast.success("Profil berhasil diperbarui.", { autoClose: 3000 });
          this.imagePreviewUrl = `${
            this.lokasi
          }/${updatedImage}?t=${new Date().getTime()}`;
          this.getUser();
        }
      } catch (error) {
        toast.error("Gagal memperbarui profil. Coba lagi nanti.", {
          autoClose: 3000,
        });
      }
    },

    async deleteProfile() {
      try {
        const confirmation = confirm(
          "Apakah Anda yakin ingin menghapus profil ini?"
        );
        if (confirmation) {
          const authStore = useAuthStore();
          const userId = authStore.user.id;

          // Menggunakan route yang baru dibuat untuk menghapus gambar
          const response = await apiClient.delete(
            `/profil/${userId}/destroy-image`
          );

          if (response.status === 200) {
            alert("Gambar berhasil dihapus.");

            // Update state gambar di Pinia store dan frontend
            authStore.updateUser({ image: null });
            this.imagePreviewUrl = "/img/profil.jpg"; // Reset gambar preview

            // Arahkan pengguna ke halaman login jika perlu
            // this.$router.push("/login");
          }
        }
      } catch (error) {
        alert("Gagal menghapus gambar profil. Coba lagi nanti.");
      } finally {
        this.closeModal();
      }
    },
  },
};
</script>
