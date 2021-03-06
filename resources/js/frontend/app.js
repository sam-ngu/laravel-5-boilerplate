
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import '../bootstrap';
import '../plugins';
import Vue from 'vue';
import Vuetify from "vuetify";
import VueRouter from "vue-router";
import VueRecaptcha from "vue-recaptcha";
import vuetifyopt from "../vuetifyopt";
import routes from './routes/routes'
import store from "../store/store";
import FrontendDashboard from "./components/dashboard/FrontendDashboard";
import BasePublic from "./components/public/BasePublic";
import BaseLogin from "./components/public/auth/login/BaseLogin";
import BaseRegistration from "./components/public/auth/registration/BaseRegistration";
import BasePasswordReset from "./components/public/auth/password/BasePasswordReset";

window.Vue = Vue;

Vue.config.productionTip = false;
Vue.use(Vuetify)
Vue.use(VueRouter)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))
Vue.component('vue-recaptcha', VueRecaptcha);
Vue.component('frontend-dashboard', FrontendDashboard);
Vue.component('base-public', BasePublic);
Vue.component('base-registration', BaseRegistration);
Vue.component('base-login', BaseLogin);
Vue.component('base-password-reset', BasePasswordReset);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    vuetify: new Vuetify(vuetifyopt),
    el: '#app',
    router: routes
    // store  // uncomment this if using vuex
});
