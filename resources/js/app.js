import './bootstrap'
import 'es6-promise/auto'
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueAuth from '@websanova/vue-auth'
import VueRouter from 'vue-router'
import vuetify from "./plugins/vuetify";
import auth from './auth.js'
import router from './routes.js'
import store from './store'
import VueClipboard from 'vue-clipboard2'
import VueLocalStorage from 'vue-localstorage'
import Transitions from 'vue2-transitions'

Vue.use(Transitions);

window.Vue = Vue;

// Set Vue router
Vue.router = router;
Vue.use(VueRouter);
Vue.use(VueClipboard);
Vue.use(VueLocalStorage, {
    name: 'ls'
});
// Set Vue authentication
Vue.use(VueAxios, axios);
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;
Vue.use(VueAuth, auth);

Vue.component('app-base', require('./layouts/app-base.vue').default);

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store
});
