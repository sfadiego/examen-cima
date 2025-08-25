import { useDELETE, useGET, usePOST } from "@/hooks/useApis";
export const serviceIndexNotes = () => useGET({ url: `notes` });
export const serviceStoreNotes = () => usePOST({ url: `notes` });
export const serviceDeleteNote = (id: Number) =>
    useDELETE({ url: `notes/${id}` });
