<template>
    <q-card style="min-width: 350px">
        <q-card-section class="row items-center q-pb-none q-mb-lg">
            <div class="text-h6">{{ titleModal }}</div>
            <q-space />
            <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>
        <q-separator class="q-mb-lg" />
        <q-card-section class="q-pt-none">
            <FormKit submit-label="Guardar" v-model="form" id="frm" validation-visibility="submit" type="form" class="row q-gutter-md"
                :incomplete-message="'Por favor corrige los campos marcados.'" @submit="submitHandler">
                <FormKit validation="required" type="text" name="title" validation-label="Título"
                    :validation-messages="{ required: 'El título es obligatorio.' }" class="col-12" label="Titulo" />
                <FormKit validation="required" type="text" name="content" validation-label="Contenido"
                    :validation-messages="{ required: 'El Contenido es obligatorio.' }" class="col-12"
                    label="Contenido" />
                <FormKit type="checkbox" label="Fijar" name="setted" :value="true" />
            </FormKit>
        </q-card-section>
    </q-card>

</template>

<script setup>
import { reset } from '@formkit/vue'
import { serviceStoreNotes, serviceUpdateNote } from '@/services/serviceNotes';
import { useQueryClient } from '@tanstack/vue-query'
import { computed, reactive, watch } from 'vue';
import { inject } from 'vue';
import { handleSubmit } from '@/hooks/handleSubmit';

const props = defineProps({ close: Boolean })
const emit = defineEmits(['update:close'])
const form = reactive({
    title: '',
    content: '',
    setted: false,
    state: 'active'
})

const selectedNote = inject('selectedNote');
const isEdit = computed(() => !!form.id)
const titleModal = computed(() => isEdit.value ? 'Editar nota' : 'Nueva nota')
const submitLbl = computed(() => isEdit.value ? 'Actualizar' : 'Guardar')
watch(selectedNote, (item) => {
    if (item) {
        form.id = item.id;
        form.title = item.title;
        form.content = item.content;
        form.setted = item.setted === 1 || item.setted === true
    }
}, { immediate: true })


const mutationStore = serviceStoreNotes();
const mutationUpdate = serviceUpdateNote(form.id);
const queryClient = useQueryClient()
const { onSubmit } = handleSubmit({
    mutateAsync: isEdit.value ? mutationUpdate.mutateAsync : mutationStore.mutateAsync,
    onSuccess: (data) => {
        emit('update:close', false)
        if (!isEdit.value) reset('frm')
        queryClient.invalidateQueries({ queryKey: [`notes`] })
    }, onError: (error) => {
        console.error(error);
        window.alert('Error al guardar la nota');
    }
});

const submitHandler = async (data) => onSubmit(data);
</script>
