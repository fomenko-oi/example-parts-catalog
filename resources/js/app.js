require('./bootstrap');

require('./main');

import Vue from 'vue';
import Fragment from 'vue-fragment';
import i18n from './lang/i18n';

Vue.use(Fragment.Plugin);

Vue.component('cart-component', require('./components/Cart/CartComponent').default);
Vue.component('country-component', require('./components/Shared/Country/CountryComponent').default);
Vue.component('order-checkout-component', require('./components/Order/Checkout').default);
Vue.component('order-delivery-component', require('./components/Order/DeliveryPrice').default);

Vue.component('cabinet-orders-component', require('./components/Cabinet/Order/OrdersComponent').default);
Vue.component('cabinet-user-deposit', require('./components/Cabinet/User/Deposit/DepositComponent').default);

Vue.component('cabinet-user-payments', require('./components/Cabinet/Payments/PaymentsComponent').default);

const app = new Vue({
  el: '#app',
  i18n,
  created() {
    this.$i18n.locale = window.app_variables.lang
  }
});
