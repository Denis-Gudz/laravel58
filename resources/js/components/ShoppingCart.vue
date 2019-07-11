<template>
    <v-navigation-drawer
        v-model="cartDialog"
        right
        temporary
        :width="400"
        fixed
        app
    >
        <form>
          <div class="card">
              <div class="card-body">
                  <div class="card-title">
                      <v-list class="pa-1">
                          <v-list-tile avatar>
                              <v-list-tile-action>
                                  <v-btn
                                      icon
                                      @click.stop="closeCart"
                                  >
                                      <v-icon>chevron_right</v-icon>
                                  </v-btn>
                              </v-list-tile-action>

                              <v-list-tile-avatar>
                                  <v-icon>account_circle</v-icon>
                              </v-list-tile-avatar>

                              <v-list-tile-content>
                                  <v-list-tile-title>John Leider</v-list-tile-title>
                              </v-list-tile-content>
                          </v-list-tile>
                      </v-list>
                  </div>

                <p v-show="!products.length"><i>Please add some products to cart.</i></p>
                  <v-list class="pt-0" dense>
                      <v-divider></v-divider>

                      <v-list-tile
                          v-for="product in products"
                          :key="product.id"
                          @click=""
                      >
                          <v-list-tile-action>
                              <v-icon>grade</v-icon>
                          </v-list-tile-action>

                          <v-list-tile-content>
                              <v-list-tile-title>{{ product.title }}</v-list-tile-title>
                              <v-list-tile-title>{{ product.price | currency }} x {{ product.quantity }}</v-list-tile-title>
                          </v-list-tile-content>
                      </v-list-tile>
                  </v-list>
                <p>Total: {{ total | currency }}</p>
                <p><button class="btn btn-primary" :disabled="!products.length" @click="checkout(products)">Checkout</button></p>
                <p v-show="checkoutStatus">
                  <v-alert :value="true" type="success" v-if="checkoutStatus==='successful'">
                      Checkout {{ checkoutStatus }}
                  </v-alert>
                <v-alert :value="true" type="error" v-else="checkoutStatus==='failed'">
                    Checkout {{ checkoutStatus }}
                </v-alert>
                </p>
              </div>
          </div>
        </form>
    </v-navigation-drawer>
</template>

<script>
import { mapGetters, mapState } from 'vuex'

export default {
    data(){
      return{
        currency: 0,
        }
    },
  computed: {
    ...mapState({
      checkoutStatus: state => state.cart.checkoutStatus
    }),
    ...mapGetters('cart', {
      products: 'cartProducts',
      total: 'cartTotalPrice'
    }),

    cartDialog:{
        get: function () {
            return this.$store.getters['view/showCartDialog'];
        },
        set: function(value){
            this.$store.commit('view/setShowCartDialog',value);
        }
    },
  },
  methods: {
    checkout (products) {
        this.$store.dispatch('cart/checkout', products)
    },
    closeCart(){
        this.$store.commit('view/setShowCartDialog',false);
    },
  },
  beforeMount() {
    this.cartOpen = this.value;
  }
}
</script>
