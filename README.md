# Vue.js Inventaris

![Vue.js Logo](https://vuejs.org/images/logo.png)

## **Deskripsi**

Vue.js Inventaris adalah aplikasi frontend yang dibangun menggunakan **Vue.js 3** untuk mendukung sistem manajemen inventaris barang. Aplikasi ini menyediakan antarmuka yang dinamis dan modern dengan integrasi API backend Laravel untuk pengelolaan data inventaris.

## **Fitur**

-   **Autentikasi dengan JWT**: Mendukung login berbasis token JWT untuk keamanan.
-   **Manajemen Barang**: Menampilkan data stok barang, pemakaian barang, dan laporan barang rusak.
-   **Notifikasi Real-time**: Menampilkan pesan notifikasi menggunakan **Vue3-Toastify**.
-   **Grafik Interaktif**: Visualisasi data inventaris menggunakan **Vue3-ApexCharts**.
-   **Antarmuka Modern**: Desain responsif dengan **Tailwind CSS** dan komponen dari **DaisyUI**.
-   **Ekspor PDF**: Mengunduh laporan data dalam format PDF menggunakan **jsPDF**.

## **Instalasi**

1. **Clone Repository**:
    ```bash
    git clone https://github.com/username/vue-inventaris.git
    ```

2. **Instal Dependensi**:
    ```bash
    cd vue-inventaris
    npm install
    ```

3. **Konfigurasi File .env**:
    Buat file `.env` dan tambahkan konfigurasi berikut:
    ```env
    VITE_APP_NAME=VueInventaris
    VITE_APP_URL=http://localhost:5173
    VITE_API_BASE_URL=http://localhost:8000/api
    ```

4. **Jalankan Aplikasi**:
    ```bash
    npm run dev
    ```

5. **Akses Aplikasi**:
    Buka browser dan akses: [http://localhost:5173](http://localhost:5173)

## **Library yang Digunakan**

-   **@heroicons/vue**: Ikon modern untuk antarmuka.
-   **@vitejs/plugin-vue**: Plugin untuk mendukung Vue.js di Vite.
-   **axios**: Klien HTTP untuk komunikasi dengan API.
-   **daisyui**: Komponen UI berbasis Tailwind CSS.
-   **jsPDF**: Library untuk membuat file PDF.
-   **jwt-decode**: Untuk mendekode token JWT.
-   **pinia**: State management sederhana dan reaktif.
-   **tailwindcss**: Framework CSS untuk styling responsif.
-   **vue-router**: Manajemen routing untuk Vue.js.
-   **vue3-apexcharts**: Komponen grafik interaktif.
-   **vue3-toastify**: Library notifikasi berbasis Vue 3.

## **Struktur Folder**

```plaintext
src/
├── assets/        # File aset seperti gambar
├── components/    # Komponen Vue.js
├── router/        # Konfigurasi routing
├── store/         # Store untuk Pinia
├── views/         # Halaman aplikasi
├── App.vue        # Komponen root Vue
├── main.js        # Entry point aplikasi
