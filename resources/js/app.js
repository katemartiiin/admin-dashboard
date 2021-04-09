require('./bootstrap');

import Vue from 'vue';

import VueRouter from 'vue-router';
import routes from './router';

// import { library } from '@fortawesome/fontawesome-svg-core'
// import { faPlusSquare, faTrash } from '@fortawesome/free-solid-svg-icons'
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// library.add(faPlusSquare, faTrash)

// Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.use(VueRouter)

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes)
});
