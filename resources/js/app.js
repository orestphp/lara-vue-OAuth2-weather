/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue').default;
window.Event = new Vue();

// Vuex
import store from './store'
if (window.user) {
    store.commit(store.window.user)
} else {
    store.dispatch(actions.users.state().logged_user)
}

// Api Plugins
import apiPlugin from "./plugins";
Vue.config.productionTip = false
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
});

