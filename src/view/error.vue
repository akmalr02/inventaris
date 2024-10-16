<!-- Error402.vue -->
<template>
  <div class="background">
    <div class="error-container">
      <div class="error-content">
        <h1>404 Error!!!</h1>
        <p>
          Access Denied: You do not have permission to access this page Please
          go away now!!!
        </p>
        <button @click="goBack" class="back-button">
          Kembali ke Halaman Sebelumnya
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Error402",

  methods: {
    goBack() {
      this.$router.back();
    },
  },
};
</script>

<style scoped>
.background {
  background-image: url("/img/error.jpg");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  height: 100vh;
  width: 100%;
  position: relative;
}

.error-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  padding: 5rem;
}

.error-content {
  padding: 20px;
  border: 2px solid #ff4757;
  border-radius: 8px;
  background-color: rgba(255, 255, 255, 0.8);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

h1 {
  color: #ff4757;
  margin-bottom: 10px;
  text-align: center;
  font-size: 90px;
}

p {
  color: #333;
  margin-bottom: 20px;
  font-size: 20px;
}

.back-button {
  display: flex;
  justify-content: center;
  padding: 10px 20px;
  background-color: #ff4757;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s;
}

.back-button:hover {
  background-color: #e84118;
}
</style>
