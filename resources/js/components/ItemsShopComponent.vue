<template>
    <div id="shop-items">
        <transition mode="out-in">
        <router-view></router-view>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <custom_input v-model="searchText"></custom_input>
                        <p>{{ description }}</p>

                        <v-app>
                            <ShoppingCart v-model="dialog"/>
                            <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
                                <nav class="nav nav-pills nav-fill">

                                    <v-bottom-nav
                                        :active.sync="bottomNav"
                                        :color='indigo'
                                        :value="true"
                                        absolute
                                        dark
                                        shift
                                    >

                                        <v-btn dark v-on:click="currentView = 'grid'">
                                            <span>Сетка</span>
                                            <v-icon>view_module</v-icon>
                                        </v-btn>

                                        <v-btn v-on:click="currentView = 'list'">
                                            <span>Список</span>
                                            <v-icon>view_list</v-icon>
                                        </v-btn>
                                    </v-bottom-nav>
                                </nav>

                                <v-badge left @click="dialog= true">
                                    <template v-slot:badge>
                                        <span>{{cartTotalQuantity}}</span>
                                    </template>
                                    <v-icon
                                        large
                                        color="grey lighten-1"
                                        @click="dialog= true"
                                    >
                                        shopping_cart
                                    </v-icon>
                                </v-badge>

                            </nav>
                            <br>

                            <component :is="currentViewComponent" :items="items"></component>

                            <component :is="'item_show_description'" v-if="currentView === 'list'"></component>


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
        props: ['last_page'],
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
                currentView: 'list',
                searchText:'',
                description: '',
                bottomNav: 1,
            }
        },
        beforeMount() {
            this.getItems(1);
        },
        computed: {
            currentViewComponent() {
                return 'item_view_' + this.currentView;
            },

            ...mapGetters('cart', [
                'cartTotalQuantity'
            ]),
        },
        watch:{
            searchText: 'changeSearchText',
        },
        methods: {
            getItems(pageNum = 1) {
                axios.get('/items/shop/api?page='+ pageNum)
                    .then((response) => {
                        this.items = response.data.data;
                        this.$store.commit('products/setProducts',this.items)
                    })
                    .catch(() => {
                        console.log('handle server error from here');
                    });
            },
            onPageChange(page){
                this.getItems(page);
            },
            open(id){
                this.itemId = id;
                this.dialog_show = true;
                this.loading = true;
            },
            changeSearchText(){
              this.description = this.searchText;
            },
        }
    }
</script>
