<template>
  <tbody>
    <tr v-for="(barang, index) in barangs" :key="barang.id">
      <th>{{ index + 1 }}</th>
      <td>{{ barang.name ?? "-" }}</td>
      <td>{{ barang.description ?? "-" }}</td>
      <td>{{ barang.category?.name_categories ?? "-" }}</td>
      <td>{{ barang.jumlah ?? "-" }}</td>
      <td>
        <router-link
          :to="{ name: 'viewBarang', params: { id: barang.id } }"
          class="btn btn-primary mr-2 mb-2"
        >
          <EyeIcon class="size-6 text-blue-100-300" /> View
        </router-link>
        <router-link
          :to="{ name: 'editBarang', params: { id: barang.id } }"
          class="btn btn-outline btn-warning mbs-2 mr-2 mb-2"
        >
          <PencilIcon class="size-6 text-yellow-200-500" /> Edit
        </router-link>
        <button class="btn" @click="openModal1(barangKosong)">
          <PlusCircleIcon class="size-6 text-blue-100-300" /> Barang Kosong
        </button>
        <button class="btn" @click="openModal2(barangRusak)">
          <PlusCircleIcon class="size-6 text-blue-100-300" /> Barang Rusak
        </button>
        <!-- <router-link
          :to="{ name: 'tambahBarangKosong', params: { id: barang.id } }"
          class="btn btn-outline text-teal-600 border-teal-600 mbs-2 mr-2 mb-2"
        >
          <PlusCircleIcon class="size-6 text-teal-200-500" /> Barang Kosong
        </router-link> -->
        <!-- <router-link
          :to="{ name: 'tambahBarangRusak', params: { id: barang.id } }"
          class="btn btn-outline text-teal-600 border-teal-600 mbs-2 mr-2 mb-2"
        >
          <PlusCircleIcon class="size-6 text-teal-200-500" /> Barang Rusak
        </router-link> -->
        <form @submit.prevent="confirmDelete(barang.id)">
          <button type="submit" class="btn btn-outline btn-error mt-3">
            <TrashIcon class="size-6 text-error-200-500" /> Delete
          </button>
        </form>
      </td>
    </tr>
  </tbody>

  <div class="m-2">
    <dialog id="barangModal" class="modal">
      <div class="modal-box">
        <h2 class="flex justify-center card-title text-center">
          Buat Laporan Barang Kosong
        </h2>
        <!-- <form @submit.prevent="createLaporan" class="card-body pt-3"> -->
          <!-- Bagian input Barang -->
          <!-- <h3 class="text-lg font-bold">{{ selectedBarang.name }}</h3> -->

          <!-- Bagian untuk memasukkan Deskripsi -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Deskripsi</span>
            </label>
            <textarea
              placeholder="Deskripsi"
              class="textarea textarea-bordered"
              required
            ></textarea>
            <!-- <div v-if="errors.description" class="error-message">
                <span>{{ errors.description[0] }}</span>
              </div> -->
          </div>

          <!-- Bagian untuk memilih Tanggal -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Tanggal</span>
            </label>
            <input type="date" class="input input-bordered" required />
            <!-- <div v-if="errors.tanggal" class="error-message">
                <span>{{ errors.tanggal[0] }}</span>
              </div> -->
          </div>

          <!-- Tombol Submit -->
          <div class="form-control mt-2">
            <button class="btn btn-primary p-3 mb-2" type="submit">
              Submit
            </button>
          </div>
        <!-- </form> -->
        <div class="modal-action">
          <button class="btn" @click="closeModal">Tutup</button>
        </div>
      </div>
    </dialog>
  </div>
  <div class="m-2">
    <dialog id="barangModal" class="modal">
      <div class="modal-box">
        <h3 class="text-lg font-bold">{{ selectedBarang.name }}</h3>
        <p class="py-4">{{ selectedBarang.description }}</p>
        <div class="modal-action">
          <button class="btn" @click="closeModal">Tutup</button>
        </div>
      </div>
    </dialog>
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
    };
  },
  created() {
    this.checkAuthStatus();
  },
  mounted() {
    // Menyimpan flag saat halaman dimuat
    sessionStorage.setItem("isPageRefreshed", "false");

    // Menambahkan event listener untuk menangani logout saat tab/jendela ditutup
    window.addEventListener("beforeunload", this.handleBeforeUnload);
    window.addEventListener("unload", this.handleUnload);
  },
  beforeDestroy() {
    // Menghapus event listener saat komponen dihancurkan
    window.removeEventListener("beforeunload", this.handleBeforeUnload);
    window.removeEventListener("unload", this.handleUnload);
  },
  methods: {
    checkAuthStatus() {
      const token = localStorage.getItem("authToken");
      this.isLoggedIn = !!token;
    },
    logout() {
      localStorage.removeItem("authToken");
      this.isLoggedIn = false;
      this.$router.push({ name: "login" });
    },
    handleBeforeUnload(event) {
      // Tandai bahwa halaman dimuat ulang jika beforeunload dipicu
      sessionStorage.setItem("isPageRefreshed", "true");

      // Tidak melakukan apa pun dalam beforeunload untuk tidak menghapus token pada refresh
    },
    handleUnload() {
      // Cek apakah halaman benar-benar ditutup atau dimuat ulang
      const isPageRefreshed = sessionStorage.getItem("isPageRefreshed");

      if (isPageRefreshed === "false") {
        // Jika halaman tidak di-refresh, hapus token (logout)
        localStorage.removeItem("authToken");
        this.isLoggedIn = false;
      }
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
};
</script>

<style>
.menu-list {
  display: flex;
  flex-direction: column;
  font-size: 0.875rem;
  line-height: 1.25rem;
  padding: 0.5rem;
}

.menu-list li {
  display: flex;
  flex-direction: column;
  align-items: stretch;
  padding: 0.5rem;
}

.menu-list li:hover {
  background-color: var(--fallback-bc, oklch(var(--bc) / 0.1));
}

.menu-list li.active {
  background-color: var(--fallback-n, oklch(var(--n) / 0.1));
  color: var(--fallback-nc, oklch(var(--nc) / 1));
}

.menu-list li.disabled {
  cursor: not-allowed;
  color: var(--fallback-bc, oklch(var(--bc) / 0.3));
}

.menu-list li > *:not(ul, .baris-title, details, .btn):active,
.menu-list li > *:not(ul, .baris-title, details, .btn).active,
.menu-list li > details > summary:active {
  background-color: var(--fallback-n, oklch(var(--n) / 1));
  color: var(--fallback-nc, oklch(var(--nc) / 1));
}

.z-10 {
  z-index: 10;
}

.z-20 {
  z-index: 20;
}
</style>
