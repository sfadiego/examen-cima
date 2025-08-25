<template>
    <q-card style="min-width: 350px">

        <q-card-section class="row items-center q-pb-none">
            <div class="text-h6">Nueva nota</div>
            <q-space />
            <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section class="q-pt-none">
            <FormKit id="frm" validation-visibility="submit" type="form" class="row q-gutter-md"
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
import { serviceStoreNotes } from '@/services/serviceNotes';
import { useQueryClient } from '@tanstack/vue-query'

const props = defineProps({ close: Boolean })
const emit = defineEmits(['update:close'])
const mutation = serviceStoreNotes();
const queryClient = useQueryClient()
const submitHandler = async (data) => {
    const submitData = { ...data, state: 'active' };
    const { status, data: { message, errors } } = await mutation.mutateAsync(submitData);
    if (status !== 201) {
        console.log("error", errors);
        return;

    }

    window.alert(message)
    reset('frm')
    emit('update:close', false)
    queryClient.invalidateQueries({ queryKey: ['notes'] })
}
</script>
