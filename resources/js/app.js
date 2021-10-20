require('./bootstrap');
import VueFormulate from '@braid/vue-formulate';

//import vue
import Vue from 'vue';

Vue.use(VueFormulate);
//register component
Vue.component('advertising-campaign-component', require('./components/Campaign.vue').default);

//initialize vue
const app = new Vue({
    el: '#app',
});
