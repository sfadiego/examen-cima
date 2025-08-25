import { createRouter, createWebHistory } from "vue-router";
import Home from "../pages/IndexPage.vue";
import ArchivedPage from "../pages/ArchivedPage.vue";
import MainLayout from "../layout/MainLayout.vue";

const routes = [
    {
        path: "/",
        component: MainLayout,
        children: [
            { path: "", component: Home },
            { path: "archived", component: ArchivedPage },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
