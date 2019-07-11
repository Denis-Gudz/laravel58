<template>
    <v-toolbar-items class="hidden-sm-and-down">

        <v-text-field label="Search" v-model="searchText" rounded solo-inverted clearable flat class="mt-2 hidden-sm-and-down" @click:clear="clearSearchText">
        </v-text-field>

        <v-btn icon @click="searchItemByTittle">
            <v-icon>search</v-icon>
        </v-btn>

        <v-btn icon @click="currentView">
            <v-icon v-if="view === 'list'">view_module</v-icon>
            <v-icon v-if="view === 'grid'">view_list</v-icon>
        </v-btn>

        <v-btn icon @click.stop="showCart">
            <v-badge overlap color="orange">
                <template v-slot:badge v-if="cartTotalQuantity > 0">
                    <span>{{cartTotalQuantity}}</span>
                </template>
                <v-icon>shopping_cart</v-icon>
            </v-badge>

        </v-btn>
    </v-toolbar-items>
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
