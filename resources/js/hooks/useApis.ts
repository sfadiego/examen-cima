import { axiosApi } from "@/config/axiosConfig";
import { useMutation, useQuery } from "@tanstack/vue-query";
import { AxiosInstance, AxiosRequestConfig } from "axios";

interface IAxiosProps {
    url: string;
    data?: any;
    headers?: AxiosRequestConfig["headers"];
    responseType?: AxiosRequestConfig["responseType"];
}
export interface IDELETEProps {
    url: string;
    onSuccess?: () => void;
    onError?: () => void;
}

export interface IRequestProps {
    url: string;
    onSuccess?: () => void;
    onError?: () => void;
}

const axiosGET = async (
    axios: AxiosInstance,
    { url, headers = {}, responseType = "json" }: IAxiosProps
) => {
    const response = await axios.get(`${url}`, {
        headers,
        responseType,
    });
    return response.data;
};

const axiosDELETE = async (axios: AxiosInstance, { url }: IAxiosProps) => {
    return axios.delete(`${url}`);
};

const axiosPOST = async (axios: AxiosInstance, { url, data }: IAxiosProps) => {
    return axios.post(`${url}`, data, {});
};

const axiosPUT = async (axios: AxiosInstance, { url, data }: IAxiosProps) => {
    return axios.put(`${url}`, data, {});
};


export function useGET({ url }: { url: string }) {
    return useQuery({
        queryKey: [url],
        queryFn: async () => await axiosGET(axiosApi, { url }),
        retry: false,
    });
}

export function usePOST({
    url,
    onSuccess = () => {},
    onError = () => {},
}: IRequestProps) {
    return useMutation({
        mutationFn: (data) => axiosPOST(axiosApi, { url, data }),
        onSuccess,
        onError,
    });
}

export function usePUT({
    url,
    onSuccess = () => {},
    onError = () => {},
}: IRequestProps) {
    return useMutation({
        mutationFn: (data) => axiosPUT(axiosApi, { url, data }),
        onSuccess,
        onError,
    });
}

export function useDELETE({
    url,
    onSuccess = () => {},
    onError = () => {},
}: IDELETEProps) {
    return useMutation({
        mutationFn: () => axiosDELETE(axiosApi, { url }),
        onSuccess,
        onError,
    });
}
