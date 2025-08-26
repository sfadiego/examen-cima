<template>
    <div class="row">
        <div class="col-12">
            <label class="text-subtitle">{{ label }}</label>
        </div>
        <q-card v-for="item in notes" class="col col-sm-3 q-mr-sm q-mb-sm q-mt-sm" :key="item.id">
            <SingleNote :id="item.id" :title="item.title" :content="item.content" :state="item.state"
                :setted="item.setted" />
        </q-card>
    </div>
</template>

<script setup>
import SingleNote from './SingleNote.vue';

defineProps({
    notes: {
        type: Array,
        required: true
    },
    label: {
        type: String,
        required: true
    }
});
</script>
