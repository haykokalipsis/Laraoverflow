
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

require ('./izitoast.js');
require ('./policies.js');

Vue.component('user-info-component', require('./components/UserInfo.vue'));
Vue.component('answer-component', require('./components/Answer.vue'));
Vue.component('favourite-component', require('./components/Favourite.vue'));
Vue.component('accept-component', require('./components/Accept.vue'));
Vue.component('vote-component', require('./components/Vote.vue'));

const app = new Vue({
    el: '#app'
});
