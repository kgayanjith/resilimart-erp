<template>
    <div class="container-fluid px-lg-5 mt-5">
        <div>
            <h3 class="">Most Ordered Products</h3>
        </div>
        <div class="row mt-5">
            <div class="col-md-3 mb-3" v-for="product in mostorderedproducts" :key="product.id">
                <div class="product-wrapper">
                    <Link class="card rounded-4 p-1" @click="productView(product.id)">
                    <img :src="product.media[0]?.original_url" class="card-img-top w-100 rounded-3" alt="...">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <p class="product-category-text">{{ product.category.name }}</p>
                            </div>
                            <div>
                                <h5 class="card-title">Rs {{ product.price }}.00</h5>
                            </div>
                        </div>

                        <h4 class="card-title comfortaa text-truncate">{{ product.name }}</h4>
                        <div class="mb-2 d-flex align-items-center">
                            <div class="stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                            </div>
                            <div class="review-count">
                                <p class="mb-0 ps-1">4.0</p>
                            </div>
                        </div>
                        <p class="card-text two-line-clamp">{{ product.description }}</p>

                        <div class="buy-bar w-100 mt-3">
                            <button @click.stop.prevent="addToCart(product)" :disabled="isInCart(product.id)"
                                class="buy-link w-100">
                                {{ isInCart(product.id) ? 'Already in Cart' : 'Add to Cart' }}
                            </button>
                        </div>
                    </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import { mapState, mapActions } from 'vuex';

export default {
    components: {
        Link
    },
    props: {
        mostorderedproducts: Object,
    },
    computed: {
        ...mapState({
            cartItems: state => state.cartItems
        })
    },
    methods: {
        ...mapActions(['addToCart']),

        isInCart(productId) {
            return this.cartItems.some(item => item.id === productId);
        },
        productView(id) {
            this.$inertia.visit(route('product.view', id));
        }
    }
}
</script>

<style></style>