import { defineStore } from "pinia";

export const useNotificationStore = defineStore("notification", {
  state: () => ({
    message: "",
    type: "",
  }),
  actions: {
    setNotification(message, type) {
      this.message = message;
      this.type = type;
    },
    clearNotification() {
      this.message = "";
      this.type = "";
    },
  },
});
