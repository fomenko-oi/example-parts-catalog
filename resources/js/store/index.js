import Vue from 'vue'
import Vuex from 'vuex'
import filter from './modules/order'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        order
    },
    strict: debug,
    plugins: []
})
