import axios, { AxiosInstance } from "axios";
const version = import.meta.env.VITE_API_VERSION || "v1";
const host =
    import.meta.env.VITE_API_HOST || `http://localhost:8000/api/${version}/`;

export const axiosApi: AxiosInstance = axios.create({
    baseURL: host,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});
