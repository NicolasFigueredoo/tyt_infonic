import { createApp } from 'vue';

let app = createApp({})
app.component('navBar', require('./page/navBar/index.vue').default);
app.mount("#page")

