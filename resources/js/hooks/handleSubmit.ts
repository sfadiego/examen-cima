import { AxiosResponse } from "axios";

export const handleSubmit = <Request = any, Response = any>({
    mutateAsync,
    onSuccess,
    onError,
}: {
    mutateAsync: (data: Request) => Promise<AxiosResponse<any, any>>;
    onSuccess: (data: Response) => void;
    onError?: (data: Error) => void;
}) => {
    const onSubmit = async (data: Request) => {
        try {
            const res = await mutateAsync(data);
            onSuccess(res.data);
        } catch (error: any) {
            if (onError) {
                onError(error);
            } else {
                console.log(error);
            }
        }
    };

    return {
        onSubmit,
    };
};
