<template>
    <q-card-section class="card-note">
        <div class="row">
            <div class="col text-left text-h6">
                <q-icon v-if="setted === 1" name="push_pin" class="" />
                {{ title }}
            </div>
            <div class="col col-md-auto">
                <q-icon name="delete" @click="deleteNote" class=" top-0 right-0 q-mr-sm q-mt-sm btn btn-delete " />
                <q-icon name="edit_square" @click="editNote" class=" top-0 right-0 q-mr-sm q-mt-sm btn btn-edit " />
            </div>
        </div>
    </q-card-section>
    <q-separator />
    <q-card-section>
        <div class="text-subtitle2">{{ content }}</div>
    </q-card-section>
</template>

<script setup lang="ts">
import { serviceDeleteNote } from '@/services/serviceNotes';
import { Note } from '@/types/Note';
import { useQueryClient } from '@tanstack/vue-query';
import { inject, provide, Ref, ref } from 'vue';

const props = defineProps<Note>()

const queryClient = useQueryClient()
const mutationDelete = serviceDeleteNote(props.id);
const warningMsg = ref('¿Está seguro de que desea eliminar esta nota?');

const modal = inject<Ref<boolean>>('modal')
const selectedNote = inject<Ref<Note | null>>('selectedNote')

const editNote = () => {
    if (selectedNote && modal) {
        selectedNote.value = {
            id: props.id,
            title: props.title,
            content: props.content,
            setted: props.setted ?? 0
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

        queryClient.invalidateQueries({ queryKey: ['notes'] })
        window.alert(message);
    }

};

</script>

<style scoped lang="scss">
.btn {
    border-radius: 1px;
    padding: 5px;
    margin: 5px;
    color: white;
    border: 1px solid $primary;

}

.btn.btn-delete {
    background-color: red;
}

.btn.btn-edit {
    background-color: $primary !important;
}
</style>
