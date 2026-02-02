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
import StoreIndexPage from '../pages/stores/index.vue';
import StoreCreatePage from '../pages/stores/create.vue';
import StoreEdirPage from '../pages/stores/edit.vue';
import UomIndexPage from '../pages/uoms/index.vue';
import UomCreatePage from '../pages/uoms/create.vue';
import UomEditPage from '../pages/uoms/edit.vue';
import ItemCardCategoryIndexPage from '../pages/item-card-categories/index.vue';
import ItemCardCategoryCreatePage from '../pages/item-card-categories/create.vue';
import ItemCardCategoryShowPage from '../pages/item-card-categories/show.vue';
import ItemCardCategoryEditPage from '../pages/item-card-categories/edit.vue';
import ItemCardIndexPage from '../pages/item-cards/index.vue';
import ItemCardCreatePage from '../pages/item-cards/create.vue';
import ItemCardEditPage from '../pages/item-cards/edit.vue';
import ItemCardShowPage from '../pages/item-cards/show.vue';

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

    //Store
    {
        path: "/admin/stores",
        name: "stores.index",
        component: StoreIndexPage,
    },
    {
        path: "/admin/stores/create",
        name: "stores.create",
        component: StoreCreatePage,
    },
    {
        path: "/admin/stores/:id/edit",
        name: "stores.edit",
        component: StoreEdirPage,
    },

    // Uoms
    {
        path: "/admin/uoms",
        name: "uoms.index",
        component: UomIndexPage,
    },
    {
        path: "/admin/uoms/create",
        name: "uoms.create",
        component: UomCreatePage,
    },
    {
        path: "/admin/uoms/:id/edit",
        name: "uoms.edit",
        component: UomEditPage,
    },

    // item-card-categories
    {
        path: "/admin/item-card-categories",
        name: "item-card-categories.index",
        component: ItemCardCategoryIndexPage,
    },
    {
        path: "/admin/item-card-categories/create",
        name: "item-card-categories.create",
        component: ItemCardCategoryCreatePage,
    },
    {
        path: "/admin/item-card-categories/:id/show",
        name: "item-card-categories.show",
        component: ItemCardCategoryShowPage,
    },
    {
        path: "/admin/item-card-categories/:id/edit",
        name: "item-card-categories.edit",
        component: ItemCardCategoryEditPage,
    },

    //item-cards
    {
        path: "/admin/item-cards",
        name: "item-cards.index",
        component: ItemCardIndexPage,
    },
    {
        path: "/admin/item-cards/create",
        name: "item-cards.create",
        component: ItemCardCreatePage,
    },
    {
        path: "/admin/item-cards/:id/edit",
        name: "item-cards.edit",
        component: ItemCardEditPage,
    },
    {
        path: "/admin/item-cards/:id/show",
        name: "item-cards.show",
        component: ItemCardShowPage,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
