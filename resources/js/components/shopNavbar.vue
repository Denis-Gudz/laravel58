<template>
    <div>



        <v-btn light>
            <v-text-field label="Search" v-model="searchText" single-line clearable flat full-width class="mt-n2" @click:clear="clearSearchText">
            </v-text-field>
        </v-btn>

        <v-btn icon @click="searchItemByTittle">
            <v-icon>search</v-icon>
        </v-btn>

        <v-btn icon @click="currentView">
            <v-icon v-if="view === 'list'">view_module</v-icon>
            <v-icon v-if="view === 'grid'">view_list</v-icon>
        </v-btn>

        <v-btn icon @click="showCart">
            <v-badge overlap color="orange">
                <template v-slot:badge v-if="cartTotalQuantity > 0">
                    <span>{{cartTotalQuantity}}</span>
                </template>
                <v-icon>shopping_cart</v-icon>
            </v-badge>

        </v-btn>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        name: "navbar",
        data(){
            return{
               view: 'grid',
               searchText:'',
            }
        },
        computed:{
            ...mapGetters('cart', [
                'cartTotalQuantity'
            ]),
        },
        methods:{
            currentView(){
                this.view = (this.view === 'grid') ? 'list' : 'grid';
                this.$store.commit('view/setCurrentView',this.view);
            },
            showCart(){
                this.$store.commit('view/setShowCartDialog',true);
            },
            searchItemByTittle(){
                this.$store.commit('view/setSearchText',this.searchText);
            },
            clearSearchText(){
                this.searchText = '';
                this.searchItemByTittle();
            }
        },
    }
</script>

<style scoped>

</style>
