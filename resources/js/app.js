/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import store from './Store/index';

import { createApp } from 'vue';
import App from './components/DatePicker.vue'
import App2 from './components/SearchComponent.vue'
import App4 from './components/DateLoader.vue'
import App5 from './components/DeleteLoader.vue'
import App6 from './components/EditLoader.vue'
import App7 from './components/ChangePercentageLoader.vue'
//import App4 from './components/DatePicker2.vue'

//import './index.css'

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
//import VueRouter from 'vue-router';

const app = createApp(App)

app.use(VueSweetalert2);

app.mount('#app');
const app2 = createApp(App2)
app2.use(VueSweetalert2);
app2.mount('#searchapp');

const app4 = createApp(App4)
app4.use(VueSweetalert2);
app4.mount('#modaldatepickerapp');

const app5 = createApp(App5)
app5.use(VueSweetalert2);
app5.mount('#deleteapp');

const app6 = createApp(App6)
app6.use(VueSweetalert2);
app6.mount('#editmodaldatepickerapp');

const app7 = createApp(App7)
app7.use(VueSweetalert2);
app7.mount('#modalchangeinterestrate');

//import App2 from './components/AnotherComponent.vue'
//createApp(App).mount("#app")
//createApp(App2).mount("#app2")
//import App3 from './components/TestApp.vue'
//const app3 = createApp(App3)
//app3.use(store)
//app3.mount('#app3')

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//Vue.component('another-component', require('./components/AnotherComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//const app = new Vue({
//    el: '#app',
//});
