
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
// require('./fontawesome');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue';
import VueIziToast from 'vue-izitoast';

import 'izitoast/dist/css/iziToast.min.css';

Vue.use(VueIziToast);
// or
// Vue.use(VueIziToast, defaultOptionsObject);

Vue.component('user-info-component', require('./components/UserInfo.vue'));
Vue.component('answer-component', require('./components/Answer.vue'));

const app = new Vue({
    el: '#app'
});
