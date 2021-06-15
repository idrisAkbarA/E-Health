require('./bootstrap');
window.Vue = require('vue');
import Vue from 'vue'
import Vuex from 'vuex'
import Vuetify from 'vuetify';
import store from './store/store'
import router from './router/router'
import moment from 'moment';

const vuetify = new Vuetify(
    {
        theme: {
            dark: true,
        },
    }
);

const app = new Vue({
    el: '#app-vue',
    vuetify,
    // components: { App },
    store,
    router,
});