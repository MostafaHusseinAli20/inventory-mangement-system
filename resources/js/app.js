import { createApp } from "vue";
import AppComponent from "./AppComponent.vue";
import router from "./router";
// import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css'
import * as BootstrapVueNext from 'bootstrap-vue-next'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
const app = createApp(AppComponent);

app.use(router);
app.use(BootstrapVueNext)
app.mount("#app");

console.log("Vue 3 App Initialized!");