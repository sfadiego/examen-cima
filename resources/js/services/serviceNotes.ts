import { useDELETE, useGET, usePOST, usePUT } from "@/hooks/useApis";
export const serviceIndexNotes = () => useGET({ url: `notes` });
export const serviceStoreNotes = () => usePOST({ url: `notes` });
export const serviceUpdateNote = (id: Number) => usePUT({ url: `notes/${id}` });
export const serviceDeleteNote = (id: Number) =>
    useDELETE({ url: `notes/${id}` });

// Archivados
export const serviceIndexArchivedNotes = () =>
    useGET({ url: `notes/archived` });
export const serviceArchiveNote = (id: Number) =>
    usePOST({ url: `notes/${id}/archive` });
