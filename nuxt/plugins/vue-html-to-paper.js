import Vue from 'vue';
import VueHtmlToPaper from 'vue-html-to-paper';

const options = {
    name: '_blank',
    specs: [
        'fullscreen=yes',
        'titlebar=yes',
        'scrollbars=yes'
    ],
    styles: [
        'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons',
        'https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css',
        'https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css',
    ]
}
Vue.use(VueHtmlToPaper);

