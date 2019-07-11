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

                        <v-hover>
                            <v-card
                                slot-scope="{ hover }"
                                class="mx-auto"
                                color="grey lighten-4"
                                max-width="600"
                                height = "489.672"
                            >
                                <v-img
                                    :aspect-ratio="16/9"
                                    src="https://cdn.vuetifyjs.com/images/cards/kitchen.png"
                                >
                                    <v-expand-transition>
                                        <div
                                            v-if="hover"
                                            class="d-flex transition-fast-in-fast-out orange darken-2 v-card--reveal display-3 white--text"
                                            style="height: 100%;"
                                        >
                                            ${{ item.price }}
                                        </div>
                                    </v-expand-transition>
                                </v-img>
                                <v-card-text
                                    class="pt-4"
                                    style="position: relative;"
                                >
                                    <v-btn
                                        absolute
                                        color="orange"
                                        class="white--text"
                                        fab
                                        large
                                        right
                                        top
                                        :disabled="!item.is_active" @click="addProductToCart(item)"
                                    >
                                        <v-icon>add_shopping_cart</v-icon>
                                    </v-btn>
                                    <h3 class="display-1 font-weight-light orange--text mb-2">{{ item.title.slice(0, 100) }}</h3>
                                    <div class="font-weight-light title mb-2" v-if="item.description !== '' && item.description !== null">
                                        {{ item.description.slice(0, 100) }}
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-hover>
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
    .v-card--reveal {
        align-items: center;
        bottom: 0;
        justify-content: center;
        opacity: .5;
        position: absolute;
        width: 100%;
    }
    .v-btn--floating.v-btn--absolute{
        z-index: 1;
    }
</style>
