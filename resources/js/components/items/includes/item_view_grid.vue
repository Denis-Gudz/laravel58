<template>
    <v-item-group>
        <v-container grid-list-md>
            <v-layout wrap>
                <v-flex
                    v-for="item in items"
                    :key="item.id"
                    xs12
                    sm4
                >
                    <v-item>
                        <v-card
                            dark
                            height="300"
                        >
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/desert.jpg"
                                aspect-ratio="2.75"
                            ></v-img>

                            <v-card-text row style="height: 100px">
                                <h3 class="headline mb-0">{{ item.title.slice(0, 100) }}</h3>
                            </v-card-text>

<!--                            <v-divider light></v-divider>-->
                            <v-card-actions class="pa-3">
                                <v-icon class="mr-1">attach_money</v-icon>
                                <span class="subheading mr-2">{{ item.price }}</span>
                                <v-spacer></v-spacer>
                                <v-btn fab dark small color="pink"
                                       :disabled="!item.is_active"
                                       @click="addProductToCart(item)">
                                    <v-icon dark>add_shopping_cart</v-icon>
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-item>
                </v-flex>
            </v-layout>
        </v-container>
    </v-item-group>
</template>

<script>
    import { mapActions } from 'vuex'
    export default {
        name: "item_view_row",
        props: ['items'],
        data(){
            return{
                show: false,
            }
        },
        methods:{
            emitMethod (description){
                EventBus.$emit('showDescription', description);
            },
            ...mapActions('cart', [
                'addProductToCart'
            ]),
        },
    }
</script>

<style scoped>

</style>
