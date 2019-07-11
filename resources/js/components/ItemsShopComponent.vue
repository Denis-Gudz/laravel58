<template>
    <div id="shop-items">
        <transition mode="out-in">
        <router-view></router-view>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <v-app>
                            <ShoppingCart v-model="cartDialog"/>

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
                dialog_show: false,
                dialog: false,
                itemId: null,
                loading: false,
                page: 1,
                view: 'grid',
                description: '',
                bottomNav: 1,
                products: null,
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

            cartDialog:{
                get: function () {
                    return this.showCartDialog();
                },
                set: function(value){
                    this.$store.commit('view/setShowCartDialog',false);
                }
            },

            ...mapGetters('cart', [
                'cartTotalQuantity'
            ]),

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
            open(id){
                this.itemId = id;
                this.dialog_show = true;
                this.loading = true;
            },
            changeSearchText(){
            console.log(changeSearchText);
              this.description = this.searchTextStr;
            },
            changeView(){
                this.view = this.$store.getters['view/getCurrentView'];
            },
            showCartDialog(){
                return this.$store.getters['view/showCartDialog'];
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
        },
    }
</script>
