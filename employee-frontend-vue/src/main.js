import { createApp } from 'vue'
import App from './App.vue'
import router from "./router";
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min'
import axios from "./http";



const app = createApp(App);
app.use(router);
app.mount('#app');
axios.interceptors.response.use(function (response) {

    return response;
}, function (error) {
    if (error.response.status === 401) {
        router.push({name : 'login'})
    }
    return Promise.reject(error);
});
app.config.globalProperties.axios = axios;
