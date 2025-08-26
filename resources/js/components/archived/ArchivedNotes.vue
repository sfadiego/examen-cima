<script setup lang="ts">
import { computed, watchEffect } from 'vue';
import { serviceIndexArchivedNotes } from '@/services/serviceNotes';
import { Note } from '@/types/Note';
import CardContainer from '../CardContainer.vue';

const { data, isLoading, isError } = serviceIndexArchivedNotes();
const notas = computed<Note[]>(() => data.value?.data ?? [])
</script>

<template>
    <div v-if="isLoading">Cargando…</div>
    <div v-else-if="isError">Error al cargar</div>
    <div v-else-if="notas.length == 0">No tienes notas archivadas</div>
    <CardContainer v-else-if="notas.length > 0" :notes="notas" label="Archivadas" />
</template>
