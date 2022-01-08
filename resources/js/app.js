require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router'
import routes from './routes'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

Vue.use(VueRouter);
Vue.component('app', require('./components/App.vue').default);
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.config.productionTip = false;

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
});
