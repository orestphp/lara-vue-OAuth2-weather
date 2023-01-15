import VueAxios from 'vue-axios';
import VueSocialauth from 'vue-social-auth';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue').default;

// VueSocialauth
Vue.use(VueAxios, axios);
Vue.use(VueSocialauth, {
    providers: {
        google: {
            clientId: `${process.env.MIX_APP_OAUTH_CLIENT_ID}`,
            client_secret: `${process.env.MIX_APP_OAUTH_CLIENT_SECRET}`,
            redirectUri: `${process.env.MIX_API_URL}/google/callback`
        }
    }
});

// Vuex
import Vuex from 'vuex';
Vue.use(Vuex)
import store from './store';

// Check user
store.dispatch('getUser');

// Api Plugins
import apiPlugin from "./plugins";
Vue.config.productionTip = false;
Vue.use(apiPlugin);


// Router
import VueRouter from 'vue-router';
import router from './routes.js';
Vue.use(VueRouter);

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    router,
    store,
});

