<template>
    <q-layout view="hhh lpR lff">
        <q-header reveal elevated class="bg-primary text-white">
            <q-toolbar>
                <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />
                <q-toolbar-title>
                    <q-icon name="lightbulb" />
                    Google Keep Clone
                </q-toolbar-title>
            </q-toolbar>
        </q-header>
        <q-drawer v-model="leftDrawerOpen" side="left" bordered>
            <q-list>
                <q-item v-for="item in menuItems" :key="item.to" clickable v-ripple :to="item.to" exact>
                    <q-item-section avatar v-if="item.icon">
                        <q-icon :name="item.icon" />
                    </q-item-section>
                    <q-item-section>
                        {{ item.label }}
                    </q-item-section>
                </q-item>
            </q-list>
        </q-drawer>

        <q-page-container>
            <router-view />
        </q-page-container>

    </q-layout>
</template>

<script setup>
import { ref } from 'vue'

const menuItems = [
    { label: 'Inicio', to: '/', icon: 'home' },
    { label: 'Archivadas', to: '/archived', icon: 'delete' },
]
const leftDrawerOpen = ref(true)
const toggleLeftDrawer = () => (leftDrawerOpen.value = !leftDrawerOpen.value)
</script>
