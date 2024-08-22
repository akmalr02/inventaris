import axios from "axios";

const apiClient = axios.create({
  baseURL: "http://inventaris.test/api",
  headers: {
    Accept: "application/json",
    "Content-Type": "multipart/form-data",
  },
});

apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("authToken");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

export default apiClient;
