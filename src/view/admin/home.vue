<style></style>
<template>
  <div class="home text-center">
    <div
      class="hero bg-base-100 min-h-screen flex flex-col justify-center items-center"
    >
      <h1 class="text-5xl font-bold mb-6">Selamat Datang di Halaman Admin!</h1>
      <p class="text-lg mb-4 p-3 min-w-full">
        Kami ucapkan selamat datang di dashboard admin aplikasi kami. Di sini,
        Anda dapat mengelola semua aspek yang berkaitan dengan inventaris dan
        data penting lainnya dengan mudah dan efisien. Halaman ini dirancang
        untuk memberikan Anda kontrol penuh atas sistem, mulai dari manajemen
        stok, pengelolaan pengguna, hingga pelaporan yang akurat dan terpercaya.
      </p>
      <p class="text-lg mb-4 p-3 min-w-full">
        Kami berkomitmen untuk memastikan bahwa semua alat yang Anda butuhkan
        tersedia di sini untuk memudahkan pekerjaan Anda. Jika Anda memiliki
        pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi tim
        dukungan kami.
      </p>
      <div class="flex flex-col lg:flex-row justify-center items-center">
        <div class="m-4 p-4 max-w-xs bg-white rounded shadow-lg">
          <h2 class="text-3xl font-bold mb-2">Laporan</h2>
          <p class="text-lg">
            Pada bagian ini menyediakan laporan dari pengelola dan pengguna anda
            bisa melihat semua jenis laporan dan mendownload nya
          </p>
          <a href="/laporan" class="btn btn-outline btn-info mt-3">view</a>
        </div>
        <div class="m-4 p-4 max-w-xs bg-white rounded shadow-lg">
          <h2 class="text-3xl font-bold mb-2">Data User</h2>
          <p class="text-lg">
            pada bagian ini menyediakan semua data pengelola dan pengguna anda
            dapat melihat, mengedit, menambahkan dan menghapus data user.
          </p>
          <a href="/dataUser" class="btn btn-outline btn-info mt-3">view</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script></script>
