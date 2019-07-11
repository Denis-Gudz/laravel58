import shop from '../../api/shop'

// initial state
const state = {
  all: [],
  productsSearch:[],
}

// getters
const getters = {
    getProducts: (state) => {
        return state.productsSearch;
    }
}

// actions
const actions = {
  getAllProducts ({ commit }) {
    shop.getProducts(products => {
      commit('setProducts', products)
    })
  }
}

// mutations
const mutations = {
  setProducts (state, products) {
      var arr = _.unionBy(state.all, products, 'id');
      state.all = arr;
  },

  setProductsSearch (state, products) {
      var arr = _.differenceBy(products, 'id');
      state.productsSearch = arr;
},

  decrementProductInventory (state, { id }) {
    const product = state.all.find(product => product.id === id)
    product.inventory--
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
