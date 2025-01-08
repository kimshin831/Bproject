import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import mixins from './mixins';
import BootstrapVue3 from 'bootstrap-vue-3';
import vue3GoogleLogin from 'vue3-google-login';

import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css';

createApp(App)
    .use(store)
    .use(router)
    .mixin(mixins)
    .use(vue3GoogleLogin, {
        clientId: '518440475104-aul8mgjiufstam3m06hhtsvnlpis8r2u.apps.googleusercontent.com'
    })
    .use(BootstrapVue3)
    .mount('#app');

window.Kakao.init('3bd79f7e9158fd56823269331562c024');
