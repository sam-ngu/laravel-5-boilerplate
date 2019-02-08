// import '@coreui/coreui'

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
// import 'vuetify/dist/vuetify.min.css'
// import 'material-design-icons-iconfont/dist/material-design-icons.css' // Ensure you are using css-loader
import './../bootstrap'
import './../plugins'
import App from './components/App.vue'
import Routes from './routes/routes'

window.Vue = Vue;

Vue.config.productionTip = false;
Vue.use(VueRouter);
Vue.use(Vuetify);







/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('app', App);

const app = new Vue({
    el: '#app',
    router: Routes,
});
