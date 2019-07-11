import shop from '../../api/shop'

// initial state
// shape: [{ id, quantity }]
const state = {
  view: 'grid',
  showCart: false,
  searchText: '',
}

// getters
const getters = {
    getCurrentView: (state, getters) => {
        return state.view;
    },

    showCartDialog: (state, getters) => {
        return state.showCart;
    },

    getSearchText: (state, getters) => {
        return state.searchText;
    },
}

// actions
const actions = {

}

// mutations
const mutations = {
  setCurrentView (state, view) {
    state.view = view
  },

  setShowCartDialog (state, showCart) {
    state.showCart = showCart
  },

  setSearchText(state, searchText){
    state.searchText = searchText
  },
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
