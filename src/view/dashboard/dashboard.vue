<template>
  <div
    class="flex flex-col items-center justify-center h-screen bg-cover bg-center bg-fixed text-black dashboard-container"
  >
    <h1 class="text-5xl mb-8 animate-pulse">Welcome To Inventaris</h1>
    <div
      @click="navigateToLogin"
      class="w-40 h-40 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center cursor-pointer transition-all duration-700 transform hover:scale-125 logo-container"
    >
      <span class="text-4xl font-extrabold">Here</span>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    navigateToLogin() {
      const logo = document.querySelector(".logo-container");
      logo.classList.add("animate-portal");
      setTimeout(() => {
        this.$router.push("/login");
      }, 1800);
    },
  },
};
</script>

<style scoped>
.dashboard-container {
  background-image: url("img/libry.jpg");
  background-size: cover;
  background-position: center;
}

.logo-container {
  box-shadow: 0px 0px 20px 5px rgba(255, 255, 255, 0.5);
}

.animate-portal {
  animation: portalEffect 1.8s forwards ease-in-out;
}

@keyframes portalEffect {
  0% {
    transform: scale(1) rotateY(0deg);
    opacity: 1;
  }
  50% {
    transform: scale(0.5) rotateY(180deg);
    opacity: 0.8;
  }
  100% {
    transform: scale(0) rotateY(360deg);
    opacity: 0;
  }
}
</style>
