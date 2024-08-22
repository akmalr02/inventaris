<template>
  <h1>coba doang</h1>
  <h2>badut</h2>
</template>

<script>
import apiClient from "@/service/inventaris";

export default {
  data() {
    return {
      name: "",
      email: "",
    };
  },
  methods: {
    async fetchUserData() {
      try {
        const response = await apiClient.get("/inventaris");
        const human = response.data;
        console.log("coba doang");
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    },
  },
};
</script>
