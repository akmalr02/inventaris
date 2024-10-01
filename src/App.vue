<script setup>
import navbar from "./components/layouts/navbar.vue";
// import BarChart from "./components/Chard/BarChart.vue";
// import ApexChard from "@/components/Chard/ApexChard.vue";
</script>

<template>
  <div id="app">
    <navbar />
    <RouterView />
    <!-- <BarChart /> -->
    <!-- <ApexChard /> -->
  </div>
</template>

<style scoped></style>
