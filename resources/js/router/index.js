import { createRouter, createWebHistory } from "vue-router";
import EditSettingPage from "../pages/settings/edit.vue";
import SettingsPage from "../pages/settings/index.vue";
import TreasuriesPage from "../pages/treasuries/index.vue"
import TreasuriesCreatePage from "../pages/treasuries/create.vue"
import TreasuriesEditPage from "../pages/treasuries/edit.vue"
import TreasuriesDetailsPage from '../pages/treasuries/details.vue'
import TreasuriesDeliveryCreatePage from '../pages/treasuries/delivery/create.vue'

const routes = [
    {
        path: "/admin/settings",
        name: "settings.index",
        component: SettingsPage,
    },
    {
        path: "/admin/settings/edit",
        name: "settings.edit",
        component: EditSettingPage,
    },
    {
        path: "/admin/treasuries",
        name: "treasuries.index",
        component: TreasuriesPage,
    },
    {
        path: "/admin/treasuries/create",
        name: "treasuries.create",
        component: TreasuriesCreatePage,
    },
    {
        path: "/admin/treasuries/:id/edit",
        name: "treasuries.edit",
        component: TreasuriesEditPage,
    },
    {
        path: "/admin/treasuries/:id/details",
        name: "treasuries.details",
        component: TreasuriesDetailsPage,
    },
    {
        path: "/admin/treasuries/:id/delivery/create",
        name: "treasuries.delivery.create",
        component: TreasuriesDeliveryCreatePage,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
