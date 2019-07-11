<template>
    <div id="shop-items">
        <transition mode="out-in">
        <router-view></router-view>
            <div class="container">

                <v-snackbar
                    v-model="isAddToCart"
                    :timeout="3000"
                    :top="true"
                    color="green lighten-1"
                >
                    Товар добавлен в корзину
                    <v-btn
                        flat
                        color="black"
                        @click="setStatusAddToCart"
                    >
                        Close
                    </v-btn>
                </v-snackbar>

                <ShoppingCart/>

                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <v-app>
                            <component :is="currentViewComponent" :items="items"></component>

                            <component :is="'item_show_description'" v-if="view === 'list'"></component>

                            <div class="text-xs-center">
                                <v-pagination
                                    v-model="page"
                                    :length="parseInt(last_page)"
                                    :total-visible="7"
                                    @input="onPageChange"
                                ></v-pagination>
                            </div>
                        </v-app>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import item_view_list from './items/includes/item_view_list';
    import item_view_grid from './items/includes/item_view_grid.vue';
    import item_show_description from './items/includes/item_show_description.vue';
    import custom_input from './items/includes/custom-input.vue';
    import ShoppingCart from './ShoppingCart.vue';

    import { mapGetters } from 'vuex';

    export default {
        name: 'shop-items',
        props: [''],
        components:{
            item_view_list,
            item_view_grid,
            item_show_description,
            custom_input,
            ShoppingCart,
        },
        data(){
            return{
                items: null,
                page: 1,
                view: 'grid',
                description: '',
                last_page: 1,
                searchTextStr: '',
            }
        },
        beforeMount() {
            this.getItems(1);
        },
        computed: {
            currentViewComponent() {
                this.changeView();
                return 'item_view_' + this.view;
            },

            ...mapGetters('cart', [
                'cartTotalQuantity'
            ]),

            isAddToCart:{
                get: function () {
                    return this.$store.getters['cart/isAddToCart'];
                },
                set: function(value){
                    this.setStatusAddToCart();
                }
            },

            searchText(){
                this.getSearchText();
            },

        },
        watch:{
            searchText: 'changeSearchText',
        },
        methods: {
            getItems(pageNum = 1) {
                axios.get('/items/shop/api?page='+ pageNum)
                    .then((response) => {
                        this.items = response.data.data;
                        this.last_page = response.data.last_page;
                        this.$store.commit('products/setProducts',this.items)
                    })
                    .catch(() => {
                        console.log('handle server error from here');
                    });
            },

            onPageChange(page){
                if(this.searchTextStr === '' || this.searchTextStr === null) {
                    this.getItems(page);
                }else{
                    this.searchItemByTittle(page);
                }
            },

            changeSearchText(){
              this.description = this.searchTextStr;
            },

            changeView(){
                this.view = this.$store.getters['view/getCurrentView'];
            },

            getSearchText(){
                this.searchTextStr = this.$store.getters['view/getSearchText'];
                this.onPageChange(1);
            },

            searchItemByTittle(pageNum = 1) {
                axios.get('/items/search/api?title='+ this.searchTextStr + '&page=' + pageNum)
                    .then((response) => {
                        this.items = response.data.data;
                        this.last_page = response.data.last_page;
                    })
                    .catch(() => {
                        console.log('search title server error from here');
                    });
            },
            setStatusAddToCart(){
                this.$store.commit('cart/setStatusAddToCart',false);
            },
        },
    }
</script>
