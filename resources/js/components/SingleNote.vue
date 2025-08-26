<template>
    <q-card-section class="card-note">
        <div class="row">
            <div class="col text-left text-h6">
                <q-icon v-if="setted === 1 && state !== 'archived'" name="push_pin" class="" />
                {{ title }}
            </div>
            <div class="col col-md-auto">
                <q-icon name="archive" @click="state !== 'archived' ? archiveNote() : desarchiveNote()"
                    class=" top-0 right-0 q-mr-sm q-mt-sm btn btn-archive " />
                <q-icon name="delete" @click="deleteNote" class=" top-0 right-0 q-mr-sm q-mt-sm btn btn-delete " />
                <q-icon v-if="state !== 'archived'" name="edit_square" @click="editNote"
                    class=" top-0 right-0 q-mr-sm q-mt-sm btn btn-edit " />
            </div>
        </div>
    </q-card-section>
    <q-separator />
    <q-card-section>
        <div class="text-subtitle2">{{ content }}</div>
    </q-card-section>
</template>

<script setup lang="ts">
import { handleSubmit } from '@/hooks/handleSubmit';
import { serviceArchiveNote, serviceDeleteNote, serviceUpdateNote } from '@/services/serviceNotes';
import { Note } from '@/types/Note';
import { useQueryClient } from '@tanstack/vue-query';
import { inject, Ref, ref } from 'vue';


const props = defineProps < Note > ()
const queryClient = useQueryClient()
const mutationDelete = serviceDeleteNote(props.id);
const warningMsg = ref('¿Está seguro de que desea eliminar esta nota?');

const modal = inject < Ref < boolean >> ('modal', ref(false))
const selectedNote = inject < Ref < Note | null >> ('selectedNote', ref(null))
const queryKey = `${props.state !== 'archived' ? 'notes' : 'notes/archived'}`
const editNote = () => {
    if (selectedNote && modal) {
        selectedNote.value = {
            id: props.id,
            title: props.title,
            content: props.content,
            setted: props.setted ?? 0,
            state: props.state
        }
        modal.value = true
    }
};

const deleteNote = async () => {
    if (window.confirm(warningMsg.value)) {
        const { status, data: { message } } = await mutationDelete.mutateAsync();

        if (status !== 200) {
            window.alert('Error al eliminar la nota');
            return;
        }

        queryClient.invalidateQueries({ queryKey: [queryKey] })
        window.alert(message);
    }

};
const mutationArchive = serviceArchiveNote(props.id);
const archiveNote = async () => {
    if (window.confirm("estas seguro de archivar la nota") && selectedNote) {
        const { status, data: { message } } = await mutationArchive.mutateAsync();
        if (status !== 200) {
            window.alert('Error al archivar la nota');
            return;
        }
        window.alert(message);
        queryClient.invalidateQueries({ queryKey: ['notes'] })
    }
};
const mutationUnArchive = serviceUpdateNote(props.id);
const { onSubmit } = handleSubmit < { state: string }, Note> ({
    mutateAsync: mutationUnArchive.mutateAsync,
    onSuccess: (resp) => {
        window.alert("Nota desarchivada");
        queryClient.invalidateQueries({ queryKey: [queryKey] })
    },
    onError: (error) => {
        console.error(error);
        window.alert('Error al guardar la nota');
    }
});

const desarchiveNote = async () => onSubmit({ state: 'active' });
</script>

<style scoped lang="scss">
.btn {
    border-radius: 1px;
    padding: 5px;
    margin: 5px;
    color: $body-bg;
    border: 1px solid $borders;
}

.btn.btn-archive {
    color: $warning;
}

.btn.btn-delete {
    background-color: red;
}

.btn.btn-edit {
    background-color: $info;
}
</style>
