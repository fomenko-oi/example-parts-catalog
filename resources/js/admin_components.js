import Vue from 'vue';
import Fragment from 'vue-fragment';
Vue.use(Fragment.Plugin);

Vue.component('price-ranges-component', require('./components/Admin/Delivery/Region/PriceRangesComponent').default);
Vue.component('select-country-component', require('./components/Admin/Delivery/Address/SelectCountryComponent').default);

const app = new Vue({
  el: '#app',
});
