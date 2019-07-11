import Vue from 'vue'
import Vuex from 'vuex'
import cart from './modules/cart'
import products from './modules/products'
import view from './modules/view'

Vue.use(Vuex);

const debug = true;

export default new Vuex.Store({
  modules: {
    cart,
    products,
    view,
  },
  strict: debug,
  plugins: []
})
