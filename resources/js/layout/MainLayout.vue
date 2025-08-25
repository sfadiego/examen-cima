<template>
    <q-layout view="hHh lpR fFf">
        <q-header elevated class="bg-primary text-white">
            <q-toolbar>
                <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />
                <q-toolbar-title>
                    <q-avatar>
                        <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
                    </q-avatar>
                    Google Keep Clone
                </q-toolbar-title>
            </q-toolbar>
        </q-header>
    </q-layout>
    <div>hola</div>
</template>

<script>
import { ref } from 'vue'

export default {
    setup() {
        const leftDrawerOpen = ref(false)
        return {
            leftDrawerOpen,
            toggleLeftDrawer() {
                leftDrawerOpen.value = !leftDrawerOpen.value
            }
        }
    }
}
</script>
