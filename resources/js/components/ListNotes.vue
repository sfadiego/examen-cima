<script setup>
import { computed, provide, ref } from 'vue';
import { serviceIndexNotes } from '@/services/serviceNotes';
import CardContainer from './CardContainer.vue';
import NoteCardForm from './forms/NoteCardForm.vue';

const { data, isLoading, isError } = serviceIndexNotes();
const settedNotes = computed(() => (data.value ?? []).filter(n => n.setted))
const unsettedNotes = computed(() => (data.value ?? []).filter(n => !n.setted))
const modal = ref(false);
const selectedNote = ref(null)

provide('selectedNote', selectedNote);
provide('modal', modal);
const nuevaNota = () => {
    modal.value = true;
    selectedNote.value = null;
}
</script>

<template>
    <q-btn @click="nuevaNota" icon="add" ico color="primary" label="Nueva Nota" style="margin-bottom: 20px;" />
    <q-dialog v-model="modal" persistent>
        <NoteCardForm v-model:close="modal" />
    </q-dialog>
    <div v-if="isLoading">Cargando…</div>
    <div v-else-if="isError">Error al cargar</div>
    <CardContainer v-if="settedNotes.length > 0" :notes="settedNotes" label="Fijadas" />
    <q-separator v-if="settedNotes.length > 0" class="q-my-md" />
    <CardContainer v-if="unsettedNotes.length > 0" :notes="unsettedNotes" label="Notas" />
    <div v-if="settedNotes.length == 0 && unsettedNotes.length == 0">
        <div class="text-subtitle1">
            Sin notas
        </div>
    </div>

</template>
