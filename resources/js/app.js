// app.js
require('./bootstrap');

import { createApp } from 'vue';
import Toast, { POSITION }  from "vue-toastification";
import "vue-toastification/dist/index.css";
import App from './App.vue';
import router from './router';

const app = createApp(App);

const optionsToast = {
    timeout: 2000,
    position: POSITION.BOTTOM_RIGHT,
};

app.use(Toast, optionsToast);
app.use(router);
app.mount('#app');
