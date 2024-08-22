<template>
  <div class="flex justify-center mt-4">
    <div class="form-control z-10">
      <input
        type="text"
        placeholder="Search"
        class="input input-bordered w-24 md:w-auto"
      />
    </div>
  </div>
  <div class="overflow-x-auto">
    <table class="table">
      <!-- head -->
      <thead>
        <tr>
          <th></th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="human in humans" :key="human.id">
          <th>{{ human.id }}</th>
          <td>{{ human.name }}</td>
          <td>{{ human.email }}</td>
          <td>{{ human.role }}</td>
          <td>
            <router-link :to="{ name: 'editUser', params: { id: human.id } }"
              >edit</router-link
            >
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import apiClient from "@/service/inventaris";

export default {
  data() {
    return {
      humans: [],
    };
  },
  created() {
    this.fetchUserData();
  },
  methods: {
    async fetchUserData() {
      try {
        const response = await apiClient.get("/admin");
        this.humans = response.data;
        // this.humans = humans;
        // console.log(humans);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    },
  },
};
</script>

<style scoped>
.z-30 {
  z-index: 30;
}

.z-20 {
  z-index: 20;
}

.z-10 {
  z-index: 10;
}
</style>
