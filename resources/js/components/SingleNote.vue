<template>
    <q-card-section class="card-note">
        <div class="row">
            <div class="col-1">
                <q-icon v-if="setted === 1" name="push_pin" class="absolute top-0 right-0 q-mr-sm q-mt-sm" />
            </div>
            <div class="col-10">
                <div class="text-h6">
                    {{ title }}
                </div>
            </div>
            <div class="col-1">
                <q-icon name="delete" @click="deleteNote" class="absolute top-0 right-0 q-mr-sm q-mt-sm btn-delete " />
            </div>

        </div>
    </q-card-section>
    <q-separator />
    <q-card-section>
        <div class="text-subtitle2">{{ content }}</div>
    </q-card-section>
</template>

<script setup lang="ts">
import { serviceDeleteNote, serviceIndexNotes } from '@/services/serviceNotes';
import { useQueryClient } from '@tanstack/vue-query';
import { ref } from 'vue';

const props = defineProps<{
    id: Number,
    title: String,
    content: String,
    state?: String,
    setted?: Number
}>()

const queryClient = useQueryClient()
const mutationDelete = serviceDeleteNote(props.id);
const warningMsg = ref('¿Está seguro de que desea eliminar esta nota?');

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
.btn-delete {
    border: 1px solid $primary;
    background-color: red;
    color: white;
    border-radius: 1px;
    padding: 5px;
    margin: 5px;
}
</style>
