<template>
    <q-card style="min-width: 350px">

        <q-card-section class="row items-center q-pb-none">
            <div class="text-h6">Nueva nota</div>
            <q-space />
            <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section class="q-pt-none">
            <FormKit v-model="form" id="frm" validation-visibility="submit" type="form" class="row q-gutter-md"
                @submit="submitHandler">
                <FormKit validation="required" type="text" name="title" class="col-12" label="Titulo" />
                <FormKit validation="required" type="text" name="content" class="col-12" label="Contenido" />
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

watch(selectedNote, (item) => {
    if (item) {
        form.id = item.id;
        form.title = item.title;
        form.content = item.content;
        form.setted = item.setted === 1 || item.setted === true
    }
}, { immediate: true })


const mutation = serviceStoreNotes();
const mutationUpdate = serviceUpdateNote(form.id);
const queryClient = useQueryClient()
const { onSubmit } = handleSubmit({
    mutateAsync: isEdit.value ? mutationUpdate.mutateAsync : mutation.mutateAsync,
    onSuccess: (data) => {
        const { status, message, data: resp } = data;
        emit('update:close', false)
        if (!isEdit.value) reset('frm')

        queryClient.invalidateQueries({ queryKey: [`notes`] })
    },
});

const submitHandler = async (data) => {
    let submitData = { ...data };
    onSubmit(submitData);
}
</script>
