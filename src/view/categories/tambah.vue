<style></style>
<template>
  <div class="flex justify-center items-center min-h-screen mb-6">
    <div class="card bg-base-300 w-96 shadow-xl">
      <div class="card-body">
        <h2 class="flex justify-center card-title text-center">
          Tambah Barang
        </h2>

        <form @submit.prevent="submitForm" class="card-body pt-3">
          <!-- Input Nama Barang -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Nama Barang</span>
            </label>
            <input
              type="text"
              placeholder="Nama Barang"
              class="input input-bordered"
              required
            />
          </div>

          <!-- Input Deskripsi -->
          <div class="form-control">
            <label class="label">
              <span class="label-text">Deskripsi</span>
            </label>
            <textarea
              placeholder="Deskripsi"
              class="textarea textarea-bordered"
              required
            ></textarea>
          </div>

          <div class="form-control mt-2">
            <button class="btn btn-primary p-3 mb-2" type="submit">
              Submit
            </button>
            <router-link to="/categories" class="btn btn-primary p-3">
              Kembali
            </router-link>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script></script>
