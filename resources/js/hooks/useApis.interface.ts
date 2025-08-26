import { AxiosRequestConfig } from "axios";

export interface IAxiosProps {
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

export interface IResponseData {
    status: string;
    message: string | null;
    data: any;
}
