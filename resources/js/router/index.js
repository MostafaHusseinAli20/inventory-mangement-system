import { createRouter, createWebHistory } from "vue-router";
import EditSettingPage from "../pages/settings/edit.vue";
import SettingsPage from "../pages/settings/index.vue";
import TreasuriesPage from "../pages/treasuries/index.vue"
import TreasuriesCreatePage from "../pages/treasuries/create.vue"
import TreasuriesEditPage from "../pages/treasuries/edit.vue"
import TreasuriesDetailsPage from '../pages/treasuries/details.vue'
import TreasuriesDeliveryCreatePage from '../pages/treasuries/delivery/create.vue'
import SalesMatrialTypesPage from "../pages/sales-matrial-types/index.vue";
import SalesMatrialTypesCreatePage from "../pages/sales-matrial-types/create.vue";
import SalesMatrialTypesEditPage from "../pages/sales-matrial-types/edit.vue";

const routes = [
    // Settings
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
    
    // Treasuries
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

    // Sales Matrial Type
    {
        path: "/admin/sales-matrial-types",
        name: "sales-matrial-types.index",
        component: SalesMatrialTypesPage,
    },
    {
        path: "/admin/sales-matrial-types/create",
        name: "sales-matrial-types.create",
        component: SalesMatrialTypesCreatePage,
    },
    {
        path: "/admin/sales-matrial-types/:id/edit",
        name: "sales-matrial-types.edit",
        component: SalesMatrialTypesEditPage,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
