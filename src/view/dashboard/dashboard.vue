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
  <footer
    class="footer footer-center bg-base-200 text-base-content rounded p-5"
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
